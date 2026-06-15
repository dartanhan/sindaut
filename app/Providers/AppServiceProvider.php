<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Composer para a barra lateral de Últimas Notícias (últimos 12 meses, limite 15)
        view()->composer('site.ultimas-noticias', function ($view) {
            $noticias = \Illuminate\Support\Facades\Cache::remember('site:sidebar_noticias', 86400, function () {
                return \App\Models\Noticia::with('imagens')
                    ->where('status', 1)
                    ->where('created_at', '>=', now()->subMonths(12))
                    ->orderBy('created_at', 'desc')
                    ->take(15)
                    ->get();
            });

            $view->with('noticias', $noticias);
        });

        // Composer para o ticker de notícias do cabeçalho (últimas 10 notícias)
        view()->composer('site.newsarea', function ($view) {
            $noticias = \Illuminate\Support\Facades\Cache::remember('site:ticker_noticias', 86400, function () {
                return \App\Models\Noticia::with('imagens')
                    ->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
            });

            $view->with('noticias', $noticias);
        });
    }
}
