<?php

namespace App\Providers;

use App\Repositories\Meeting\MeetingInterface;
use App\Repositories\Meeting\MeetingRepository;
use App\Repositories\Task\TaskInterface;
use App\Repositories\Task\TaskRepository;
use App\Repositories\TodoTask\TodoTaskInterface;
use App\Repositories\TodoTask\TodoTaskRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(TaskInterface::class, TaskRepository::class);
        $this->app->bind(TodoTaskInterface::class, TodoTaskRepository::class);
        $this->app->bind(MeetingInterface::class, MeetingRepository::class);
    }
}
