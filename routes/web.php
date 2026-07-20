<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureWelfareAccess;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelfareController;
use App\Http\Controllers\WelfareExploreController;
use App\Http\Controllers\WelfareSwitchController;
use App\Http\Controllers\WelfareMemberController;
use App\Http\Controllers\MemberProfileController;
use App\Http\Controllers\WelfareMembershipRequestController;

use App\Http\Controllers\BenevolenceCategoryController;
use App\Http\Controllers\WelfareBenevolenceCaseController;
use App\Http\Controllers\WelfareContributionController;
use App\Http\Controllers\SolidarityFundController;

use App\Http\Controllers\Pdf\BenevolenceContributionPdfController;
use App\Http\Controllers\Pdf\WelfareMemberPdfController;

use App\Http\Controllers\WelfareRevenueController;


/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('index'));

Route::get('/about', fn() => view('frontend.about'));
Route::get('/contact', fn() => view('frontend.contact'));
Route::get('/frequetly-asked-questions', fn() => view('frontend.faq'));
Route::get('/privacy-policy', fn() => view('frontend.privacy'))->name('privacy');
Route::get('/terms-and-conditions', fn() => view('frontend.terms'))->name('terms');

Route::get('/explore', [WelfareExploreController::class, 'index'])
    ->name('frontend.explore');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgot'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp']);
});


