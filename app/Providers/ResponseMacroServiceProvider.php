<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('successfulOrFailed', function ($success = true, $payload = []) {
            return response()->json(array_merge($payload, [
                'success' => $success
            ]));
        });

        Response::macro('successful', function ($payload = []) {
            return response()->json(array_merge($payload, [
                'success' => true
            ]));
        });

        Response::macro('failed', function ($payload = []) {
            return response()->json(array_merge($payload, [
                'success' => false
            ]));
        });
    }
}
