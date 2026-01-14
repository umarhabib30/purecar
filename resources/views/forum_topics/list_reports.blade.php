@extends('layout.superAdminDashboard')
@section('body')
<head>
    <!-- Include required CSS and JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        #reports-container {
            padding: 20px;
            margin: 20px;
            width: 100%;
            box-sizing: border-box;
        }
        table {
            width: 95%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow-x: auto;
            display: block;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        td:nth-child(2) {
            max-width: 150px;
            width: auto;
            white-space: normal;
            word-wrap: break-word;
        }
        td:nth-child(3) {
            min-width: 300px;
            width: auto;
            white-space: normal;
            word-wrap: break-word;
        }
        .action-buttons-rep {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .custom-btn-sm-rep {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .delete-report-btn {
            background-color: #ff4444;
            color: white;
        }
        .block-user-btn {
            background-color: #ff8800;
            color: white;
        }
        .view-user-btn {
            background-color: #2196F3;
            color: white;
        }
        .custom-btn-sm-rep:hover {
            opacity: 0.8;
        }
        @media (max-width: 768px) {
            #reports-container {
                padding: 10px;
                margin: 10px;
            }
            th, td {
                padding: 8px;
            }

            td:nth-child(3) {
                max-width: 200px;
            }

            .action-buttons-rep {
                gap: 5px;
            }

            .custom-btn-sm-rep {
                padding: 4px 8px;
            }
        }

        @media (max-width: 480px) {
            th, td {
                font-size: 14px;
            }

            td:nth-child(3) {
                max-width: 150px; /* Further reduce max-width for small screens */
            }

            .action-buttons-rep {
                flex-direction: column; /* Stack buttons vertically */
            }

            .custom-btn-sm-rep {
                width: 100%; /* Full-width buttons */
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <!-- Reports Container -->
    <section id="reports-container">
        <h2>Reported Users</h2>
        <div id="reports-content">
            <table >
                <thead>
                    <tr>
                        <th id="th1">Sr. #</th>
                        <th id="th2">Reported By</th>
                        <th id="th2">Reported User</th>
                        <th id="th3">Reason</th>
                        <th id="th4">Actions</th>
                    </tr>
                </thead>
                <tbody id="reports-table-body">
                    <!-- Dynamic Content -->
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initial load of reports
            console.log('DOM Content Loaded');
            fetchReports();
            function fetchReports() {
                console.log('Fetching reports...');

                fetch('/reports')
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Received data:', data);

                        if (!data || !data.reports) {
                            console.error('Invalid data structure:', data);
                            throw new Error('Invalid data structure received');
                        }

                        const reports = data.reports;
                        const tbody = document.getElementById('reports-table-body');

                        if (!tbody) {
                            console.error('Table body element not found');
                            return;
                        }

                        tbody.innerHTML = '';

                        if (reports && reports.length > 0) {
                            reports.forEach((report, index) => {
                                console.log('Processing report:', report);

                                if (!report.user || !report.user.name) {
                                    console.error('Invalid report structure:', report);
                                    return;
                                }

                                const row = document.createElement('tr');
                                // Inside your fetchReports function, modify the button HTML:
                                row.innerHTML = `
                                    <td>${index + 1}</td>
                                    <td>${report.user.name}</td>
                                    <td>${report.reporteduser.name}</td>                                 
                                    <td>${report.reason || 'No reason provided'}</td>
                                    <td>
                                        <div class="action-buttons-rep">
                                            <button class="delete-report-btn custom-btn-sm-rep" data-report-id="${report.id}" data-user-id="${report.user.id}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button class="user-block-action-btn custom-btn-sm-rep ${report.is_blocked ? 'unblock-btn' : 'block-btn'}"
                                                    data-user-id="${report.user_id}"
                                                    data-action="${report.is_blocked ? 'unblock' : 'block'}"
                                                    title="${report.is_blocked ? 'Unblock User' : 'Block User'}">
                                                <i class="fas ${report.is_blocked ? 'fa-unlock' : 'fa-ban'}"></i>
                                            </button>
                                            <button class="view-user-btn custom-btn-sm-rep" data-forum-topic-id="${report.forum_topic_id}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                `;
                                tbody.appendChild(row);
                            });

                            addEventListeners();
                        } else {
                            tbody.innerHTML = '<tr><td colspan="4">No reports found.</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error in fetchReports:', error);
                        const tbody = document.getElementById('reports-table-body');
                        if (tbody) {
                            tbody.innerHTML = '<tr><td colspan="4">No reports.</td></tr>';
                        }
                    });
            }

            function addEventListeners() {
    // Delete report button event listeners
    document.querySelectorAll('.delete-report-btn').forEach(button => {
        button.addEventListener('click', function() {
            const reportId = this.dataset.reportId;
            deleteReport(reportId);
        });
    });

    // Block/Unblock user button event listeners
    document.querySelectorAll('.user-block-action-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const action = this.dataset.action;
            handleUserBlockAction(userId, action);
        });
    });

    // View user button event listeners
    document.querySelectorAll('.view-user-btn').forEach(button => {
        button.addEventListener('click', function() {
            const forumTopicId = this.dataset.forumTopicId;
            window.open(`forum/topic/${forumTopicId}`, '_blank');
        });
    });
}

function handleUserBlockAction(userId, action) {
    const isBlocking = action === 'block';
    const endpoint = isBlocking ? '/forum/block/user/' : '/forum/unblock/user/';

    Swal.fire({
        title: `${isBlocking ? 'Block' : 'Unblock'} User?`,
        text: isBlocking ?
            'This will block the user from accessing the forum' :
            'This will restore the user\'s access to the forum',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: isBlocking ? '#dc3545' : '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: isBlocking ? 'Yes, block user!' : 'Yes, unblock user!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`${endpoint}${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: isBlocking ? 'Blocked!' : 'Unblocked!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: isBlocking ? '#dc3545' : '#28a745'
                    });
                    fetchReports();
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'An error occurred while processing your request.', 'error');
            });
        }
    });
}
            function deleteReport(reportId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/forum/report/delete/${reportId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Deleted!', 'The report has been deleted.', 'success');
                                fetchReports(); // Refresh the reports list
                            } else {
                                Swal.fire('Error', 'Failed to delete the report.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'An error occurred while deleting the report.', 'error');
                        });
                    }
                });
            }

            function blockUser(userId) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will block the user from accessing the forum",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, block user!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/forum/block/user/${userId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                            body: JSON.stringify({ user_id: userId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Blocked!', 'The user has been blocked.', 'success');
                                fetchReports(); // Refresh the reports list
                            } else {
                                Swal.fire('Error', 'Failed to block the user.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'An error occurred while blocking the user.', 'error');
                        });
                    }
                });
            }
        });
    </script>
</body>
@endsection
