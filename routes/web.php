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
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogSubCategoryController;
use App\Http\Controllers\BlogProductController;
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
        if (auth()->check()) {
            return redirect()->route('admin');
        } else {
            return redirect()->route('login');
        }
    })->name('home');

    // Backend section start
    Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        // user route
        Route::resource('users', 'UsersController');
        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
        Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
        // Settings
        Route::get('settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');

        // Role Permissions Management
        Route::get('role-permissions', [App\Http\Controllers\RolePermissionController::class, 'index'])->name('role-permissions.index');
        Route::get('role-permissions/create-role', [App\Http\Controllers\RolePermissionController::class, 'createRole'])->name('role-permissions.create-role');
        Route::post('role-permissions/store-role', [App\Http\Controllers\RolePermissionController::class, 'storeRole'])->name('role-permissions.store-role');
        Route::get('role-permissions/{roleId}', [App\Http\Controllers\RolePermissionController::class, 'show'])->name('role-permissions.show');
        Route::get('role-permissions/{roleId}/edit', [App\Http\Controllers\RolePermissionController::class, 'edit'])->name('role-permissions.edit');
        Route::put('role-permissions/{roleId}', [App\Http\Controllers\RolePermissionController::class, 'update'])->name('role-permissions.update');
        Route::delete('role-permissions/destroy-role/{roleId}', [App\Http\Controllers\RolePermissionController::class, 'destroyRole'])->name('role-permissions.destroy-role');
        Route::get('role-permissions/api/permissions/{module}', [App\Http\Controllers\RolePermissionController::class, 'getPermissionsByModule'])->name('role-permissions.api.permissions');

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
        Route::post('amazon-categories/{id}/toggle-status', [AmazonCategoryController::class, 'toggleStatus'])->name('amazon-categories.toggle-status');
        Route::post('amazon-categories/{id}/toggle-is-show', [AmazonCategoryController::class, 'toggleIsShow'])->name('amazon-categories.toggle-is-show');
        
        // Amazon Subcategories
        Route::get('amazon-subcategories', [AmazonCategoryController::class, 'subCategories'])->name('amazon-subcategories.index');
        Route::get('amazon-subcategories/create', [AmazonCategoryController::class, 'createSubCategory'])->name('amazon-subcategories.create');
        Route::post('amazon-subcategories', [AmazonCategoryController::class, 'storeSubCategory'])->name('amazon-subcategories.store');
        Route::get('amazon-subcategories/{id}/edit', [AmazonCategoryController::class, 'editSubCategory'])->name('amazon-subcategories.edit');
        Route::put('amazon-subcategories/{id}', [AmazonCategoryController::class, 'updateSubCategory'])->name('amazon-subcategories.update');
        Route::post('amazon-subcategories/{id}/toggle-status', [AmazonCategoryController::class, 'toggleSubCategoryStatus'])->name('amazon-subcategories.toggle-status');
        Route::delete('amazon-subcategories/{id}', [AmazonCategoryController::class, 'destroySubCategory'])->name('amazon-subcategories.destroy');
        
        // API for dynamic subcategory loading
        Route::get('api/amazon-categories/{categoryId}/subcategories', [AmazonCategoryController::class, 'getSubCategories'])->name('amazon-categories.subcategories.api');
        
        Route::resource('amazon-sub-categories', 'AmazonSubCategoryController');
        Route::post('amazon-sub-categories/{id}/toggle-status', [AmazonSubCategoryController::class, 'toggleStatus'])->name('amazon-sub-categories.toggle-status');
        
        Route::get('amazon-products/import', [AmazonProductController::class, 'import'])->name('amazon-products.import');
        Route::post('amazon-products/import', [AmazonProductController::class, 'importStore'])->name('amazon-products.import.store');
        Route::resource('amazon-products', 'AmazonProductController');
        Route::post('amazon-products/{id}/toggle-status', [AmazonProductController::class, 'toggleStatus'])->name('amazon-products.toggle-status');
        
        // Blog Module
        Route::get('blog-categories/import', [BlogCategoryController::class, 'import'])->name('blog-categories.import');
        Route::post('blog-categories/import', [BlogCategoryController::class, 'importStore'])->name('blog-categories.import.store');
        Route::resource('blog-categories', 'BlogCategoryController');
        Route::post('blog-categories/{id}/toggle-status', [BlogCategoryController::class, 'toggleStatus'])->name('blog-categories.toggle-status');
        Route::post('blog-categories/{id}/toggle-is-show', [BlogCategoryController::class, 'toggleIsShow'])->name('blog-categories.toggle-is-show');
        
        // Blog Subcategories
        Route::get('blog-subcategories', [BlogCategoryController::class, 'subCategories'])->name('blog-subcategories.index');
        Route::get('blog-subcategories/create', [BlogCategoryController::class, 'createSubCategory'])->name('blog-subcategories.create');
        Route::post('blog-subcategories', [BlogCategoryController::class, 'storeSubCategory'])->name('blog-subcategories.store');
        Route::get('blog-subcategories/{id}/edit', [BlogCategoryController::class, 'editSubCategory'])->name('blog-subcategories.edit');
        Route::put('blog-subcategories/{id}', [BlogCategoryController::class, 'updateSubCategory'])->name('blog-subcategories.update');
        Route::post('blog-subcategories/{id}/toggle-status', [BlogCategoryController::class, 'toggleSubCategoryStatus'])->name('blog-subcategories.toggle-status');
        Route::delete('blog-subcategories/{id}', [BlogCategoryController::class, 'destroySubCategory'])->name('blog-subcategories.destroy');
        
        // API for dynamic subcategory loading
        Route::get('api/blog-categories/{categoryId}/subcategories', [BlogCategoryController::class, 'getSubCategories'])->name('blog-categories.subcategories.api');
        
        Route::resource('blog-sub-categories', 'BlogSubCategoryController');
        Route::post('blog-sub-categories/{id}/toggle-status', [BlogSubCategoryController::class, 'toggleStatus'])->name('blog-sub-categories.toggle-status');
        
        Route::get('blog-products/import', [BlogProductController::class, 'import'])->name('blog-products.import');
        Route::post('blog-products/import', [BlogProductController::class, 'importStore'])->name('blog-products.import.store');
        Route::resource('blog-products', 'BlogProductController');
        Route::post('blog-products/{id}/toggle-status', [BlogProductController::class, 'toggleStatus'])->name('blog-products.toggle-status');
    });

    // User section start - for non-admin users
    Route::group(['prefix' => '/user', 'middleware' => ['auth', 'user']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('user.dashboard');
        // Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('user-profile');
        Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('user-profile-update');
                        // Password Change
        Route::get('change-password', [AdminController::class, 'changePassword'])->name('user.change.password.form');
        Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('user.change.password');
    });

    // Direct image upload route
    Route::post('/upload-image', [AdminController::class, 'uploadImage'])->name('upload.image');
