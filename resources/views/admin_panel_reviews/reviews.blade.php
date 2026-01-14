@extends('layout.superAdminDashboard')
@section('body')
<section id="reviews-container">
    <h2>Reviews</h2>
    <div id="reviews-content">
        <div id="top-bar">
            <div id="search-bar">
                <img src="assets/search-icon.png" alt="Search" id="search-icon">
                <input type="search" placeholder="Search" id="input">
            </div>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Seller Name</th>
                        <th>Reviewer Name</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">
                    @foreach($all_reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->seller_name ?? 'N/A' }}</td>
                        <td>{{ $review->author_name ?? 'N/A' }}</td>
                        <td style="max-width: 200px; word-wrap: break-word; overflow-wrap: break-word;">
                            {{ $review->reviews }}
                        </td>

                        <td>{{ $review->rating }}</td>
                        <td>
                            <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif
</section>
<script>
    // Your existing search script
    document.getElementById('input').addEventListener('input', function () {
        const searchQuery = this.value.toLowerCase();
        const rows = document.querySelectorAll('#user-table-body tr');
        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            if (name.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);
    });
    </script>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
#reviews-container {
    max-width: 90%;
    margin: auto;
    padding: 20px;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
#search-bar {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
    width: 100%;
    max-width: 400px;
    margin: auto;
}
#search-bar img {
    width: 20px;
    margin-right: 10px;
}
#search-bar input {
    border: none;
    width: 100%;
    padding: 5px;
    outline: none;
}
.table-wrapper {
    overflow-x: auto;
    margin-top: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
}
table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
}
table th {
    background-color: #333;
    color: white;
}
.delete-btn {
    background-color: red;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}
.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 10px;
    border-radius: 5px;
    z-index: 1000;
}
.success {
    background-color: #4CAF50;
    color: white;
}
.error {
    background-color: #f44336;
    color: white;
}
@media (max-width: 768px) {
    table {
        font-size: 12px;
    }
    .delete-btn {
        padding: 3px 7px;
        font-size: 10px;
    }
}
</style>
@endsection
