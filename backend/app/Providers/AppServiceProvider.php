<?php

namespace App\Providers;

use App\Services\Auth\CodeGenerators\AuthCodeGenerator;
use App\Services\Auth\CodeGenerators\SimpleAuthCodeGenerator;
use App\Services\Auth\CodeSenders\LogAuthCodeSender;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AuthCodeGenerator::class, fn () => new SimpleAuthCodeGenerator());

        $this->app->singleton(LogAuthCodeSender::class, fn () => new LogAuthCodeSender(
            Log::channel('auth'),
        ));
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
