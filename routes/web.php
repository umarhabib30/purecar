<?php

use App\Http\Controllers\DealerController;
use App\Http\Controllers\PackageController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\CarSoldController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ContactFormController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Backend\BlogController as BackendBlogController;
use App\Http\Controllers\Backend\ApiController as BackendApiController;
use App\Http\Controllers\Backend\DashboardController as BackendDashboardController;
use App\Http\Controllers\Backend\FAQsController as BackendFAQsController;
use App\Http\Controllers\Backend\UserController as BackendUserController;
use App\Http\Controllers\Website\BlogController as WebsiteBlogController;
use App\Http\Controllers\Website\FAQsController as WebsiteFAQsController;
use App\Http\Controllers\Backend\BrandController as BackendBrandController;
use App\Http\Controllers\Backend\AuthorController as BackendAuthorController;
use App\Http\Controllers\Backend\BlogTagController as BackendBlogTagController;
use App\Http\Controllers\Backend\ForumTopicController as BackendForumTopicController;
use App\Http\Controllers\Backend\SettingsController as BackendSettingsController;
use App\Http\Controllers\Backend\SupportController as BackendSupportController;
use App\Http\Controllers\Website\ForumTopicController as WebsiteForumTopicController;
use App\Http\Controllers\Website\EventController as WebsiteEventController;
use App\Http\Controllers\Website\BusinessController as WebsiteBusinessController;
use App\Http\Controllers\Website\SeoController as SeoController;
use App\Http\Controllers\Backend\PageSectionController as BackendPageSectionController;
use App\Http\Controllers\Backend\BlogCategoryController as BackendBlogCategoryController;
use App\Http\Controllers\Backend\CompanyDetailController as BackendCompanyDetailController;
use App\Http\Controllers\Backend\AdvertController as BackendAdvertController;
use App\Http\Controllers\Backend\AdminDashboardController as BackendAdminDashboardController;
use App\Http\Controllers\Backend\ReviewsController as BackendReviewsController;
use App\Http\Controllers\Backend\EventController as BackendEventController;
use App\Http\Controllers\Backend\CouponController as BackendCouponController;
use App\Http\Controllers\Backend\DbManagementController as BackendDbManagementController;
use App\Http\Controllers\Backend\BusinessTypeController as BackendBusinessTypeController;
use App\Http\Controllers\Backend\BusinessController as BackendBusinessController;
use App\Http\Controllers\Backend\BusinessLocationController as BackendBusinessLocationController;
use App\Http\Controllers\Backend\InquiryController as BackendInquiryController;
use App\Http\Controllers\Backend\ClearCacheController as BackendClearCacheController;
use App\Http\Controllers\Backend\NormalizationRuleController as BackendNormalizationRuleController;
use App\Http\Controllers\Backend\NoteController as BackendNoteController;
use App\Http\Controllers\DealerKitController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\InquiryController;
use App\Http\Middleware\SuperadminMiddleware;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Http\Controllers\MOTController;
use App\Http\Controllers\BlueSkyController;


use App\Http\Controllers\FacebookPostController;

Route::get('/facebook/test-post', [FacebookPostController::class, 'postTest']);

Route::get('/sitemap.xml', function () {
    return Response::file(public_path('sitemap.xml'));
})->name('sitemap.xml');
Route::get('/ads.txt', function () {
    return Response::file(public_path('ads.txt'));
})->name('ads.txt');


