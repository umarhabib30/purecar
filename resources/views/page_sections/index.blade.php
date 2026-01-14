@extends('layout.superAdminDashboard')
@section('body')
<section id="landing-page-outer-container" class="">
        <h2>{{ $title }}</h2>
        <section id="landing-page-container">
            <form action="{{ route('page-sections-update', ['section' => 'hero']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <section id="hero">
                    <h2>Hero Section</h2>
                    <h3>Main Image</h3>
                    <div class="">
                        <img src="{{ asset('images/page_sections/' . $hero[0]->value) }}" alt="" style="width: 100% !important;">
                        <input type="file" name="hero_main_image">
                        <input type="hidden" name="hero_main_image_id" value="{{ $hero[0]->id }}">
                    </div>
                    <div class="input-group" style="margin: 0px;">
                        <label for="primary-text">Primary Text</label>
                        <input type="text" name="hero_primary_text" value="{{ $hero[1]->value }}">
                        <input type="hidden" name="hero_primary_text_id" value="{{ $hero[1]->id }}">
                    </div>
                    <div class="input-group">
                        <label for="secondary-text">Secondary Text</label>
                        <textarea name="hero_secondary_text">{{ $hero[2]->value }}</textarea>
                        <input type="hidden" name="hero_secondary_text_id" value="{{ $hero[2]->id }}">
                    </div>
                    <div class="input-group">
                        <label for="secondary-text">Button Link</label>
                        <textarea name="hero_button_link">{{ $hero[3]->value }}</textarea>
                        <input type="hidden" name="hero_button_link_id" value="{{ $hero[3]->id }}">
                    </div>
                    <div id="save-btn-container">
                        <button type="submit">Save</button>
                    </div>
                </section>
            </form>
            <div id="col2">
                <form action="{{ route('page-sections-update', ['section' => 'extraimages']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section id="hero">
                        <h2>Images Section</h2>

                        <!-- Forum Image -->
                        <h3>Forum Image</h3>
                        <div>
                            <img src="{{ asset('images/page_sections/' . ($extraimages->where('name', 'forum_image')->first()->value ?? 'default.jpg')) }}"
                                 alt="Forum Image"
                                 style="width: 50% !important;">
                            <input type="file" name="forum_image">
                            <input type="hidden" name="forum_image_id"
                                   value="{{ $extraimages->where('name', 'forum_image')->first()->id ?? '' }}">
                        </div>

                        <!-- Login Image -->
                        <h3>Login Image</h3>
                        <div>
                            <img src="{{ asset('images/page_sections/' . ($extraimages->where('name', 'login_image')->first()->value ?? 'default.jpg')) }}"
                                 alt="Login Image"
                                 style="width: 50% !important;">
                            <input type="file" name="login_image">
                            <input type="hidden" name="login_image_id"
                                   value="{{ $extraimages->where('name', 'login_image')->first()->id ?? '' }}">
                        </div>

                        <!-- Signup Image -->
                        <h3>Signup Image</h3>
                        <div>
                            <img src="{{ asset('images/page_sections/' . ($extraimages->where('name', 'signup_image')->first()->value ?? 'default.jpg')) }}"
                                 alt="Signup Image"
                                 style="width: 50% !important;">
                            <input type="file" name="signup_image">
                            <input type="hidden" name="signup_image_id"
                                   value="{{ $extraimages->where('name', 'signup_image')->first()->id ?? '' }}">
                        </div>

                        <!-- Save Button -->
                        <div id="save-btn-container" style="margin-top: 10px;">
                            <button type="submit">Save</button>
                        </div>
                    </section>
                </form>
            </div>

            <div id="col2">
                <form action="{{ route('page-sections-update', ['section' => 'finance']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <section id="hero">
                        <h2>Finance Section</h2>
                        <h3>Image 1</h3>
                        <div class="">
                            <img src="{{ asset('images/page_sections/' . $finance[0]->value) }}" alt="" style="width: 100% !important;">
                            <input type="file" name="finance_image_1">
                            <input type="hidden" name="finance_image_1_id" value="{{ $finance[0]->id }}">
                        </div>
                        <h3>Image 2</h3>
                        <div class="">
                            <img src="{{ asset('images/page_sections/' . $finance[1]->value) }}" alt="" style="width: 100% !important;">
                            <input type="file" name="finance_image_2">
                            <input type="hidden" name="finance_image_2_id" value="{{ $finance[1]->id }}">
                        </div>
                        <div class="input-group">
                            <label for="primary-text">Primary Text</label>
                            <input type="text" name="finance_primary_text" value="{{ $finance[2]->value }}">
                            <input type="hidden" name="finance_primary_text_id" value="{{ $finance[2]->id }}">
                        </div>
                        <div class="input-group">
                            <label for="secondary-text">Secondary Text</label>
                            <textarea name="finance_secondary_text">{{ $finance[3]->value }}</textarea>
                            <input type="hidden" name="finance_secondary_text_id" value="{{ $finance[3]->id }}">
                        </div>
                        <div class="input-group">
                        <div class="input-group">
                            <label for="finance_button_link">Button link</label>
                            <textarea name="finance_button_link">{{ $finance->where('name', 'finance_button_link')->first()->value ?? '' }}</textarea>
                            <input type="hidden" name="finance_button_link_id" value="{{ $finance->where('name', 'finance_button_link')->first()->id ?? '' }}">
                        </div>
                        <div id="save-btn-container">
                            <button type="submit">Save</button>
                        </div>
                    </section>
                </form>
                <div id="col2" style="margin-top:20px;">
                    <form action="{{ route('page-sections-update', ['section' => 'counter']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <section id="hero">
                            <h2>Counter Section</h2>
                            <div class="input-group">
                                <label for="primary-text">Car for sale</label>
                                <input type="text" name="car_for_sale" value="{{ $counter[0]->value }}">
                                <input type="hidden" name="car_for_sale_id" value="{{ $counter[0]->id }}">
                            </div>
                            <div class="input-group">
                                <label for="primary-text">Forum Sections</label>
                                <input type="text" name="forum_sections" value="{{ $counter[1]->value }}">
                                <input type="hidden" name="forum_sections_id" value="{{ $counter[1]->id }}">
                            </div>
                            <div class="input-group">
                                <label for="primary-text">Visitors Per Day</label>
                                <input type="text" name="visitor_per_day" value="{{ $counter[2]->value }}">
                                <input type="hidden" name="visitor_per_day_id" value="{{ $counter[2]->id }}">
                            </div>
                            <div class="input-group">
                                <label for="primary-text">Verified dealers</label>
                                <input type="text" name="verified_dealers" value="{{ $counter[3]->value }}">
                                <input type="hidden" name="verified_dealers_id" value="{{ $counter[3]->id }}">
                            </div>
                            <div id="save-btn-container">
                                <button type="submit">Save</button>
                            </div>
                        </section>
                    </form>
                </div>
            </div>


            <form action="{{ route('page-sections-update', ['section' => 'essentials']) }}" method="POST" enctype="multipart/form-data">
            @csrf
    <section id="hero" style="margin-bottom:20px;">

        <h2>Buying Essentials</h2>

        @for ($i = 1; $i <= 4; $i++)
        <div class="card">
            <h3>Card {{$i}}</h3>
            <div class="input-group">
                <label for="card_image_{{$i}}">Image</label>
                <input type="file" name="card_image_{{$i}}">
                <input type="hidden" name="card_image_{{$i}}_id"
                    value="{{ $essentials->where('name', 'card_image_'.$i)->first()->id ?? '' }}">
            </div>
            <div class="input-group">
                <label for="card_title_text_{{$i}}">Title</label>
                <input type="text" name="card_title_text_{{$i}}" placeholder="Enter card title" required
                    value="{{ $essentials->where('name', 'card_title_text_'.$i)->first()->value ?? '' }}">
                <input type="hidden" name="card_title_text_{{$i}}_id"
                    value="{{ $essentials->where('name', 'card_title_text_'.$i)->first()->id ?? '' }}">
            </div>
            <div class="input-group">
                <label for="card_desc_text_{{$i}}">Description</label>
                <textarea name="card_desc_text_{{$i}}" placeholder="Enter card description" required>{{ $essentials->where('name', 'card_desc_text_'.$i)->first()->value ?? '' }}</textarea>
                <input type="hidden" name="card_desc_text_{{$i}}_id"
                    value="{{ $essentials->where('name', 'card_desc_text_'.$i)->first()->id ?? '' }}">
            </div>
            <div class="input-group">
                <label for="card_link_{{$i}}">Link</label>
                <input type="url" name="card_link_{{$i}}" placeholder="Enter card link" required
                    value="{{ $essentials->where('name', 'card_link_'.$i)->first()->value ?? '' }}">
                <input type="hidden" name="card_link_{{$i}}_id"
                    value="{{ $essentials->where('name', 'card_link_'.$i)->first()->id ?? '' }}">
            </div>
        </div>
        @endfor




        <div id="save-btn-container" style="margin-top:10px;">
            <button type="submit">Save</button>
        </div>
    </section>




</form>



        </section>
@endsection
