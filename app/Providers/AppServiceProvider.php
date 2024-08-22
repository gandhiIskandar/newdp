<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        Blade::directive('currency', function ($expression) {
            return "Rp <?php echo number_format($expression,0,',','.');?>";
        });

        // if(config('app.env') === 'local'){
        //     URL::forceScheme('https');
        // }

        View::composer('*', function ($view) {
          
            if (Auth::user()) {

                $user = session('user_data');
                $user = User::with('privileges')->find($user->id);

                session()->put('privileges', $user->privileges->pluck('id')->toArray());

            }

        });
    }
}
