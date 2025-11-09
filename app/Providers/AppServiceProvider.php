<?php

namespace App\Providers;

use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Share topbar notifications to all views
        View::composer('*', function ($view) {
            $repo = app(NotificationRepository::class);
            $latestNotifications = $repo->getLatestNotifications();
            $unreadCount = $repo->countUnread();

            $view->with(compact('latestNotifications', 'unreadCount'));
        });
    }
}
