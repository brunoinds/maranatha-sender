<?php

namespace App\Console;

use App\Models\CronRun;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Support\EventLoop\ReportsEventLoop;
use App\Support\EventLoop\RecordsEventLoop;
use App\Support\EventLoop\Notifications\Notifications;
use App\Support\EventLoop\Notifications\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        CronRun::create();

        $schedule->command('backup:clean; backup:run')->dailyAt('02:00')->timezone('America/Lima');

        $schedule->call(function(){
            Notifications::sendNotificationsToAdministrator(RecordsEventLoop::getNotifications('TrendingOnSpendings'));
        })->weekly()->sundays()->at('11:00')->timezone('America/Lima');

        $schedule->call(function(){
            Notifications::sendNotificationsToAdministrator(RecordsEventLoop::getNotifications('TrendingOnTimmingSubmittedAndApproved'));
            Notifications::sendNotificationsToAdministrator(RecordsEventLoop::getNotifications('TrendingOnTimmingApprovedAndRestituted'));
        })->weekly()->sundays()->at('11:30')->timezone('America/Lima');

        $schedule->call(function(){
            Notifications::sendNotificationsToAdministrator(ReportsEventLoop::getNotifications());
        })->daily()->at('19:15')->timezone('America/Lima');


        $schedule->call(function(){
            $notification = collect(new Notification(
                title: '⭐️ Prueba de notificación',
                message: 'Esto es una prueba de notificación automática del Cron Job'
            ));
            Notifications::sendNotificationsToAdministrator($notification);
        })->daily()->at('08:00')->timezone('America/Lima');


        $schedule->call(function(){
            $notification = collect([new Notification(
                title: '⭐️ Prueba de notificación',
                message: 'Esto es una prueba de notificación automática del Cron Job'
            )]);
            Notifications::sendNotificationsToAdministrator($notification);
        })->daily()->at('08:32')->timezone('America/Lima');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
