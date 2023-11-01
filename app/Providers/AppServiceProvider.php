<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict(app()->isLocal());

        if (app()->isProduction()) {
            DB::listen(static function (QueryExecuted $query) {
                if ($query->time > 500) {
                    logger()
                        ->channel('telegram')
                        ->debug('Query Longer Than 5ms: ' . $query->sql, $query->bindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(CarbonInterval::seconds(4), static function () {
                logger()
                    ->channel('telegram')
                    ->debug('Request Lifecycle Is Longer Than ' . request()->url());
            });
        }
    }
}
