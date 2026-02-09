<?php

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Artisan;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\MessageController;
    use App\Http\Controllers\CouponController;
    use App\Http\Controllers\PayPalController;
    use App\Http\Controllers\NotificationController;
    use \UniSharp\LaravelFilemanager\Lfm;
    use App\Http\Controllers\Auth\ResetPasswordController;
    use App\Http\Controllers\LmsController;
use App\Http\Controllers\LmsCategoryController;
use App\Http\Controllers\AmazonCategoryController;
use App\Http\Controllers\AmazonProductController;
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

    // CACHE CLEAR ROUTE
    Route::get('cache-clear', function () {
        Artisan::call('optimize:clear');
        request()->session()->flash('success', 'Successfully cache cleared.');
        return redirect()->back();
    })->name('cache.clear');

    // STORAGE LINKED ROUTE
    Route::get('storage-link',[AdminController::class,'storageLink'])->name('storage.link');

    Auth::routes(['register' => false]);

    // Reset password
    Route::get('password/reset', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    // Password Reset Routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // Socialite
    Route::get('login/{provider}/', [LoginController::class, 'redirect'])->name('login.redirect');
    Route::get('login/{provider}/callback/', [LoginController::class, 'Callback'])->name('login.callback');

    // Welcome page route
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    // Backend section start
    Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        // user route
        Route::resource('users', 'UsersController');
        // Banner
        Route::resource('banner', 'BannerController');
        // Brand
        Route::resource('brand', 'BrandController');
        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
        Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
        // Category
        Route::resource('/category', 'CategoryController');
        // Product
        Route::resource('/product', 'ProductController');
        // Ajax for sub category
        Route::post('/category/{id}/child', 'CategoryController@getChildByParent');
        // POST category
        Route::resource('/post-category', 'PostCategoryController');
        // Post tag
        Route::resource('/post-tag', 'PostTagController');
        // Post
        Route::resource('/post', 'PostController');
        // Message
        Route::resource('/message', 'MessageController');
        Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');
        // Coupon
        Route::resource('/coupon', 'CouponController');
        // Settings
        Route::get('settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');

        // Notification
        Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
        Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
        // Password Change
        Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
        Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('change.password');
        
        // LMS Module
        Route::resource('lms-categories', 'LmsCategoryController');
        Route::resource('lms', 'LmsController');
        
        // Amazon Module
        Route::get('amazon-categories/import', [AmazonCategoryController::class, 'import'])->name('amazon-categories.import');
        Route::post('amazon-categories/import', [AmazonCategoryController::class, 'importStore'])->name('amazon-categories.import.store');
        Route::resource('amazon-categories', 'AmazonCategoryController');
        Route::resource('amazon-products', 'AmazonProductController');
        Route::post('amazon-categories/{id}/toggle-status', [AmazonCategoryController::class, 'toggleStatus'])->name('amazon-categories.toggle-status');
        Route::post('amazon-products/{id}/toggle-status', [AmazonProductController::class, 'toggleStatus'])->name('amazon-products.toggle-status');
    });

    // User section start - for non-admin users
    Route::group(['prefix' => '/user', 'middleware' => ['auth', 'user']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('user.dashboard');
        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('user-profile');
        Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('user-profile-update');
        // Category
        Route::resource('/category', 'CategoryController');
        // Product
        Route::resource('/product', 'ProductController');
        // Post category
        Route::resource('/post-category', 'PostCategoryController');
        // Post tag
        Route::resource('/post-tag', 'PostTagController');
        // Post
        Route::resource('/post', 'PostController');
        // Password Change
        Route::get('change-password', [AdminController::class, 'changePassword'])->name('user.change.password.form');
        Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('user.change.password');
    });

    // Direct image upload route
    Route::post('/upload-image', [AdminController::class, 'uploadImage'])->name('upload.image');
