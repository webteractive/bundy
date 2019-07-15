<?php

namespace App\Providers;

use App\Bundy\Pathfinder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('pathfinder', function () {
            return "<?php echo app('" . Pathfinder::class . "')->export(); ?>";
        });
    }
}
