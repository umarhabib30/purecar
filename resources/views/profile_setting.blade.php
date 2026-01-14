@extends('layout.superAdminDashboard')
@section('body')
<section id="profile-outer-container">
        <h2>Profile</h2>
        <section id="profile-container">
            <div id="contents">
                <h3>About Us</h3>
                <textarea id="about-us-text">NIVC, a subsidiary of NSRIC, plays a crucial role in facilitating overseas education and resettlement. Our team dedicates time, effort, and expertise to prepare immigration documents and guide individuals toward a successful relocation.</textarea>
                <h3>Social Links</h3>
                <p id="sub-text">Add links to your social profiles</p>
                <div class="social-link-row">
                    <div class="logo">
                        <img src="assets/adminPanelAssets/ps/insta-logo.png" alt="Instagram Logo">
                    </div>
                    <input type="url" placeholder="Enter url here">
                    <button class="remove-btn">
                        <img src="assets/adminPanelAssets/ps/clear.png" alt="Clear">
                    </button>
                </div>
                <div class="social-link-row">
                    <div class="logo">
                        <img src="assets/adminPanelAssets/ps/yt-logo.png" alt="YouTube Logo">
                    </div>
                    <input type="url" placeholder="Enter url here">
                    <button class="remove-btn">
                        <img src="assets/adminPanelAssets/ps/clear.png" alt="Clear">
                    </button>
                </div>
                <div class="social-link-row">
                    <div class="logo">
                        <img src="assets/adminPanelAssets/ps/fb-logo.png" alt="Facebook Logo">
                    </div>
                    <input type="url" placeholder="Enter url here">
                    <button class="remove-btn">
                        <img src="assets/adminPanelAssets/ps/clear.png" alt="Clear">
                    </button>
                </div>
                <div class="social-link-row">
                    <div class="logo">
                        <img src="assets/adminPanelAssets/ps/linkedin-logo.png" alt="LinkedIn Logo">
                    </div>
                    <input type="url" placeholder="Enter url here">
                    <button class="remove-btn">
                        <img src="assets/adminPanelAssets/ps/clear.png" alt="Clear">
                    </button>
                </div>
                <div class="social-link-row">
                    <div class="logo">
                        <img src="assets/adminPanelAssets/ps/x-logo.png" alt="X Logo">
                    </div>
                    <input type="url" placeholder="Enter url here">
                    <button class="remove-btn">
                        <img src="assets/adminPanelAssets/ps/clear.png" alt="Clear">
                    </button>
                </div>
                <div id="btn-container">
                    <button id="cancel-btn">Cancel</button>
                    <button>Save</button>
                </div>
            </div>
        </section>
    </section>
@endsection    