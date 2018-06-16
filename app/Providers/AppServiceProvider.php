<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('exists1', function ($a, $value, $parameters, $d) {
            if (!is_array($value)) 
                $value = json_decode($value);

            if (!is_array($value))
                return false;

            $table = $parameters[0];
            $column = $parameters[1];

            foreach ($value as $id) {
                $query = DB::table($table)->where($column, $id)->count();
                if ($query < 1) return false;
            }

            return true;
        });

        Validator::extend('gender', function ($a, $value, $parameters, $b) {
            return $value == 'Male' || $value == 'Female';
        });

        Validator::extend('age', function ($a, $value, $parameters, $b) {
            $birthday = date_create($value);
            $today = date_create();
            $age = date_diff($birthday, $today)->y;
            $minage = config('app.minage');
            return $age >= $minage;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
