@extends('layout.superAdminDashboard')

@section('body')
    <section id="blogs-container-forum">
        <h2>Forums</h2>
        <div id="blogs-content-forum">
            <!-- Top Bar with Add Button and Reports Button -->
            <div class="forum-buttons">
               
                <div class="forum-buttons-2 ms-lg-auto">
                    <div id="add-blog-forum" class="d-flex align-items-center">
                        <button id="add-blog-btn-forum" class="" onclick="window.location.href = '{{ url('/create-forum-topic') }}'">
                            <img src="assets/adminPanelAssets/bs/add.svg" id="add-icon" alt="Add Icon" class="me-2"> Add Forum Topic
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table for Forum Topics -->
            <div class="table-responsive">
                <table class="table table-hover" style="overflow-x: auto;">
                    <thead>
                        <tr>
                            <th>Sr. #</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date Posted</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forum_topics as $forum_topic)
                            <tr onclick="window.location='{{ route('forum-topic.details', ['forum_topic' => $forum_topic->id]) }}'" style="cursor: pointer;">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $forum_topic->title }}</td>
                                <td style="min-width: 350px;">{{ $forum_topic->forumTopicCategories->pluck('category')->implode(', ') }}</td>
                                <td style="min-width: 120px;">{{ $forum_topic->created_at->format('M d, Y') }}</td>
                                <td class="two-buttons">
                                    <a href="{{ route('forum-topic.edit', ['forum_topic' => $forum_topic->id]) }}" class="btn btn-sm btn-warning">Update</a>
                                    <a href="{{ route('forum-topic.delete', ['forum_topic' => $forum_topic->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 my-pagination-container">
                {{ $forum_topics->links('vendor.pagination.custom-pagination') }}
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
       document.getElementById('view-reports-btn').addEventListener('click', function() {
        fetch('/reports')
            .then(response => response.json())
            .then(data => {
                const reports = data.reports;

                if (reports.length > 0) {
                    let reportHtml = `
                        <table>
                            <thead>
                                <tr>
                                    <th>Reported By</th>
                                    <th>Reason</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    reports.forEach(report => {
                        reportHtml += `
                            <tr>
                                <td>${report.user.name}</td>
                                <td>${report.reason}</td>
                            <td>
                                    <div class="action-buttons-rep">
                                        <button class="delete-report-btn custom-btn-sm-rep" data-report-id="${report.id}" data-user-id="${report.user.id}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        <button class="block-user-btn custom-btn-sm-rep" data-user-id="${report.user.id}">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <button class="view-user-btn custom-btn-sm-rep" data-forum_topic_id="${report.forum_topic_id}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    reportHtml += `
                        </tbody>
                    </table>
                    `;

                    Swal.fire({
                        title: 'Reported Users',
                        html: reportHtml,
                        showCancelButton: true,
                        confirmButtonText: 'Close',
                        cancelButtonText: 'Cancel',
                    });

                    document.querySelectorAll('.delete-report-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const reportId = this.dataset.reportId;
                            deleteReport(reportId);
                        });
                    });

                    document.querySelectorAll('.block-user-btn').forEach(button => {
                        button.addEventListener('click', function() {
                            const userId = this.dataset.userId;
                            blockUser(userId);
                        });
                    });

                    document.querySelectorAll('.view-user-btn').forEach(button => {
                        button.addEventListener('click', function () {
                            const forum_topic_id = this.dataset.forum_topic_id;
                            console.log(forum_topic_id);
                            window.open(`forum/topic/${forum_topic_id}`, '_blank');
                        });
                    });


                } else {
                    Swal.fire('No reports found', 'There are no reports for this topic.', 'info');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('No reports found', 'There are no reports for this topic.');
            });
    });



    function deleteReport(reportId) {
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
                Swal.fire('Report deleted', 'The report has been deleted successfully.', 'success');
            } else {
                Swal.fire('Error', 'An error occurred while deleting the report.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'An error occurred while deleting the report.', 'error');
        });
    }

    function blockUser(userId) {
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
                Swal.fire('User blocked', 'The user has been blocked successfully.', 'success');
            } else {
                Swal.fire('Error', 'An error occurred while blocking the user.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'An error occurred while blocking the user.', 'error');
        });
    }

    </script>
    <style>
        #blogs-container-forum {
            padding: 20px;
        }
        .forum-buttons{
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }
        #add-blog-btn-forum {
            background-color: black;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 14px;
        }
        .two-buttons{
            display: flex;
            gap: 5px;
            align-items: center;
            justify-content: center;
        }
        @media (max-width: 768px) {
            #add-blog-forum {
                flex-direction: column;
                align-items: flex-start;
            }

            .forum-buttons{
                flex-direction: column;
                justify-content: end;
                align-items: end;
                gap: 6px;
            }
            .two-buttons{
                flex-direction: column;
            }
            .reports-forum {
                text-align: left !important;
                margin-top: 10px;
            }
        }
    </style>
@endsection
