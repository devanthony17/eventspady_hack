<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AppUserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\NotificationTemplateController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::post('/admin/login', [LicenseController::class, 'adminLogin']);
Route::post('/saveEnvData', [LicenseController::class, 'saveEnvData']);
Route::post('/saveAdminData', [LicenseController::class, 'saveAdminData']);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/order-invoice-print/{id}', [OrderController::class, 'orderInvoicePrint']);   
Route::get('/change-language/{lang}', [UserController::class, 'changeLanguage']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/home', [UserController::class, 'adminDashboard']);
    Route::get('/organization/home', [UserController::class, 'organizationDashboard']);    
    Route::get('/{id}/{name}/tickets', [TicketController::class, 'index']);
    Route::delete('/deleteTickets/{id}', [TicketController::class, 'deleteTickets']);
    Route::get('/{id}/ticket/create', [TicketController::class, 'create']);
    Route::post('/ticket/create', [TicketController::class, 'store']);
    Route::get('/ticket/edit/{id}', [TicketController::class, 'edit']);
    Route::post('/ticket/update/{id}', [TicketController::class, 'update']);
    
    Route::get('/block-user/{id}', [AppUserController::class, 'blockUser']);
    Route::get('/block-scanner/{id}', [UserController::class, 'blockScanner']);
    Route::get('/admin-setting', [SettingController::class, 'index']);
    Route::get('/license-setting', [LicenseController::class, 'licenseSetting']);
    Route::post('/save-license-setting', [LicenseController::class, 'saveLicenseSetting']);    
    Route::post('/save-general-setting', [SettingController::class, 'store']);
    Route::post('/save-mail-setting', [SettingController::class, 'saveMailSetting']);
    Route::post('/save-verification-setting', [SettingController::class, 'saveVerificationSetting']);    
    Route::post('/save-organization-setting', [SettingController::class, 'saveOrganizationSetting']);        
    Route::post('/save-pushNotification-setting', [SettingController::class, 'saveOnesignalSetting']);    
    Route::post('/save-sms-setting', [SettingController::class, 'saveSmsSetting']);    
    Route::post('/additional-setting', [SettingController::class, 'additionalSetting']);    
    Route::post('/support-setting', [SettingController::class, 'supportSetting']);    
    Route::post('/save-payment-setting', [SettingController::class, 'savePaymentSetting']);    
    Route::get('/profile', [UserController::class, 'viewProfile']);    
    Route::post('/edit-profile', [UserController::class, 'editProfile']);    
    Route::post('/change-password', [UserController::class, 'changePassword']);        
    Route::get('/orders', [OrderController::class, 'index']);    
    Route::get('/orders/{id}', [OrderController::class, 'show']);    
    Route::get('/order-invoice/{id}', [OrderController::class, 'orderInvoice']);
    Route::post('/order/changestatus', [OrderController::class, 'changeStatus']);
    Route::post('/order/changepaymentstatus', [OrderController::class, 'changePaymentStatus']);
    Route::get('/user-review', [OrderController::class, 'userReview']);    
    Route::get('/change-review-status/{id}', [OrderController::class, 'changeReviewStatus']);    
    Route::get('/delete-review/{id}', [OrderController::class, 'deleteReview']);        
    Route::post('/get-month-event', [EventController::class, 'getMonthEvent']);        
    Route::get('/event-gallery/{id}', [EventController::class, 'eventGallery']);        
    Route::post('/add-event-gallery', [EventController::class, 'addEventGallery']);        
    Route::get('/remove-image/{image}/{id}', [EventController::class, 'removeEventImage']);  

    Route::get('/scanner', [UserController::class, 'scanner']);
    Route::get('/scanner/create', [UserController::class, 'scannerCreate']);    
    Route::post('/scanner', [UserController::class, 'addScanner']);
    Route::get('/getScanner/{id}', [UserController::class, 'getScanner']);
    Route::get('/organization-report/customer', [OrderController::class, 'customerReport']);
    Route::post('/organization-report/customer', [OrderController::class, 'customerReport']);
    Route::get('/organization-report/orders', [OrderController::class, 'ordersReport']);
    Route::post('/organization-report/orders', [OrderController::class, 'ordersReport']);
    Route::get('/organization-report/revenue', [OrderController::class, 'orgRevenueReport']);
    Route::post('/organization-report/revenue', [OrderController::class, 'orgRevenueReport']);
    
    Route::get('/admin-report/customer', [OrderController::class, 'adminCustomerReport']);
    Route::post('/admin-report/customer', [OrderController::class, 'adminCustomerReport']);
    Route::get('/admin-report/organization', [OrderController::class, 'adminOrgReport']);
    Route::post('/admin-report/organization', [OrderController::class, 'adminOrgReport']);
    Route::get('/admin-report/revenue', [OrderController::class, 'adminRevenueReport']);
    Route::post('/admin-report/revenue', [OrderController::class, 'adminRevenueReport']);
    
    Route::get('/getStatistics/{month}', [OrderController::class, 'getStatistics']);
    Route::get('/admin-report/settlement', [OrderController::class, 'settlementReport']);    
    Route::get('/view-user/{id}', [AppUserController::class, 'userDetail']);
    Route::post('/pay-to-org', [OrderController::class, 'payToUser']);
    Route::post('/pay-to-organization', [OrderController::class, 'payToOrganization']);
    Route::get('/view-settlement/{id}', [OrderController::class, 'viewSettlement']);
   
    Route::get('get-code/{code}', [OrderController::class, 'getQrCode']);
    Route::get('/language/download_sample_file',[LanguageController::class,'download_sample_file']);

    Route::resources([
        'roles' => RoleController::class, 
        'tax' => TaxController::class, 
        'faq' => FaqController::class, 
        'banner' => BannerController::class, 
        'app-user' => AppUserController::class, 
        'users' =>  UserController::class, 
        'blog' =>  BlogController::class, 
        'feedback' =>  FeedbackController::class, 
        'coupon' =>  CouponController::class,   
        'category' =>  CategoryController::class, 
        'location' =>  LocationController::class, 
        'events' =>  EventController::class,    
        'notification-template' =>  NotificationTemplateController::class,
        'language' => LanguageController::class,
    ]);   
});

Route::get('/notification', [NotificationTemplateController::class, 'notification']);
Route::get('/delete-notification/{id}', [NotificationTemplateController::class, 'deleteNotification']);

Route::get('/create-payment/{id}', [UserController::class, 'makePayment']);
Route::any('/payment/{id}', [UserController::class, 'initialize'])->name('pay');
Route::get('/rave/callback/{id}', [UserController::class, 'callback'])->name('callback');

Route::get('FlutterWavepayment/{id}',[UserController::class,'FlutterWavepayment']);
Route::get('transction_verify/{id}',[UserController::class,'transction_verify']);