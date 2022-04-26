<?php

namespace App\Console\Commands;

use App\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckUrlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checagem das urls';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        try {
            $urls = Url::all();

            foreach ($urls as $url) {
                $response = Http::get($url->url);
                $url->status = $response->status();
                $url->save();
            }
        } catch (\Throwable $th) {
            return false;
        }
        return 0;
    }
}
