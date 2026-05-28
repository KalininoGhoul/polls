<?php

namespace App\Providers;

use App\Services\Auth\CodeGenerators\AuthCodeGenerator;
use App\Services\Auth\CodeGenerators\SimpleAuthCodeGenerator;
use App\Services\Auth\CodeSenders\LogAuthCodeSender;
use App\Services\Centrifugal\CentrifugalClient\CentrifugalClient;
use App\Services\Centrifugal\CentrifugalClient\CentrifugalHttpClient;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Http;
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

        $this->app->singleton(CentrifugalClient::class, fn () => new CentrifugalHttpClient(
            Http::baseUrl(config('services.centrifugal.api.base_url'))
                ->withHeader('X-API-Key', config('services.centrifugal.api.key')),
            Log::channel('centrifugal'),
        ));
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
