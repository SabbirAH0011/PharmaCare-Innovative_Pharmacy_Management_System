<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LoginAccessController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UniversalDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AmbulanceController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RiderController;
use App\Http\Middleware\loginCheckAccess;
use App\Http\Middleware\CheckEmailGetOTP;
use App\Http\Middleware\DashboardAccessCheck;
use App\Http\Middleware\CheckDetailsComplete;
use App\Http\Middleware\CheckLocationBeforeBooking;
use App\Http\Middleware\CheckStoreID;
use App\Http\Middleware\LocationIdentifier;
use App\Http\Middleware\OnlinePaymentValidation;
use App\Http\Middleware\VerifyUserLogin;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[PageController::class,'WelcomePage'])->name('welcome');
Route::get('/eda',[PageController::class,'EDA'])->name('first.aid_doctor_assistance');
Route::get('/blood-bank',[PageController::class,'BloodBank'])->name('blood-bank');
Route::get('/find-doctor',[PageController::class,'FindDoctor'])->name('find-doctor');
Route::middleware([VerifyUserLogin::class])->group(function(){
    Route::get('/get/doctor/appointment',[PageController::class,'GetAppointment'])->name('get.doctor_appointment');
    Route::post('/submit/doctor/appointment',[UserController::class,'SubmitAppointment'])->name('submit.doctor_appointment');
});
Route::get('/set/user/location',[UserController::class,'SetUserLocationView'])->name('set.user_location');
Route::get('/store/user/location',[UserController::class,'StoreUserLocation'])->name('store.user_location');
Route::get('/checkout',[UserController::class,'CheckoutView'])->name('checkout');
Route::post('/checkout/store',[UserController::class,'CheckoutStore'])->name('store.checkout_data');
Route::middleware([OnlinePaymentValidation::class])->group(function(){
    Route::get('/payment/card',[UserController::class,'PaymentOnlineCard'])->name('pay.check_via_online_card');
    Route::post('/submit/payment/card',[UserController::class,'SubmitPaymentOnlineCard'])->name('submit_pay.check_via_online_card');
});
Route::middleware([LocationIdentifier::class])->group(function(){
    Route::get('/product/list',[PageController::class,'ProductList'])->name('product.list');
    Route::get('/product/details/{producr_id}',[PageController::class,'ProductDetails'])->name('product.details');
});
Route::get('/vendor/shop',[PageController::class,'VedorShop'])->name('vendor.shop');
Route::get('/vendor/list',[PageController::class,'VendorList'])->name('vendor.list');
Route::get('/cart',[UserController::class,'ViewCart'])->name('view.cart');
Route::get('/remove/item/form/cart',[UserController::class,'RemoveItemFromCart'])->name('remove.item_cart');
Route::get('/cart/count',[UserController::class,'CartCount'])->name('cart.count');
Route::post('/add/to/cat/item',[UserController::class,'StoreAddToCartItem'])->name('store.add_to_cart_item');
/* Aux routes */
Route::get('/fetch/search/list',[PageController::class,'FetchSearchProduct'])->name('fetch.searched_product');
Route::prefix('auth')->group(function(){
    Route::middleware([loginCheckAccess::class])->group(function(){
        Route::get('/get/otp',[LoginAccessController::class,'GetOTPView'])->name('get.otp');
        Route::get('/get/verify',[LoginAccessController::class,'GetVerify'])->name('get.otp_verify');
        Route::middleware([CheckEmailGetOTP::class])->group(function(){
            Route::get('/set/otp',[LoginAccessController::class,'SetOTPView'])->name('set.otp');
            Route::post('/otp/varify',[LoginAccessController::class,'OTPVerify'])->name('otp.varify');
        });
    });
});
Route::prefix('dashboard')->group(function(){
    Route::middleware([DashboardAccessCheck::class])->group(function(){
        Route::get('/admin',[AdminController::class,'ViewAdminDashboard'])->name('admin.dashboard');
        Route::prefix('admin/function')->group(function(){
            Route::get('/remove/request',[AdminController::class,'RemoveRequest'])->name('remove.request');
            Route::post('/store/location',[AdminController::class,'StoreLocation'])->name('store.location');
            Route::post('/store/category',[AdminController::class,'StoreCategory'])->name('store.category');
            Route::get('/ambulance/booking/table',[AdminController::class,'ViewAmbulanceTable'])->name('admbulance.booking_table');
            Route::post('/store/ambulance/booking',[AdminController::class,'StoreAmbulanceBooking'])->name('store.admbulance_booking');
            Route::get('/ambulance-driver/rider/registration',[AdminController::class,'AmbulanceDriverRiderReg'])->name('admbulance.driver_rider');
            Route::post('/change/status/user',[AdminController::class,'ChangeStatusUser'])->name('change.user_status');
            Route::post('/change/rider/location',[AdminController::class,'ChangeRiderLoctiaon'])->name('change.rider_location');
            Route::post('/change/vendor/store/status',[AdminController::class,'ChangeStatusVendorStore'])->name('change.vendor_status');
            Route::get('/blood-donation/registration',[AdminController::class,'BloodDonationReg'])->name('bload.donation_registration');
            Route::post('/register/blood-donation/registration',[AdminController::class,'StoreBloodDonationReg'])->name('bload.donation_store');
            Route::get('/doctor/registration',[AdminController::class,'RegisterDoctor'])->name('doctor.registration');
            Route::post('/store/doctor',[AdminController::class,'StoreDoctor'])->name('store.doctor');
            Route::post('/change/appointment',[AdminController::class,'ChangeAppointmentStatus'])->name('change.appintment_status');
        });
        Route::get('/user',[UserController::class,'ViewUserDashboard'])->name('user.dashboard');
        Route::get('/ambulance',[AmbulanceController::class,'ViewAmbulanceDashboard'])->name('ambulance.dashboard');
        Route::get('/vendor',[VendorController::class,'ViewVendorDashboard'])->name('vendor.dashboard');
        Route::prefix('vendor/function')->group(function(){
            Route::post('/register/store',[VendorController::class,'RegisterStore'])->name('register.store');
            Route::middleware([CheckStoreID::class])->group(function(){
                Route::get('/list/medicine',[VendorController::class,'MedicineList'])->name('list.medicine');
            });
            Route::post('/list/medicine/in/vendor/store',[VendorController::class,'StoreListMedicineINVendor'])->name('store.medicine_list');
            Route::post('/list/medicine/in/vendor/update',[VendorController::class,'UpdateListMedicineINVendor'])->name('update.medicine_list');
        });
        Route::get('/rider',[RiderController::class,'ViewRiderDashboard'])->name('rider.dashboard');
        Route::get('/status/change/order/rider',[RiderController::class,'ChangeOrderStatus'])->name('rider.change_status');
        Route::get('/account/details',[UniversalDashboardController::class,'ViewAccountSettings'])->name('account.details');
        Route::post('/store/account/details',[UniversalDashboardController::class,'StoreAccountSettings'])->name('store.account_details');
        Route::get('/log/out',[AdminController::class,'Logout'])->name('log.out');
        Route::prefix('ambulance/booking')->group(function(){
            Route::middleware([CheckDetailsComplete::class])->group(function(){
                Route::get('/select/location/for/booking',[UniversalDashboardController::class,'SelectLocationBookingView'])->name('select.location_for_booking');
                Route::middleware([CheckLocationBeforeBooking::class])->group(function(){
                    Route::get('/book/now',[UniversalDashboardController::class,'BookAmbulanceNowView'])->name('book.ambulance_now');
                });
                Route::post('/submit/ambulance/booking',[UniversalDashboardController::class,'SubmitAmbulanceBooking'])->name('submit.ambulance_booking');
            });
        });
    });
});
/* Invoice */
Route::prefix('invoice')->group(function(){
    Route::get('/',[UniversalDashboardController::class,'InvoiceView'])->name('view.invoice');
});
