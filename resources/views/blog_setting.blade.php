@extends('layout.superAdminDashboard')
@section('body')
<section id="blogs-container">
        <h2>Blogs</h2>
            <div id="blogs-content">
                <div id="top-bar">
                    <div id="search">
                        <div id="search-bar">
                            <img src="assets/adminPanelAssets/bs/search-icon.png" alt="" id="search-icon">
                            <input type="search" placeholder="Search" id="input">
                        </div>
                        <div id="custom-dropdown" class="dropdown">
                            <div id="dropdown-btn" class="dropdown-btn">
                              Newest <img src="assets/adminPanelAssets/bs/dropdown.png" alt="Dropdown Icon" id="dropdown-icon">
                            </div>
                            <ul id="dropdown-options" class="dropdown-options">
                              <li data-value="Newest">Newest</li>
                            </ul>
                        </div>                  
                    </div>
                    <div id="add-blog">
                        <img src="assets/adminPanelAssets/bs/add.svg" id="add-icon">
                        <button id="add-blog-btn" onclick="window.location.href = '{{ url('/Add-Blog') }}'">Add Blog</button>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th id="th1">Sr. #</th>
                            <th id="th2">Title</th>
                            <th id="th3">Date posted</th>
                            <th id="th4">Comments</th>
                            <th id="th5">Views</th>
                            <th id="th6">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="serial">1.</td>
                            <td class="info">BMW X5 Gold 2024 Sport Review: Light on Sport.</td>
                            <td class="date-posted">
                                <img src="assets/adminPanelAssets/bs/calendar-icon.png" alt="Calendar Icon">
                                <p class="date">Date: 25 Oct 2021</p>
                            </td>
                            <td>
                                <p class="comments">12</p>
                            </td>
                            <td class="view">690</td>
                            <td class="action"><img src="assets/adminPanelAssets/bs/action.png" alt="Action"></td>
                        </tr>
                        <tr>
                            <td class="serial">2.</td>
                            <td class="info">BMW X5 Gold 2024 Sport Review: Light on Sport.</td>
                            <td class="date-posted">
                                <img src="assets/adminPanelAssets/bs/calendar-icon.png" alt="Calendar Icon">
                                <p class="date">Date: 25 Oct 2021</p>
                            </td>
                            <td>
                                <p class="comments">12</p>
                            </td>
                            <td class="view">690</td>
                            <td class="action"><img src="assets/adminPanelAssets/bs/action.png" alt="Action"></td>
                        </tr>
                        <tr>
                            <td class="serial">3.</td>
                            <td class="info">BMW X5 Gold 2024 Sport Review: Light on Sport.</td>
                            <td class="date-posted">
                                <img src="assets/adminPanelAssets/bs/calendar-icon.png" alt="Calendar Icon">
                                <p class="date">Date: 25 Oct 2021</p>
                            </td>
                            <td>
                                <p class="comments">12</p>
                            </td>
                            <td class="view">690</td>
                            <td class="action"><img src="assets/adminPanelAssets/bs/action.png" alt="Action"></td>
                        </tr>
                        <tr>
                            <td class="serial">4.</td>
                            <td class="info">BMW X5 Gold 2024 Sport Review: Light on Sport.</td>
                            <td class="date-posted">
                                <img src="assets/adminPanelAssets/bs/calendar-icon.png" alt="Calendar Icon">
                                <p class="date">Date: 25 Oct 2021</p>
                            </td>
                            <td>
                                <p class="comments">12</p>
                            </td>
                            <td class="view">690</td>
                            <td class="action"><img src="assets/adminPanelAssets/bs/action.png" alt="Action"></td>
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
