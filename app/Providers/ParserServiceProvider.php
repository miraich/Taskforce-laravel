<?php

namespace App\Providers;

use App\Helpers\CSV_parser\Csv_parser;
use Illuminate\Support\ServiceProvider;

class ParserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
//        $parser = new Csv_parser();
//        $parser->importCsv();
    }
}
