@extends('layout.layout')

@section('body')
<head>
    <!-- Include required CSS and JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color:white;
        }

        #reports-container {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            /* box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px; */
        }

       

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .action-buttons-rep {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .custom-btn-sm-rep {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-report-btn { background-color: #ff4444; color: white; }
        .block-user-btn { background-color: #ff8800; color: white; }
        .view-user-btn { background-color: #2196F3; color: white; }

        .custom-btn-sm-rep:hover {
            opacity: 0.8;
        }

        @media (max-width: 1024px) {
            #reports-container {
                padding: 15px;
            }
            th, td {
                padding: 10px;
            }
        }

        @media (max-width: 768px) {
            th, td {
                font-size: 14px;
                padding: 8px;
            }

            .action-buttons-rep {
                gap: 5px;
            }

            .custom-btn-sm-rep {
                padding: 6px 10px;
            }
        }

        @media (max-width: 480px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            th, td {
                font-size: 13px;
                padding: 6px;
            }
            .action-buttons-rep {
                flex-direction: column;
            }
            .custom-btn-sm-rep {
                width: 100%;
                text-align: center;
            }
        }

    @media (max-width: 767px) {
        #reports-container  {
            margin-top: 70px !important;
            padding-top: 0 !important;
        }
    }


    </style>
</head>

<body>
    <section id="reports-container">
        <h4 style=" text-align: center;">Reported Users</h4>
        <div id="reports-content">
            <table>
                <thead>
                    <tr>
                        <th>Sr. #</th>
                        <th>Reported By</th>
                        <th>Reported User</th>
                        <th>Reason</th>
                        <th>Actions</th>
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
            fetchReports();

            function fetchReports() {
                fetch('/reports')
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.getElementById('reports-table-body');
                        tbody.innerHTML = '';
                        if (data.reports && data.reports.length > 0) {
                            data.reports.forEach((report, index) => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${index + 1}</td>
                                    <td>${report.user.name}</td>
                                    <td>${report.reporteduser.name}</td>
                                    <td>${report.reason || 'No reason provided'}</td>
                                    <td>
                                        <div class="action-buttons-rep">
                                            <button class="delete-report-btn custom-btn-sm-rep" data-report-id="${report.id}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <button class="user-block-action-btn custom-btn-sm-rep ${report.is_blocked ? 'unblock-btn' : 'block-btn'}"
                                                    data-user-id="${report.user_id}"
                                                    data-action="${report.is_blocked ? 'unblock' : 'block'}">
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
                            tbody.innerHTML = '<tr><td colspan="5">No reports found.</td></tr>';
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
            window.open(`/forum/topic/${forumTopicId}`, '_blank');
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
