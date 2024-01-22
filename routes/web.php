<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\CaptchaServiceController;
use App\Http\Controllers\UserSearchController;
use App\Http\Controllers\BadgeController;
use App\Http\Middleware\MaintenanceMode;

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


Route::group(['namespace' => 'App\Http\Controllers'], function()
{   

    /* Maintenance Mode  */

    Route::get('/maintenancemode', 'MaintenanceModeController@view')->name('maintenancemode');

    /* Index Routes */

    Route::get('/', 'IndexController@show')->middleware(MaintenanceMode::class);

    Route::get('/index', function () {
        return redirect('/');
    });

    /* Page Routes */

    Route::get('/terms-rules', 'PageController@showTermsRules');
    Route::get('/privacy-policy', 'PageController@showPrivacyPolicy');

    Route::get('/contact', 'ContactController@show');
    Route::post('/contact', 'ContactController@submit')->name('contact.submit');
    Route::get('/contact/sent', 'ContactController@sent');

    /* Install Routes */

    Route::get('/start', 'StartController@show');
    Route::post('/start/install', 'StartController@install')->name('start.install');
    Route::post('/start/update', 'StartController@update')->name('start.update');

    /* Notifications Routes */

    Route::get('/notifications', 'NotificationsController@show')->middleware(MaintenanceMode::class);
    Route::get('/notifications/clear', 'NotificationsController@clear');
    Route::get('/notification/{notification}', 'NotificationsController@view');

    /* Category Routes */

    Route::get('/category', function () {
        App::abort(404);
    });
    Route::get('/category/{c}', 'CategoryController@show')->middleware(MaintenanceMode::class);

    /* Report Routes */

    Route::post('/report/comment', 'ReportController@reportComment')->name('report.comment');
    Route::post('/report/discussion', 'ReportController@reportDiscussion')->name('report.discussion');
    Route::post('/report/message', 'ReportController@reportMessage')->name('report.message');
    Route::post('/report/user', 'ReportController@reportUser')->name('report.user');

    /* Control Panel Routes */

    Route::get('/controlpanel', 'ControlPanelController@show');
    Route::get('/controlpanel/{page}', 'ControlPanelController@show');
    Route::get('/controlpanel/user/{user}', 'ControlPanelController@showUser');
    Route::get('/controlpanel/report/{report}', 'ControlPanelController@showReport');

    Route::post('/controlpanel/settings', 'ControlPanelController@settingsSubmit')->name('controlpanel.settingsSubmit');
    Route::post('/controlpanel/report/handle', 'ControlPanelController@reportHandle')->name('controlpanel.reportHandle');
    Route::post('/controlpanel/report/delete', 'ControlPanelController@reportDelete')->name('controlpanel.reportDelete');

    Route::post('/controlpanel/user/group', 'ControlPanelController@userModifyGroup')->name('controlpanel.userModifyGroup');
    Route::post('/controlpanel/user/ban', 'ControlPanelController@userBan')->name('controlpanel.userBan');
    Route::post('/controlpanel/user/unban', 'ControlPanelController@userUnban')->name('controlpanel.userUnban');
    Route::post('/controlpanel/user/avatardelete', 'ControlPanelController@userDeleteAvatar')->name('controlpanel.userDeleteAvatar');
    Route::post('/controlpanel/user/submit', 'ControlPanelController@userSubmit')->name('controlpanel.userSubmit');
    Route::post('/controlpanel/user/delete', 'ControlPanelController@userDelete')->name('controlpanel.userDelete');

    Route::post('/controlpanel/section/new', 'ControlPanelController@sectionNew')->name('controlpanel.sectionNew');
    Route::post('/controlpanel/section/manage', 'ControlPanelController@sectionManage')->name('controlpanel.sectionManage');
    Route::post('/controlpanel/section/delete', 'ControlPanelController@sectionDelete')->name('controlpanel.sectionDelete');

    Route::post('/controlpanel/category/new', 'ControlPanelController@categoryNew')->name('controlpanel.categoryNew');
    Route::post('/controlpanel/category/manage', 'ControlPanelController@categoryManage')->name('controlpanel.categoryManage');
    Route::post('/controlpanel/category/delete', 'ControlPanelController@categoryDelete')->name('controlpanel.categoryDelete');

    /* Messages Routes */

    Route::group(['middleware' => ['auth', 'verified']], function() {
        Route::get('/messages', function () {
            return redirect('/messages/inbox');
        })->middleware(MaintenanceMode::class);
        Route::get('/message', function () {
            App::abort(404);
        })->middleware(MaintenanceMode::class);
        Route::get('/messages/{m1}', 'MessagesController@showMessages')->middleware(MaintenanceMode::class);
        Route::get('/message/{m2}', 'MessagesController@showMessage')->middleware(MaintenanceMode::class);
        Route::get('/message/{m2}/{m2r}', 'MessagesController@showMessage')->middleware(MaintenanceMode::class);
    });

    Route::get('/usersearch', [UserSearchController::class, 'userSearch']);

    Route::post('/messages', 'MessagesController@submit')->name('message.submit');
    
    /* Search Routes */

    Route::get('/search', 'SearchController@showForm')->middleware(MaintenanceMode::class);
    Route::get('/search/comments/{user}', 'SearchController@searchUserComments');
    Route::get('/search/discussions/{user}', 'SearchController@searchUserDiscussions');
    //Route::get('/search/results', 'SearchController@searchResults');
    Route::post('/search/results', 'SearchController@searchResults')->name('search.searchResults');
    Route::group(['middleware' => ['auth', 'verified']], function() {
        Route::get('/search/newposts', 'SearchController@searchNewPosts');
    });

    /* Member Routes */

    Route::get('/member', function () {
        App::abort(404);
    });

    Route::get('/member/{username}', 'MemberController@show')->middleware(MaintenanceMode::class);

    /* Settings Routes */

    Route::group(['middleware' => ['auth', 'verified']], function() {
        Route::get('/settings', 'SettingsController@show')->middleware(MaintenanceMode::class);
        Route::post('/settings/submit', 'SettingsController@submitSettings')->name('settings.submit');
        Route::post('/settings/avatar', 'SettingsController@uploadAvatar')->name('avatar.upload');
        Route::post('/settings/avatardelete', 'SettingsController@deleteAvatar')->name('avatar.delete');
    });

    /* Watched Routes */

    Route::group(['middleware' => ['auth', 'verified']], function() {
        Route::get('/watched', 'WatchedController@show')->middleware(MaintenanceMode::class);
        Route::post('/watched/unwatch', 'WatchedController@unwatch')->name('watched.unwatch');
        Route::get('/watch/{slug}', 'WatchedController@watch');
    });


    /* New Discussion Routes */

    Route::group(['middleware' => ['auth', 'verified']], function() {
        Route::get('/newdiscussion', 'DiscussionController@showNew')->middleware(MaintenanceMode::class);
        Route::get('/newdiscussion/{slug}', 'DiscussionController@showNew')->middleware(MaintenanceMode::class);
        Route::post('/newdiscussion', 'DiscussionController@submit')->name('discussion.submit');
    });

    /* Discussion Routes */

    Route::get('/discussion', function () {
        App::abort(404);
    });

    Route::get('/discussion/{slug}', 'DiscussionController@show')->middleware(MaintenanceMode::class);
    Route::get('/discussion/{slug}/lastreply', 'DiscussionController@showLast')->middleware(MaintenanceMode::class);

    Route::post('/discussion', 'DiscussionController@submitReply')->name('discussion.reply');
    Route::post('/discussion-lock', 'DiscussionController@lock')->name('discussion.lock');
    Route::post('/discussion-unlock', 'DiscussionController@unlock')->name('discussion.unlock');
    Route::post('/discussion-hide', 'DiscussionController@hide')->name('discussion.hide');
    Route::post('/discussion-unhide', 'DiscussionController@unhide')->name('discussion.unhide');
    Route::post('/discussion-move', 'DiscussionController@move')->name('discussion.move');
    Route::post('/discussion-delete', 'DiscussionController@delete')->name('discussion.delete');
    Route::post('/discussion-edit', 'DiscussionController@edit')->name('discussion.edit');
    Route::post('/discussion-editComment', 'DiscussionController@editComment')->name('discussion.editComment');
    Route::post('/discussion-deleteComment', 'DiscussionController@deleteComment')->name('discussion.deleteComment');

    /* User Authentication Routes */

    Route::group(['middleware' => ['guest']], function() {

        Route::get('/register', 'RegisterController@show')->name('register.show')->middleware(MaintenanceMode::class);
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::get('/login', 'LoginController@show')->name('login');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
      
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

    });

    Route::get('/forgot-password', function () {
        return view('forgot-password');
    })->middleware('guest')->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
     
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    })->middleware('guest')->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ]);
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ? redirect('/login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    })->middleware('guest')->name('password.update');

    Route::get('/email/verify', function () {
        return view('verify-email');
    })->middleware('auth')->name('verification.notice');

 
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
     
        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    /* CAPTCHA Routes */

    Route::get('/reload-captcha', [CaptchaServiceController::class, 'reloadCaptcha']);

    /* Badges Routes */

    Route::get('/get-badges', [BadgeController::class, 'getBadges']);

});