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
        Response::macro('successful', function ($success = true, $payload = []) {
            return response()->json(array_merge($payload, [
                'success' => $success
            ]));
        });
    }
}
