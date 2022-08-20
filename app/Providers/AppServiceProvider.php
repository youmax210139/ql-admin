<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLengthAwarePaginator();
    }

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class (...array_values($values)) extends LengthAwarePaginator
            {
                public function only(...$attributes)
                {
                    return $this->transform(function ($item) use ($attributes) {
                        return $item->only($attributes);
                    });
                }

                public function transform($callback)
                {
                    $this->items->transform($callback);

                    return $this;
                }

                public function toArray()
                {
                    $arr = parent::toArray();
                    $sort = urldecode(request('sort'));
                    $arr['pagination'] = [
                        'sortBy'      =>  str_replace('-', '', $sort) ?: 'id',
                        'descending'  =>  Str::contains($sort, '-'),
                        'page'        =>  $arr['current_page'],
                        'rowsPerPage' =>  $arr['per_page'],
                        'rowsNumber'  =>  $arr['total'],
                    ];
                    $arr = array_merge($arr, $this->additional ?? []);

                    return $arr;
                }

                public function merge(array $additiona)
                {
                    $this->additional = $additiona;
                    return $this;
                }
            };
        });
    }
}
