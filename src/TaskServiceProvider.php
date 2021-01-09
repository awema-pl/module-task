<?php

namespace AwemaPL\Task;


use AwemaPL\Task\User\Sections\Statuses\Models\Status;
use AwemaPL\Task\User\Sections\Statuses\Repositories\Contracts\StatusRepository;
use AwemaPL\Task\User\Sections\Statuses\Repositories\EloquentStatusRepository;
use AwemaPL\Task\Admin\Sections\Settings\Repositories\Contracts\SettingRepository;
use AwemaPL\Task\Admin\Sections\Settings\Repositories\EloquentSettingRepository;
use AwemaPL\Task\User\Sections\Statuses\Policies\StatusPolicy;
use AwemaPL\BaseJS\AwemaProvider;
use AwemaPL\Task\Listeners\EventSubscriber;
use AwemaPL\Task\Admin\Sections\Installations\Http\Middleware\GlobalMiddleware;
use AwemaPL\Task\Admin\Sections\Installations\Http\Middleware\GroupMiddleware;
use AwemaPL\Task\Admin\Sections\Installations\Http\Middleware\Installation;
use AwemaPL\Task\Admin\Sections\Installations\Http\Middleware\RouteMiddleware;
use AwemaPL\Task\Contracts\Task as TaskContract;
use Illuminate\Support\Facades\Event;

class TaskServiceProvider extends AwemaProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Status::class => StatusPolicy::class,
    ];

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'task');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'task');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->bootMiddleware();
        app('task')->includeLangJs();
        app('task')->menuMerge();
        app('task')->mergePermissions();
        $this->registerPolicies();
        Event::subscribe(EventSubscriber::class);
        parent::boot();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/task.php', 'task');
        $this->mergeConfigFrom(__DIR__ . '/../config/task-menu.php', 'task-menu');
        $this->app->bind(TaskContract::class, Task::class);
        $this->app->singleton('task', TaskContract::class);
        $this->registerRepositories();
        $this->registerServices();
        parent::register();
    }


    public function getPackageName(): string
    {
        return 'task';
    }

    public function getPath(): string
    {
        return __DIR__;
    }

    /**
     * Register and bind package repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->app->bind(StatusRepository::class, EloquentStatusRepository::class);
        $this->app->bind(SettingRepository::class, EloquentSettingRepository::class);
    }

    /**
     * Register and bind package services
     *
     * @return void
     */
    protected function registerServices()
    {
    }

    /**
     * Boot middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootMiddleware()
    {
        $this->bootGlobalMiddleware();
        $this->bootRouteMiddleware();
        $this->bootGroupMiddleware();
    }

    /**
     * Boot route middleware
     */
    private function bootRouteMiddleware()
    {
        $router = app('router');
        $router->aliasMiddleware('task', RouteMiddleware::class);
    }

    /**
     * Boot grEloquentAccountRepositoryoup middleware
     */
    private function bootGroupMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->appendMiddlewareToGroup('web', GroupMiddleware::class);
        $kernel->appendMiddlewareToGroup('web', Installation::class);
    }

    /**
     * Boot global middleware
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function bootGlobalMiddleware()
    {
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
        $kernel->pushMiddleware(GlobalMiddleware::class);
    }
}
