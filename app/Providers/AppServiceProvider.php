<?php

namespace App\Providers;

use App;
use App\Library\Services\SqlDebug;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
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
        $this->app->bind('App\Library\Services\SqlDebugServiceInterface', 'App\Library\Services\SqlDebug');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('local')) {
            $sqlDebug = App::make(SqlDebug::class);

            \Event::listen(
                [
                    TransactionBeginning::class,
                ],
                function ($event) use ($sqlDebug) {
                    $sqlDebug->writeSqlStatement('  BEGIN; ', null);
                }
            );

            \Event::listen(
                [
                    TransactionCommitted::class,
                ],
                function ($event) use ($sqlDebug) {
                    $sqlDebug->writeSqlStatement('  COMMIT; ', null);
                }
            );

            \Event::listen(
                [
                    TransactionRolledBack::class,
                ],
                function ($event) use ($sqlDebug) {
                    $sqlDebug->writeSqlStatement('  ROLLBACK; ', null);
                }
            );

            \DB::listen(function ($query) use ($sqlDebug) {
                $bindings = [];
                foreach ($query->bindings as $binding) {
                    if ($binding instanceof \DateTime) {
                        $bindings[] = $binding->format('Y-m-d H:i:s');

                        continue;
                    }
                    $bindings[] = $binding;
                }

                $str = $query->sql;
                $str = str_replace('%', 'QWERTYQWERTY', $str);
                $str = str_replace('?', '%s', $str);
                $str = sprintf($str, ...$bindings);

                $sqlDebug->writeSqlStatement($str, $query->time);
            });
        } // if ($this->app->environment('local')) {
    }
}
