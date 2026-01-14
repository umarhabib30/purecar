@extends('layout.superAdminDashboard')
@section('body')
<section id="add-post-outer-container">
        <h1>Add Post</h1>
        <div id="add-post-inner-container">
            <h2>Add Post Title and Relevant Categories</h2>
            <div class="input-group">
                <label for="title">Title</label>
                <input type="text" placeholder="Add a Title">
            </div>
            <div class="input-group" id="category-input-group">
                <label for="categoies">Categories</label>
                <input type="text" id="add-category-input" placeholder="Add a Category">
            </div>
            <button id="add-category">+ Add</button>
            <div id="btn-container">
                <button id="cancel-btn">Cancel</button>
                <button id="save-btn">Save</button>
            </div>
        </div>
    </section>
 @endsection   
