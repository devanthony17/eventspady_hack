<?php
use App\Http\Controllers\FrontendController;


Route::get('/', [FrontendController::class, 'home']);
Route::group(['prefix' => 'user'], function () {
    Route::get('/register', [FrontendController::class, 'register']);
    Route::post('/register', [FrontendController::class, 'userRegister']);
    Route::get('/login', [FrontendController::class, 'login']);
    Route::post('/login', [FrontendController::class, 'userLogin']);
    Route::get('/resetPassword', [FrontendController::class, 'resetPassword']);
    Route::post('/resetPassword', [FrontendController::class, 'userResetPassword']);
    Route::get('/org-register', [FrontendController::class, 'orgRegister']);
    Route::post('/org-register', [FrontendController::class, 'organizerRegister']);
});

    Route::get('/all-events', [FrontendController::class, 'allEvents']);
    Route::post('/all-events', [FrontendController::class, 'allEvents']);
    Route::get('/events-category/{id}/{name}', [FrontendController::class, 'categoryEvents']);
    Route::get('/event-type/{type}', [FrontendController::class, 'eventType']);
    Route::get('/event/{id}/{name}', [FrontendController::class, 'eventDetail']);
    Route::get('/organization/{id}/{name}', [FrontendController::class, 'orgDetail']);
    Route::post('/report-event', [FrontendController::class, 'reportEvent']);
    Route::get('/all-category', [FrontendController::class, 'allCategory']);
    Route::get('/all-blogs', [FrontendController::class, 'blogs']);
    Route::get('/blog-detail/{id}/{name}', [FrontendController::class, 'blogDetail']);
    Route::get('/contact', [FrontendController::class, 'contact']);

    Route::group(['middleware' =>'appuser'], function () {
        Route::get('/checkout/{id}', [FrontendController::class, 'checkout']);
        Route::post('/createOrder', [FrontendController::class, 'createOrder']);
        Route::get('/user/profile', [FrontendController::class, 'profile']);
        Route::get('/add-favorite/{id}/{type}', [FrontendController::class, 'addFavorite']);
        Route::get('/add-followList/{id}', [FrontendController::class, 'addFollow']);
        Route::post('/add-bio', [FrontendController::class, 'addBio']);
        Route::get('/change-password', [FrontendController::class, 'changePassword']);
        Route::post('/change-password', [FrontendController::class, 'changeUserPassword']);
        Route::post('/upload-profile-image', [FrontendController::class, 'uploadProfileImage']);
        Route::get('/my-tickets', [FrontendController::class, 'userTickets']);
        Route::get('/update_profile', [FrontendController::class, 'update_profile']);
        Route::post('/update_user_profile', [FrontendController::class, 'update_user_profile']);
        Route::get('/getOrder/{id}', [FrontendController::class, 'getOrder']);
        Route::post('/add-review', [FrontendController::class, 'addReview']);
        Route::get('/web/create-payment/{id}', [FrontendController::class, 'makePayment']);
        Route::post('/web/payment/{id}', [FrontendController::class, 'initialize'])->name('frontendPay');
        Route::get('/web/rave/callback/{id}', [FrontendController::class, 'callback'])->name('frontendCallback');

    });

?>
