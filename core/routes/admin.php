<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::middleware('admin.guest')->group(function () {
        Route::controller('LoginController')->group(function () {
            Route::get('/', 'showLoginForm')->name('login');
            Route::post('/', 'login')->name('login');
            Route::get('logout', 'logout')->middleware('admin')->withoutMiddleware('admin.guest')->name('logout');
        });

        // Admin Password Reset
        Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
            Route::get('reset', 'showLinkRequestForm')->name('reset');
            Route::post('reset', 'sendResetCodeEmail');
            Route::get('code-verify', 'codeVerify')->name('code.verify');
            Route::post('verify-code', 'verifyCode')->name('verify.code');
        });

        Route::controller('ResetPasswordController')->group(function () {
            Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
            Route::post('password/reset/change', 'reset')->name('password.change');
        });
    });
});

Route::middleware('admin')->group(function () {
    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications', 'notifications')->name('notifications');
        Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        Route::get('notifications/read-all', 'readAllNotification')->name('notifications.read.all');
        Route::post('notifications/delete-all', 'deleteAllNotification')->name('notifications.delete.all');
        Route::post('notifications/delete-single/{id}', 'deleteSingleNotification')->name('notifications.delete.single');

        //Report Bugs
        Route::get('request-report', 'requestReport')->name('request.report');
        Route::post('request-report', 'reportSubmit');

        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
    });

    //===============start the contact route ===========
    Route::prefix('contact')->name('contact.')->controller("ContactController")->group(function () {
        Route::get('all', 'all')->name('all');
        Route::post('store', 'save')->name('store');
        Route::post('update/{id}', 'save')->name('update');
        Route::post('import', 'importContact')->name('import');
        Route::post('export', 'exportContact')->name('export');
        Route::get('email', 'emailContact')->name('email');
        Route::get('sms', 'smsContact')->name('sms');
        Route::get('contact/search/{contact_type}/', "contactSearch")->name('search');
        Route::post('status/{id}', 'status')->name('status');
    });

    //=============== Start the group route ===========
    Route::prefix('group')->controller("GroupController")->group(function () {
        Route::name('group.')->group(function () {
            Route::post('store', 'saveGroup')->name('store');
            Route::get('banned', 'banned')->name('banned');
            Route::post('update/{id}', 'saveGroup')->name('update');
            Route::post('delete/contact/{id}', 'deleteContactFromGroup')->name('delete.contact');
            Route::get('contact/view/{id}/{groupType}', 'viewGroupContact')->name('contact.view');
            Route::post('save/contact/{groupId}/{groupType}', 'contactSaveToGroup')->name('to.contact.save');
            Route::post('import/contact/{groupId}/{groupType}', 'importContactToGroup')->name('import.contact');
            Route::post('status/{id}', 'status')->name('status');

        });
        Route::name('email.group.')->prefix('email-group')->group(function () {
            Route::get('index', 'emailGroup')->name('index');
        });
        Route::name('sms.group.')->prefix('sms-group')->group(function () {
            Route::get('index', 'smsGroup')->name('index');
        });
    });

    Route::controller("EmailController")->name('email.')->prefix('email')->group(function () {
        Route::get("/history", "history")->name('history');
        Route::post("/merge", "merge")->name('merge');
        Route::get("/send", "sendEmail")->name('send');
        Route::post("/send", "send")->name('send');
        Route::get("/view/{id}", "view")->name('view');
    });

    Route::controller("SmsController")->group(function () {
        Route::name('sms.')->prefix('sms')->group(function () {
            Route::get("/history", "history")->name('history');
            Route::get("/send", "sendSms")->name('send');
            Route::post("/send", "send")->name('send');
            Route::get("/view/{id}", "view")->name('view');
        });
        Route::post("/mobile/number/merge", "mobileNumberMerge")->name('mobile.number.merge');
    });

    Route::controller('BatchController')->name('batch.')->group(function () {
        Route::get('email', 'emailBatch')->name('email');
        Route::get('sms', 'smsBatch')->name('sms');
    });

    //================== Start the smtp route=========
    Route::controller('SmtpController')->name('smtp.')->prefix('smtp')->group(function () {
        Route::get('/index', "index")->name('index');
        Route::post('/store', "save")->name('store');
        Route::post('/update/{id}', "save")->name('update');
        Route::post('status/{id}', 'status')->name('status');
    });

    // Admin Support
    Route::controller('SupportTicketController')->prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/', 'tickets')->name('index');
        Route::get('pending', 'pendingTicket')->name('pending');
        Route::get('closed', 'closedTicket')->name('closed');
        Route::get('answered', 'answeredTicket')->name('answered');
        Route::get('view/{id}', 'ticketReply')->name('view');
        Route::post('reply/{id}', 'replyTicket')->name('reply');
        Route::post('close/{id}', 'closeTicket')->name('close');
        Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
        Route::post('delete/{id}', 'ticketDelete')->name('delete');
    });


    Route::controller('GeneralSettingController')->group(function () {
        Route::get('system-setting', 'systemSetting')->name('setting.system');
        // General Setting
        Route::get('general-setting', 'general')->name('setting.general');
        Route::post('general-setting', 'generalUpdate');

        Route::get('setting/social/credentials', 'socialiteCredentials')->name('setting.socialite.credentials');
        Route::post('setting/social/credentials/update/{key}', 'updateSocialiteCredential')->name('setting.socialite.credentials.update');
        Route::post('setting/social/credentials/status/{key}', 'updateSocialiteCredentialStatus')->name('setting.socialite.credentials.status.update');

        //configuration
        Route::get('setting/system-configuration', 'systemConfiguration')->name('setting.system.configuration');
        Route::post('setting/system-configuration', 'systemConfigurationSubmit');

        // Logo-Icon
        Route::get('setting/logo-icon', 'logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css', 'customCss')->name('setting.custom.css');
        Route::post('custom-css', 'customCssSubmit');

        Route::get('sitemap', 'sitemap')->name('setting.sitemap');
        Route::post('sitemap', 'sitemapSubmit');

        Route::get('robot', 'robot')->name('setting.robot');
        Route::post('robot', 'robotSubmit');

    });

    Route::controller('CronConfigurationController')->name('cron.')->prefix('cron')->group(function () {
        Route::get('index', 'cronJobs')->name('index');
        Route::post('store', 'cronJobStore')->name('store');
        Route::post('update', 'cronJobUpdate')->name('update');
        Route::post('delete/{id}', 'cronJobDelete')->name('delete');
        Route::get('schedule', 'schedule')->name('schedule');
        Route::post('schedule/store', 'scheduleStore')->name('schedule.store');
        Route::post('schedule/status/{id}', 'scheduleStatus')->name('schedule.status');
        Route::get('schedule/pause/{id}', 'schedulePause')->name('schedule.pause');
        Route::get('schedule/logs/{id}', 'scheduleLogs')->name('schedule.logs');
        Route::post('schedule/log/resolved/{id}', 'scheduleLogResolved')->name('schedule.log.resolved');
        Route::post('schedule/log/flush/{id}', 'logFlush')->name('log.flush');
    });

    //Notification Setting
    Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function () {
        //Template Setting
        Route::get('global/email', 'globalEmail')->name('global.email');
        Route::post('global/email/update', 'globalEmailUpdate')->name('global.email.update');

        Route::get('global/sms', 'globalSms')->name('global.sms');
        Route::post('global/sms/update', 'globalSmsUpdate')->name('global.sms.update');

        Route::get('templates', 'templates')->name('templates');
        Route::get('template/edit/{type}/{id}', 'templateEdit')->name('template.edit');
        Route::post('template/update/{type}/{id}', 'templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting', 'emailSetting')->name('email');
        Route::post('email/setting', 'emailSettingUpdate');
        Route::post('email/test', 'emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting', 'smsSetting')->name('sms');
        Route::post('sms/setting', 'smsSettingUpdate');
        Route::post('sms/test', 'smsTest')->name('sms.test');
    });

    // Plugin
    Route::controller('ExtensionController')->prefix('extensions')->name('extensions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('status/{id}', 'status')->name('status');
    });

    //System Information
    Route::controller('SystemController')->name('system.')->prefix('system')->group(function () {
        Route::get('info', 'systemInfo')->name('info');
        Route::get('server-info', 'systemServerInfo')->name('server.info');
        Route::get('optimize', 'optimize')->name('optimize');
        Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
        Route::get('system-update', 'systemUpdate')->name('update');
        Route::post('system-update', 'systemUpdateProcess')->name('update.process');
        Route::get('system-update/log', 'systemUpdateLog')->name('update.log');
    });
});