/*
|--------------------------------------------------------------------------
| Verification
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', [VerificationController::class, 'show'])
        ->name('verification.notice');

    Route::post('/verify-otp', [VerificationController::class, 'verify'])
        ->name('otp.verify');

    Route::post('/resend-otp', [VerificationController::class, 'resend'])
        ->name('otp.resend');

    Route::get('/reset-password', [PasswordResetController::class, 'showReset'])
        ->name('password.reset');

    Route::post('/reset-password', [PasswordResetController::class, 'update']);
});


/*
|--------------------------------------------------------------------------
| Authenticated & Verified
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/search-members', [DashboardController::class, 'searchMembers'])
        ->name('dashboard.search-members');

    Route::post('/welfare/switch/{welfareId}', [WelfareSwitchController::class, 'switch'])
        ->name('welfare.switch');


    /*
    |--------------------------------------------------------------------------
    | Explore Welfares
    |--------------------------------------------------------------------------
    */

    Route::get('/welfare/{id}/{slug}/details', [WelfareExploreController::class, 'show'])
        ->name('frontend.welfare.details');

    Route::post('/welfares/{id}/{slug}/requests', [WelfareMembershipRequestController::class, 'store'])
        ->name('welfares.requests.store');


    /*
    |--------------------------------------------------------------------------
    | Welfares
    |--------------------------------------------------------------------------
    */

    Route::prefix('welfares')->group(function () {

        Route::get('/{id}/{slug}', [WelfareController::class, 'show'])
            ->middleware('can:viewDashboard,App\Models\Welfare')
            ->name('welfares.show');

        Route::middleware('can:manageWelfare,App\Models\Welfare')->group(function () {

            Route::get('/', [WelfareController::class, 'index'])->name('welfares.index');

            Route::get('/create', [WelfareController::class, 'create'])->name('welfares.create');

            Route::post('/', [WelfareController::class, 'store'])->name('welfares.store');

            Route::get('/{id}/{slug}/edit', [WelfareController::class, 'edit'])->name('welfares.edit');

            Route::put('/{id}/{slug}', [WelfareController::class, 'update'])->name('welfares.update');

            Route::patch('/{id}/{slug}/toggle-status', [WelfareController::class, 'toggleStatus'])->name('welfares.toggle-status');

            Route::delete('/{id}/{slug}', [WelfareController::class, 'destroy'])->name('welfares.destroy');


            /*
            |--------------------------------------------------------------------------
            | Welfare Admins
            |--------------------------------------------------------------------------
            */

            Route::get('/{id}/{slug}/search-members', [WelfareController::class, 'searchMembers'])
                ->name('welfares.searchMembers');

            Route::post('/{id}/{slug}/add-admin', [WelfareController::class, 'addAdmin'])
                ->name('welfares.addAdmin');

            Route::post('/{id}/{slug}/remove-admin/{memberId}', [WelfareController::class, 'removeAdmin'])
                ->name('welfares.removeAdmin');


            /*
            |--------------------------------------------------------------------------
            | Welfare Members
            |--------------------------------------------------------------------------
            */

            Route::get('/{id}/{slug}/members', [WelfareMemberController::class, 'index'])
                ->name('welfares.members.index');


            /*
            |--------------------------------------------------------------------------
            | Membership Requests
            |--------------------------------------------------------------------------
            */

            Route::get('/{id}/{slug}/requests', [WelfareMembershipRequestController::class, 'index'])
                ->name('welfares.requests.index');

            Route::get('/{id}/{slug}/requests/{requestId}', [WelfareMembershipRequestController::class, 'show'])
                ->name('welfares.requests.show');

            Route::put('/{id}/{slug}/requests/{requestId}', [WelfareMembershipRequestController::class, 'updateStatus'])
                ->name('welfares.requests.update');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Benevolence Categories
    |--------------------------------------------------------------------------
    */

    Route::prefix('benevolence-categories')
        ->middleware([
            EnsureWelfareAccess::class,
            'can:manageWelfare,App\Models\Welfare'
        ])
        ->group(function () {

            Route::get('/', [BenevolenceCategoryController::class, 'index'])
                ->name('benevolence-categories.index');

            Route::post('/', [BenevolenceCategoryController::class, 'store'])
                ->name('benevolence-categories.store');

            Route::put('/{category}', [BenevolenceCategoryController::class, 'update'])
                ->name('benevolence-categories.update');

            Route::delete('/{category}', [BenevolenceCategoryController::class, 'destroy'])
                ->name('benevolence-categories.destroy');
        });


    /*
    |--------------------------------------------------------------------------
    | Benevolence Cases
    |--------------------------------------------------------------------------
    */

    Route::prefix('benevolence-cases')
        ->middleware([
            EnsureWelfareAccess::class,
            'can:manageWelfare,App\Models\Welfare'
        ])
        ->group(function () {

            Route::get('/', [WelfareBenevolenceCaseController::class, 'index'])
                ->name('benevolence-cases.index');

            Route::get('/create', [WelfareBenevolenceCaseController::class, 'create'])
                ->name('benevolence-cases.create');

            Route::post('/', [WelfareBenevolenceCaseController::class, 'store'])
                ->name('benevolence-cases.store');

            Route::get('/{case}', [WelfareBenevolenceCaseController::class, 'show'])
                ->name('benevolence-cases.show');

            Route::patch('/{case}/extend', [WelfareBenevolenceCaseController::class, 'extend'])
                ->name('benevolence-cases.extend');

            Route::patch('/{case}/update-status', [WelfareBenevolenceCaseController::class, 'updateStatus'])
                ->name('benevolence-cases.update-status');

            Route::delete('/{case}', [WelfareBenevolenceCaseController::class, 'destroy'])
                ->name('benevolence-cases.destroy');
        });


    /*
    |--------------------------------------------------------------------------
    | Contributions
    |--------------------------------------------------------------------------
    */

    Route::prefix('contributions')->group(function () {

        Route::post('/{caseId}', [WelfareContributionController::class, 'store'])
            ->name('contributions.store');

        Route::patch('/{contribution}', [WelfareContributionController::class, 'update'])
            ->name('contributions.update');

        Route::delete('/{contribution}', [WelfareContributionController::class, 'destroy'])
            ->name('contributions.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | PDF Exports
    |--------------------------------------------------------------------------
    */

    Route::prefix('exports')->group(function () {

        Route::get('/welfare/{id}/{slug}/members/pdf', [WelfareMemberPdfController::class, 'download'])
            ->name('welfare.members.pdf');

        Route::get('/welfare/{welfare_id}/benevolence-cases/{id}/pdf', [BenevolenceContributionPdfController::class, 'download'])
            ->name('benevolence-cases.pdf');
    });


    /*
    |--------------------------------------------------------------------------
    | Member Utilities
    |--------------------------------------------------------------------------
    */

    Route::get('/welfare/{id}/members/search', [WelfareMemberController::class, 'search'])
        ->name('members.search');

    Route::get('/welfare/{id}/member/{memberId}/profile', [WelfareMemberController::class, 'profile'])
        ->name('members.profile');

    Route::patch('/welfare/member/{memberId}/status', [WelfareMemberController::class, 'updateStatus'])
        ->name('members.updateStatus');


    /*
    |--------------------------------------------------------------------------
    | My Account
    |--------------------------------------------------------------------------
    */

    Route::prefix('my')
        ->name('member.')
        ->group(function () {

            Route::get('/cases', [MemberProfileController::class, 'myCases'])
                ->name('my-cases');

            Route::get('/contributions', [MemberProfileController::class, 'myContributions'])
                ->name('my-contributions');
        });


    /*
    |--------------------------------------------------------------------------
    | Solidarity Funds
    |--------------------------------------------------------------------------
    */

    Route::prefix('solidarity-funds')->group(function () {

        Route::get('/{memberId}/history', [SolidarityFundController::class, 'history'])
            ->name('solidarity-funds.history');

        Route::post('/store', [SolidarityFundController::class, 'store'])
            ->name('solidarity-funds.store');
    });


    /*
    |--------------------------------------------------------------------------
    | Super Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->group(function () {

        // Revenue Dashboard
        Route::get('/revenue', [WelfareRevenueController::class, 'index'])
            ->name('admin.revenue.index');

        // Users
        Route::get('/users', [UserController::class, 'index'])
            ->name('admin.users.index');

        Route::get('/users/{user}', [UserController::class, 'show'])
            ->name('admin.users.show');

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->name('admin.users.edit');

        Route::patch('/users/{user}', [UserController::class, 'update'])
            ->name('admin.users.update');

        Route::patch('/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])
            ->name('admin.users.toggle-admin');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('admin.users.destroy');
    });
});
