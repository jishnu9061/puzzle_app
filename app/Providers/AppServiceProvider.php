<?php

namespace App\Providers;

use App\Repositories\PuzzleRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\PuzzleRepositoryInterface;
use App\Repositories\LeaderboardRepository;
use App\Repositories\Contracts\LeaderboardRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PuzzleRepositoryInterface::class, PuzzleRepository::class);
        $this->app->bind(LeaderboardRepositoryInterface::class, LeaderboardRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