Route::get('events', [WebsiteEventController::class, 'index'])->name('event.index');
Route::get('event-details/{event}', [WebsiteEventController::class, 'detail'])->name('event.details');
Route::post('/counter', [\App\Http\Controllers\CounterController::class, 'store'])->name('counter.store');
Route::get('/packages',[PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('packages.destroy');
Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
Route::put('/packages/{package}/update-status', [PackageController::class, 'updateStatus']);
Route::put('/packages/{package}/feature-update-status', [PackageController::class, 'featureupdateStatus']);
Route::get('/dealer-profile/{slug}', [DealerController::class, 'index'])->name('dealer.profile');
Route::post('/dealer/{dealerId}/review', [DealerController::class, 'submitReview'])->name('submit.review');
Route::post('/dealer/{dealerId}/review', [DealerController::class, 'submitReview1'])->name('submit1.review');
Route::get('/get-mot-data', [APIController::class, 'getMotHistory'])->name('get.mot.data');
Route::get('/get-vehicle-details', [APIController::class, 'getVehicleData'])->name('get.vehicle.details');
Route::get('/get-vehicle-features', [APIController::class, 'getVehicleFeaturesFromDb']);
Route::get('/get-vehicle-details-db', [APIController::class, 'getVehicleDetailsFromDb'])->name('vehicle.details.db');
Route::get('/get-mot-data-db', [APIController::class, 'getMotDataFromDb'])->name('vehicle.mot.data');
Route::get('/adverts/{image}', function ($image) {
    $path = storage_path('app/public/adverts/' . $image);
    if (file_exists($path)) {
        return response()->file($path);
    } else {
        abort(404);
    }
});

Route::get('/get-filtered-fields', [CarController::class, 'getFilteredFields'])->name('get.filtered.fields');
Route::get('/get-filtered-fieldssale', [CarController::class, 'getFilteredFieldssale'])->name('get.filtered.fields.sale');
Route::get('/cars/sort', [CarController::class, 'sortCars'])->name('cars.sort');
Route::get('/fetch-models', [LandingPageController::class, 'fetchModels']);
Route::get('/fetch-variants', [LandingPageController::class, 'fetchVariants']);
Route::get('/fetch-variants-home', [LandingPageController::class, 'fetchVariantshome']);
Route::get('blog/{blog}', [WebsiteBlogController::class, 'show'])->name('blog.show');
Route::get('blogs', [WebsiteBlogController::class, 'index'])->name('blog.index');
Route::get('blogs-category/{category}', [WebsiteBlogController::class, 'categoryWise'])->name('blog.categoryWise');
Route::get('blogs-tag/{tag}', [WebsiteBlogController::class, 'tagWise'])->name('blog.tagWise');
Route::post('/comments/{blog}', [WebsiteBlogController::class, 'storeComment'])->name('comments.store');
Route::get('faqs', [WebsiteFAQsController::class, 'index'])->name('faqs.index');
Route::delete('/delete-image-forum/{id}', [WebsiteForumTopicController::class, 'deleteForumImage'])->name('delete-forum-image');
Route::delete('/delete-image-reply-forum/{id}', [WebsiteForumTopicController::class, 'deleteReplyImage'])->name('delete-reply-image');
Route::get('forum', [WebsiteForumTopicController::class, 'index'])->name('forum.index');
Route::get('forum-topic-category/{forum_topic_category}', [WebsiteForumTopicController::class, 'forumTopicCategory'])->name('forum-topic-category');
Route::get('/forum/{slug}', [WebsiteForumTopicController::class, 'showTopic'])->name('forum.topic.show');
Route::post('/forum/{id}/edit', [WebsiteForumTopicController::class, 'editForumPost'])->name('forum.edit');
Route::delete('/forum/reply/{reply}/delete', [WebsiteForumTopicController::class, 'deleteReply'])->name('forum.reply.delete');
Route::post('/forum/reply/{reply}/edit', [WebsiteForumTopicController::class, 'updateReply'])->name('forum.reply.update');
Route::post('/forum/pin-post', [WebsiteForumTopicController::class, 'pinPost'])->name('forum.pin-post');
Route::post('/forum/upload-image', [WebsiteForumTopicController::class, 'uploadImage'])->name('forum.upload.image');
Route::post('/forum/upload/image', [WebsiteForumTopicController::class, 'uploadImage'])->name('forum.upload.image');
Route::post('/forum/upload/video', [WebsiteForumTopicController::class, 'uploadVideo'])->name('forum.upload.video');
Route::post('/forum/{topic}/reply', [WebsiteForumTopicController::class, 'storeTopicReply'])->name('forum.topic.reply');
Route::get('/moderator/category/{id}', [WebsiteForumTopicController::class, 'showModeratorPosts'])->name('moderator.posts');
Route::post('/moderator/users/block', [WebsiteForumTopicController::class, 'moderatorBlockUser'])->name('moderator.blockUser');
Route::post('/moderator/users/unblock', [WebsiteForumTopicController::class, 'moderatorUnblockUser'])->name('moderator.unblock');
Route::post('forum-post-create/{forum_topic_category}', [WebsiteForumTopicController::class, 'createForumPost'])->name('forum-post.create');
Route::post('/forum/block', [WebsiteForumTopicController::class, 'blockUser'])->name('forum.block');
Route::post('/forum/unblock', [WebsiteForumTopicController::class, 'unblock'])->name('forum.unblock');
Route::post('/forum/report', [WebsiteForumTopicController::class, 'reportUser'])->name('forum.report');
Route::get('/reports', [WebsiteForumTopicController::class, 'getReports']);
Route::delete('/forum/report/delete/{reportId}', [WebsiteForumTopicController::class, 'deleteReport']);
Route::delete('/forum/report/delete/{reportId}', [WebsiteForumTopicController::class, 'deleteReport']);
Route::post('/forum/block/user/{userId}', [WebsiteForumTopicController::class, 'moderatorBlockUser']);
Route::post('/forum/unblock/user/{userId}', [WebsiteForumTopicController::class, 'moderatorUnblockUser']);
Route::delete('/forum/{postId}/delete', [WebsiteForumTopicController::class, 'deleteForumPost'])->name('forum.delete');
Route::delete('/moderator/posts/delete/{id}', [WebsiteForumTopicController::class, 'deleteMP'])->name('moderator.posts.delete');
Route::put('/moderator/posts/update/{id}', [WebsiteForumTopicController::class, 'updateMP'])->name('moderator.posts.update');
Route::post('/forum-posts/{id}/like', [WebsiteForumTopicController::class, 'like'])->name('forum-posts.like');
Route::post('/forum-posts/{id}/dislike', [WebsiteForumTopicController::class, 'dislike'])->name('forum.post.dislike');
Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [SocialiteController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [SocialiteController::class, 'handleFacebookCallback']);
Route::get('/logout/confirm', [LogoutController::class, 'confirmLogout'])->name('logout.confirm');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/fetchVehicleData', [APIController::class, 'fetchVehicleData']);
Route::post('/submit-advert', [AdvertController::class, 'storeAdvert'])->name('submit.advert');



Route::controller(StripePaymentController::class)->group(function () {
    Route::get('stripe/{packageId}', 'stripe')->name('stripe.payment');
    Route::post('stripe/{packageId}', 'stripePost')->name('stripe.post');
    Route::post('/renew-package', 'stripeRenew')->name('stripe.renew');
    Route::post('/auto-renew-payment', 'autoRenewPayment')->name('auto.renew.payment');
    Route::post('/cancel-subscription', 'cancelSubscription')->name('cancel.subscription');

});

Route::get('/admin_logout',[AdminController::class,'logout']);
    Route::middleware('ifvaliduser')->group(function () {
        Route::post('signup_data', [UserController::class, 'signup'])->name('signup_data');
        Route::post('login', [UserController::class, 'login'])->name('login_data');
        Route::post('Adminlogin', [UserController::class, 'Adminlogin'])->name('Admin_login_data');
        Route::get('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('/signup_page', [LandingPageController::class, 'signuppage'])->name('signup_view');
        Route::get('/login_page', [LandingPageController::class, 'loginpage'])->name('login_view');
    });
    Route::get('/login_page', [LandingPageController::class, 'loginpage'])->name('login');
    Route::get('/992989', [LandingPageController::class, 'adminloginpage'])->name('adminlogin');
   

Route::post('/update-mileage', function (Request $request) {
    $newMiles = $request->input('miles');
    session(['licensedata.miles' => $newMiles]); 
    return response()->json(['message' => 'Mileage updated successfully']);
});


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('success', 'Email verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/custom-forgot-password', function () {
    return view('auth.custom-forget-password');
})->middleware('guest')->name('custom.password.request');


Route::post('/custom-forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    if ($status === Password::RESET_LINK_SENT) {
        logger('Password reset email sent successfully to ' . $request->email);
    } else {
        logger('Password reset email failed: ' . __($status));
    }
    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('custom.password.email');

Route::get('/custom-reset-password/{token}', function ($token) {
    return view('auth.custom-reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');


Route::post('/custom-reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill(['password' => bcrypt($password)])->save();
        }
    );
    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('custom.password.update');


Route::get('/store-post-advert-session', function () {
    session(['postadvert' => true]);
    return response()->json(['success' => true]);
});

Route::middleware('validuser')->group(function () {
    Route::get('dashboard', [BackendDashboardController::class, 'index'])->name('dashboard');

    Route::get('/packages/select', [AdvertController::class, 'showPackages'])->name('packages.select');


    Route::post('/change_password',[UserController::class,'change_password'])->name('change_password');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/profile/{id}',[UserController::class,'update_profile'])->name('user_profile');
    Route::view('/favoritepage','MyFavoritePage');
    Route::view('/changepassword','ChangePasswordPage');
    Route::view('/private_seller', 'private_profile')->name('private_seller');
    Route::view('/car_dealer','private_profile');
    Route::view('/listingpage','MyListingPage');
    Route::view('/submitadvert1', 'SubmitAdvertPage')->name('submitadvert1');
    Route::view('/submitadvert2','SubmitAdvertPage2');
    Route::post('/admin_review/{dealerId}', [BackendReviewsController::class, 'update'])->name('submit.review');
    Route::get('/soldcars',[CarSoldController::class,'index'])->name('sold_cars');
    Route::get('/sold-listing/{advert_id}',[CarSoldController::class,'Soldlisting'])->name('sold_listing');
    Route::get('/resell-listing/{advert_id}',[CarSoldController::class,'Reselllisting'])->name('resell_listing');
    Route::get('/car-for-sale/{slug}', [LandingPageController::class, 'showCarInfo'])->name('advert_detail');
    Route::get('/show_advertdata',[AdvertController::class,'show_advert'])->name('show_advert');
    Route::get('/add-advert',[AdvertController::class,'add_advert']);
    Route::get('/my-listing',[AdvertController::class,'show_listing'])->name('my_listing');
    Route::get('/delete-listing/{advert_id}',[AdvertController::class,'delete_listing'])->name('delete_listing');
    Route::get('/advert/{advert_id}/edit', [AdvertController::class, 'editAdvert'])->name('advert.edit');
    Route::put('/advert/update/{id}', [AdvertController::class, 'updateAdvert'])->name('update_advert');
    Route::delete('/delete-image/{id}', [AdvertController::class, 'deleteImage'])->name('delete-image');
    Route::get('/fetch-page-views/{advert_id}', [BackendDashboardController::class, 'fetchPageViews']);
    Route::get('/get-daily-counters', [BackendDashboardController::class, 'getDailyCounters']);
    Route::get('/get-all-daily-counters', [BackendDashboardController::class, 'getAllDailyCounters']);
    Route::get('/fetch-all-page-views', [BackendDashboardController::class, 'fetchAllPageViews']);
    Route::post('/apply-coupon', [BackendCouponController::class, 'applyCoupon'])->name('apply.coupon');


    
    
});


Route::get('/user/details', function () {
    $user = Auth::check() ? Auth::user() : null;
    
    return response()->json([
        'name' => $user ? $user->name : '',
        'email' => $user ? $user->email : '',
        'phone' => $user ? $user->phone_number : '',
    ]);
});

Route::post('/send-inquiry', [InquiryController::class, 'sendInquiry'])->name('send.inquiry');
Route::post('/send-inquiry-dealer', [InquiryController::class, 'sendInquiryDealer']);
Route::get('/search-price', [LandingPageController::class, 'searchMake'])->name('search.make');
Route::get('/cheapest-cars', [LandingPageController::class, 'CheapestCars'])->name('cheapest.cars');
Route::get('/download-mot/{vrm}', [MOTController::class, 'downloadMOTPDF']);
Route::get('/',[LandingPageController::class,'landing_page']);
Route::post('/searchmake',[LandingPageController::class,'searchMake'])->name('search_make');
Route::get('/car-for-sale/{slug}', [LandingPageController::class, 'showCarInfo'])->name('advert_detail');








// Route::get('/cars-for-sale/{make}/{model}', [SeoController::class, 'index'])
//     ->where([
//         'make' => '[a-zA-Z0-9\-]+',
//         'model' => '[a-zA-Z0-9\-]+',
//     ])
//     ->name('seo.make.model');


Route::get('/cars-for-sale/{make}/{model}/year-{year}/{location}', [SeoController::class, 'index'])
    ->where(['make' => '[a-zA-Z0-9\-]+', 'model' => '[a-zA-Z0-9\-]+', 'year' => '[0-9]{4}', 'location' => '[a-zA-Z0-9\-]+'])
    ->name('seo.make.model.year.location');
Route::get('/cars-for-sale/{make}/{model}/under-{price}', [SeoController::class, 'index'])
    ->where(['make' => '[a-zA-Z0-9\-]+','model' => '[a-zA-Z0-9\-]+', 'price' => '[0-9]+'])
    ->name('seo.make.model.price.under');
Route::get('/cars-for-sale/fuel/{fuel_type}/{location}', [SeoController::class, 'index'])
    ->where(['fuel_type' => '[a-zA-Z0-9\-]+', 'location' => '[a-zA-Z0-9\-]+'])
    ->name('seo.fuel.location');
Route::get('/cars-for-sale/transmission/{transmission_type}/{location}', [SeoController::class, 'index'])
    ->where(['transmission_type' => '[a-zA-Z0-9\-]+', 'location' => '[a-zA-Z0-9\-]+'])
    ->name('seo.transmission.location');
Route::get('/cars-for-sale/body/{body_type}/{location}', [SeoController::class, 'index'])
    ->where(['body_type' => '[a-zA-Z0-9\-]+', 'location' => '[a-zA-Z0-9\-]+'])
    ->name('seo.body.location');
Route::get('/cars-for-sale/{make}/under-{price}', [SeoController::class, 'index'])
    ->where(['make' => '[a-zA-Z0-9\-]+', 'price' => '[0-9]+'])
    ->name('seo.make.price.under');
Route::get('/cars-for-sale/{make}/{model}/{location}', [SeoController::class, 'index'])
    ->where(['make' => '[a-zA-Z0-9\-]+', 'model' => '[a-zA-Z0-9\-]+', 'location' => '[a-zA-Z0-9\-]+'])
    ->name('seo.make.model.location');
Route::get('/cars-for-sale/{make}/{location}', [SeoController::class, 'index'])
    ->where(['make' => '[a-zA-Z0-9\-]+', 'location' => '[a-zA-Z0-9\-]+'])
    ->name('seo.make.location');


Route::post('/forsalesfilter',[CarController::class,'search_car'])->name('forsale_filter');
Route::post('/count-cars', [CarController::class,'countCars'])->name('count.cars');
Route::get('/searchcar',[CarController::class,'search_car'])->name('search_car');
Route::get('/dealer/{slugOrId}/sold-cars', [DealerController::class, 'DealerSoldCars'])->name('dealer.soldcars');
Route::view('/layout','layout.layout');
Route::view('/forsalepage','forsale_page')->name('forsalepage');
Route::view('/dealerpage','dealer_page');
Route::view('/blogpage','news_articles')->name('blog_page');
Route::view('/news','news_articles');
Route::view('/contactus','contact_us')->name('contact_us');
Route::post('/contactfoam', [ContactFormController::class, 'submit'])->name('contact.submit');
Route::view('/forum_page','forum_forum')->name('forum_page');
Route::view('/forum_profile','forum_profile')->name('forum_profile');
Route::get('faqs-sellers', [BackendFAQsController::class, 'faqsForSellers'])->name('faqs.sellers');
Route::post('/advert/favorite', [FavouriteController::class, 'toggleFavourite'])->name('advert.favorite');
Route::get('/advert/showfavorite',[FavouriteController::class,'showFavourite']);
Route::delete('/advert/favourite/{advertId}', [FavouriteController::class, 'deleteFavourite'])->name('delete_favourite');
Route::get('/support',[BackendSupportController::class,'index']);
Route::post('/send-support-message', [BackendSupportController::class, 'sendSupportMessage'])->name('support.send');
Route::get('/terms-and-conditions', [LandingPageController::class, 'termsAndConditions'])->name('terms.conditions');
Route::get('/privacy-policy', [LandingPageController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/refund-policy', [LandingPageController::class, 'refundPolicy'])->name('refund.policy');
Route::get('/pricing', [LandingPageController::class, 'fetchpacakges'])->name('pricing.package');
Route::get('/get-mot-data', [APIController::class, 'getMotHistory']);



Route::middleware([SuperadminMiddleware::class])->group(function () {
    Route::view('/Landing-Page-setting', 'landing_page_setting')->name('LandingpageSetting');
    Route::view('/Profile-Setting','profile_setting');
    Route::view('/Tags&Categories','tagsandcategories');
    Route::view('/Contact-Detail-Setting','contact_setting');
    Route::view('/Blogs-Setting','blog_setting');
    Route::view('/Post-Setting','post_setting');
    Route::view('/Add-Blog','add_blog');
    Route::view('/Add-Post','add_post');
    Route::get('list-blogs', [BackendBlogController::class, 'index'])->name('list-blog.index');
    Route::get('create-blog', [BackendBlogController::class, 'create'])->name('blog.create');
    Route::post('store-blog', [BackendBlogController::class, 'store'])->name('blog.store');
    Route::post('update-blog/{id}', [BackendBlogController::class, 'update'])->name('blog.update');
    Route::get('edit-blog/{slug}', [BackendBlogController::class, 'edit'])->name('blog.edit');
    Route::get('delete-blog/{blog}', [BackendBlogController::class, 'delete'])->name('blog.delete');
    Route::get('delete-comment/{comment}', [BackendBlogController::class, 'deleteComment'])->name('comment.delete');
    Route::post('/upload-image', [BackendBlogController::class, 'uploadImage'])->name('upload.image');
    Route::get('list-authors', [BackendAuthorController::class, 'index'])->name('list-blog.index');
    Route::get('create-author', [BackendAuthorController::class, 'create'])->name('author.create');
    Route::post('store-author', [BackendAuthorController::class, 'store'])->name('author.store');
    Route::post('update-author/{id}', [BackendAuthorController::class, 'update'])->name('author.update');
    Route::get('edit-author/{author}', [BackendAuthorController::class, 'edit'])->name('author.edit');
    Route::get('delete-author/{author}', [BackendAuthorController::class, 'delete'])->name('author.delete');
    Route::get('list-blog-categories', [BackendBlogCategoryController::class, 'index'])->name('list-blog-category.index');
    Route::get('create-blog-category', [BackendBlogCategoryController::class, 'create'])->name('blog-category.create');
    Route::post('store-blog-category', [BackendBlogCategoryController::class, 'store'])->name('blog-category.store');
    Route::get('delete-blog-category/{id}', [BackendBlogCategoryController::class, 'delete'])->name('blog-category.delete');
    Route::get('list-blog-tags', [BackendBlogTagController::class, 'index'])->name('list-blog-tag.index');
    Route::get('create-blog-tag', [BackendBlogTagController::class, 'create'])->name('blog-tag.create');
    Route::post('store-blog-tag', [BackendBlogTagController::class, 'store'])->name('blog-tag.store');
    Route::get('delete-blog-tag/{id}', [BackendBlogTagController::class, 'delete'])->name('blog-tag.delete');
    Route::get('company-details', [BackendCompanyDetailController::class, 'index'])->name('company-details.index');
    Route::post('update-company-details', [BackendCompanyDetailController::class, 'update'])->name('company-details-update');
    Route::get('list-event', [BackendEventController::class, 'index'])->name('list-event.index');
    Route::get('/event/create', [BackendEventController::class, 'create'])->name('event.create');
    Route::post('/event/store', [BackendEventController::class, 'store'])->name('event.store');
    Route::get('/event/edit/{event}', [BackendEventController::class, 'edit'])->name('event.edit');
    Route::put('/event/update/{event}', [BackendEventController::class, 'update'])->name('event.update'); 
    Route::get('/event/delete/{event}', [BackendEventController::class, 'destroy'])->name('event.delete');
    Route::get('list-faqs', [BackendFAQsController::class, 'index'])->name('list-faq.index');
    Route::get('create-faq', [BackendFAQsController::class, 'create'])->name('faq.create');
    Route::post('store-faq', [BackendFAQsController::class, 'store'])->name('faq.store');
    Route::post('update-faq/{id}', [BackendFAQsController::class, 'update'])->name('faq.update');
    Route::get('edit-faq/{faq}', [BackendFAQsController::class, 'edit'])->name('faq.edit');
    Route::get('delete-faq/{faq}', [BackendFAQsController::class, 'delete'])->name('faq.delete');
    Route::get('page-sections', [BackendPageSectionController::class, 'pageSections'])->name('page-sections.index');
    Route::post('update-page-sections/{section}', [BackendPageSectionController::class, 'update'])->name('page-sections-update');
    Route::get('list-brands', [BackendBrandController::class, 'index'])->name('list-brands.index');
    Route::get('create-brand', [BackendBrandController::class, 'create'])->name('brand.create');
    Route::post('store-brand', [BackendBrandController::class, 'store'])->name('brand.store');
    Route::get('delete-brand/{id}', [BackendBrandController::class, 'delete'])->name('brand.delete');
    Route::get('add-dealer', [BackendUserController::class, 'AddDealer'])->name('add-dealer.add');
    Route::post('/dealers/save', [BackendUserController::class, 'SaveDealer'])->name('admin.save_dealer');
    Route::get('list-users', [BackendUserController::class, 'index'])->name('list-users.index');
    Route::get('create-user', [BackendUserController::class, 'create'])->name('user.create');
    Route::post('store-user', [BackendUserController::class, 'store'])->name('user.store');
    Route::post('update-user/{id}', [BackendUserController::class, 'update'])->name('user.update');
    Route::get('edit-user/{user}', [BackendUserController::class, 'edit'])->name('user.edit');
    Route::get('delete-user/{user}', [BackendUserController::class, 'delete'])->name('user.delete');
     Route::get('remove-user/{user}', [BackendUserController::class, 'removeadvert'])->name('removeadvert.delete');
    Route::post('/user/verify', [BackendUserController::class, 'verify'])->name('user.verify');
    Route::get('list-forum-topics', [BackendForumTopicController::class, 'index'])->name('list-forum-topics.index');
    Route::get('create-forum-topic', [BackendForumTopicController::class, 'create'])->name('forum-topic.create');
    Route::post('store-forum-topic', [BackendForumTopicController::class, 'store'])->name('forum-topic.store');
    Route::post('update-forum-topic/{id}', [BackendForumTopicController::class, 'update'])->name('forum-topic.update');
    Route::get('edit-forum-topic/{forum_topic}', [BackendForumTopicController::class, 'edit'])->name('forum-topic.edit');
    Route::get('delete-forum-topic/{forum_topic}', [BackendForumTopicController::class, 'delete'])->name('forum-topic.delete');
    Route::get('/forum-topic/{forum_topic}', [BackendForumTopicController::class, 'show'])->name('forum-topic.details');
    Route::get('/category/{category}', [BackendForumTopicController::class, 'showPosts'])->name('forum-category.posts');
    Route::get('list-reports', [BackendForumTopicController::class, 'listreports'])->name('list_reports.index');
    Route::post('/add-moderator', [BackendForumTopicController::class, 'addModerator'])->name('add.moderator');
    Route::post('/update-moderator', [BackendForumTopicController::class, 'updateModerator'])->name('update.moderator');
    Route::get('/moderator/posts/edit/{id}', [BackendForumTopicController::class, 'edit'])->name('moderator.posts.edit');
    Route::get('/admin_dashboard', [BackendAdminDashboardController::class, 'index'])->name('admin_dashboard');
    Route::get('/admin_reviews', [BackendReviewsController::class, 'showAllReviews'])->name('admin_reviews');
    Route::delete('/admin_reviews/{id}', [BackendReviewsController::class, 'delete'])->name('admin.reviews.delete');
    Route::get('set-price', [BackendAdvertController::class, 'setprice'])->name('set-price.index');
    Route::post('set-price', [BackendAdvertController::class, 'updatePrice'])->name('set-price.update');
    Route::get('list-ads', [BackendAdvertController::class, 'index'])->name('list-ads.index');
    Route::get('/adverts/{advert_id}/edit', [BackendAdvertController::class, 'edit'])->name('adverts.edit');
    Route::put('/adverts/{advert_id}', [BackendAdvertController::class, 'update'])->name('adverts.update');
    Route::get('list-users_non', [BackendUserController::class, 'nonverifiedusers'])->name('list-users_non.index');
    Route::get('/non-verified-users', [BackendUserController::class, 'nonVerifiedUsers'])->name('nonverifiedusers.index');
    Route::view('/changepasswordadmin','admin_password/password');
    Route::post('/event/{event}/removeGalleryImage', [BackendEventController::class, 'removeGalleryImage'])->name('event.removeGalleryImage');
    Route::view('/settingsadmin','settings/admin');
    Route::post('/settings/forum-images-limit', [BackendSettingsController::class, 'updateForumImageLimit'])->name('change_forum_image_limit');
    Route::get('create-coupon', [BackendCouponController::class, 'create'])->name('coupons.create');
    Route::post('/admin/coupons/create', [BackendCouponController::class, 'store'])->name('coupons.store');
    Route::delete('/admin/coupons/delete/{id}', [BackendCouponController::class, 'destroy'])->name('coupons.destroy');
    Route::get('/list-coupons', [BackendCouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/{id}/edit', [BackendCouponController::class, 'edit'])->name('coupons.edit');
    Route::post('/coupons/{id}', [BackendCouponController::class, 'update'])->name('coupons.update');
    Route::get('/db-management', [BackendDbManagementController::class, 'index'])->name('admin.car.index');
    Route::get('/db-management/edit/{id}', [BackendDbManagementController::class, 'edit'])->name('admin.car.edit');
    Route::post('/db-management/update/{id}', [BackendDbManagementController::class, 'update'])->name('admin.car.update');
    Route::get('list-business-types', [BackendBusinessTypeController::class, 'index'])->name('list-business-types.index');
    Route::get('create-business-type', [BackendBusinessTypeController::class, 'create'])->name('business-type.create');
    Route::post('store-business-type', [BackendBusinessTypeController::class, 'store'])->name('business-type.store');
    Route::get('edit-business-type/{business_type}', [BackendBusinessTypeController::class, 'edit'])->name('business-type.edit');
    Route::post('update-business-type/{id}', [BackendBusinessTypeController::class, 'update'])->name('business-type.update');
    Route::get('delete-business-type/{business_type}', [BackendBusinessTypeController::class, 'delete'])->name('business-type.delete');
    Route::get('list-businesses', [BackendBusinessController::class, 'index'])->name('list-businesses.index');
    Route::get('edit-business/{business}', [BackendBusinessController::class, 'edit'])->name('business.edit');
    Route::post('update-business/{id}', [BackendBusinessController::class, 'update'])->name('business.update');
    Route::get('delete-business/{business}', [BackendBusinessController::class, 'delete'])->name('business.delete');
    Route::post('approve-business/{business}', [BackendBusinessController::class, 'approve'])->name('business.approve');
    Route::get('list-business-locations', [BackendBusinessLocationController::class, 'index'])->name('list-business-locations.index');
    Route::get('create-business-location', [BackendBusinessLocationController::class, 'create'])->name('business-location.create');
    Route::post('store-business-location', [BackendBusinessLocationController::class, 'store'])->name('business-location.store');
    Route::post('/business-locations/bulk-upload', [BackendBusinessLocationController::class, 'bulkUpload'])->name('business-location.bulk-upload');
    Route::get('edit-business-location/{business_location}', [BackendBusinessLocationController::class, 'edit'])->name('business-location.edit');
    Route::post('update-business-location/{id}', [BackendBusinessLocationController::class, 'update'])->name('business-location.update');
    Route::get('delete-business-location/{business_location}', [BackendBusinessLocationController::class, 'delete'])->name('business-location.delete');
    Route::post('/business-types/bulk-upload', [BackendBusinessTypeController::class, 'bulkUpload'])->name('business-types.bulk-upload');
    Route::get('delete-business-image/{imageId}', [BackendBusinessController::class, 'deleteImage'])->name('business.image.delete');
    Route::get('view-business/{business}', [BackendBusinessController::class, 'show'])->name('business.view'); 
    Route::get('/inquiries', [BackendInquiryController::class, 'index'])->name('inquiries.index');
    Route::post('/clear-cache', [BackendClearCacheController::class, 'clear'])->name('clear.cache'); 
    Route::get('/api-index', [BackendApiController::class, 'index'])->name('api.index');
    Route::post('/admin/api/connect-dealer', [BackendApiController::class, 'connectDealer'])->name('admin.api.connectDealer');
    Route::delete('/admin/api/disconnect-source', [BackendApiController::class, 'disconnectSource'])
        ->name('admin.api.disconnectSource');
    Route::get('/normalization-rules', [BackendNormalizationRuleController::class, 'index'])
        ->name('admin.normalization_rules.index');
    Route::get('/normalization-rules/values', [BackendNormalizationRuleController::class, 'getValues'])
        ->name('admin.normalization_rules.getValues');
    Route::post('/normalization-rules/store', [BackendNormalizationRuleController::class, 'storeOrUpdate'])
        ->name('admin.normalization_rules.storeOrUpdate');
    Route::post('/normalization-rules/hide', [BackendNormalizationRuleController::class, 'hide'])
        ->name('admin.normalization_rules.hide');
    Route::post('/normalization-rules/delete', [BackendNormalizationRuleController::class, 'destroy'])
        ->name('admin.normalization_rules.destroy');
    Route::post('/admin/normalization-rules/bulk-normalize', [BackendNormalizationRuleController::class, 'bulkNormalize'])
        ->name('admin.normalization_rules.bulkNormalize');  
    Route::post('/admin/normalization-rules/bulk-hide', [BackendNormalizationRuleController::class, 'bulkHide'])
        ->name('admin.normalization_rules.bulkHide');
    Route::get('/admin/normalization-rules/history', [BackendNormalizationRuleController::class, 'getHistory'])
        ->name('admin.normalization_rules.getHistory');
    Route::post('/admin/normalization-rules/revert', [BackendNormalizationRuleController::class, 'revert'])
        ->name('admin.normalization_rules.revert');
 
    Route::get('/notes', [BackendNoteController::class, 'index'])->name('admin.notes.index');
    Route::get('/notes/create', [BackendNoteController::class, 'create'])->name('admin.notes.create');
    Route::post('/notes', [BackendNoteController::class, 'store'])->name('admin.notes.store');
    Route::get('/notes/{note}/edit', [BackendNoteController::class, 'edit'])->name('admin.notes.edit');
    Route::put('/notes/{note}', [BackendNoteController::class, 'update'])->name('admin.notes.update');
    Route::delete('/notes/{note}', [BackendNoteController::class, 'destroy'])->name('admin.notes.destroy');
        Route::get('/notes/filter-adverts', [BackendNoteController::class, 'getAdvertsByFilter'])->name('admin.notes.getAdvertsByFilter');


    

});

Route::get('/submit-business', [WebsiteBusinessController::class, 'create'])->name('business.create');
Route::post('/submit-business', [WebsiteBusinessController::class, 'store'])->name('business.store');
Route::get('/business-listings', [WebsiteBusinessController::class, 'index'])->name('business.index'); 
Route::get('/business/types-by-location', [WebsiteBusinessController::class, 'getBusinessTypesByLocation'])->name('business.types-by-location');
Route::get('/business/locations-by-type', [WebsiteBusinessController::class, 'getBusinessLocationsByType'])->name('business.locations-by-type');
Route::get('/business-listings/{business}', [websiteBusinessController::class, 'show'])->name('business.show');
Route::get('/business-listings/{city}/{category}/{slug}', [websiteBusinessController::class, 'showBySlug'])->name('business.show.seo');

Route::post('/email/verification-notification', function (Request $request) {
    $user = User::findOrFail($request->user_id);
    
    if ($user->email_verified_at) {
        return back()->with('error', 'User is already verified.');
    }

    $user->sendEmailVerificationNotification();
    
    return back()->with('success', 'Verification link sent successfully.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');





