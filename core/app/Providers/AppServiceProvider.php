<?php

namespace App\Providers;

use App\Constants\Status;
use App\Lib\Searchable;
use App\Models\AdminNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        Builder::mixin(new Searchable);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        if (!cache()->get('SystemInstalled')) {
            $envFilePath = base_path('.env');
            if (!file_exists($envFilePath)) {
                header('Location: install');
                exit;
            }
            $envContents = file_get_contents($envFilePath);
            if (empty($envContents)) {
                header('Location: install');
                exit;
            } else {
                cache()->put('SystemInstalled', true);
            }
        }

        $viewShare['emptyMessage'] = 'Data not found';
        view()->share($viewShare);

        view()->composer('admin.partials.sidenav', function ($view) {
            $view->with([
                'updateAvailable' => version_compare(gs('available_version'), systemDetails()['version'], '>') ? 'v' . gs('available_version') : false,
            ]);
        });

        view()->composer('admin.partials.topnav', function ($view) {
            $view->with([
                'adminNotifications'     => AdminNotification::where('is_read', Status::NO)->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('is_read', Status::NO)->count(),
            ]);
        });

        if (gs('force_ssl')) {
            \URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();
    }
}
