@extends('layout.superAdminDashboard')
@section('body')
<section id="posts-container">
        <h2>Posts</h2>
        <div id="posts-content">
            <div id="top-bar">
                <div id="search">
                    <div id="search-bar">
                        <img src="assets/adminPanelAssets/pos/search-icon.png" alt="" id="search-icon">
                        <input type="search" placeholder="Search" id="input">
                    </div>                
                </div>
                <div id="add-post">
                    <img src="assets/adminPanelAssets/pos/add.svg" id="add-icon">
                    <button id="add-post-btn" onclick="window.location.href = '{{ url('/Add-Post') }}'">Add Post</button>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th id="th1">Sr. #</th>
                        <th id="th2">Title</th>
                        <th id="th3">Date posted</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="serial">1.</td>
                        <td class="info">BMW X5 Gold 2024 Sport Review: Light on Sport.</td>
                        <td class="date-posted">
                            <img src="assets/adminPanelAssets/pos/calendar-icon.png" alt="Calendar Icon">
                            <p class="date">Date: 25 Oct 2021</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="serial">2.</td>
                        <td class="info">BMW X5 Gold 2024 Sport Review: Light on Sport.</td>
                        <td class="date-posted">
                            <img src="assets/adminPanelAssets/pos/calendar-icon.png" alt="Calendar Icon">
                            <p class="date">Date: 25 Oct 2021</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="serial">3.</td>
                        <td class="info">BMW X5 Gold 2024 Sport Review: Light on Sport.</td>
                        <td class="date-posted">
                            <img src="assets/adminPanelAssets/pos/calendar-icon.png" alt="Calendar Icon">
                            <p class="date">Date: 25 Oct 2021</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="pagination">
            <div id="previous-next">
                <button class="pagination-btn">Previous</button>
                <button class="pagination-btn">Next</button>
            </div>
            <div id="page-status">
                <p>Page 1 of 10</p>
            </div>
        </div>
    </section>
@endsection
