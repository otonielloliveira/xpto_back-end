<?php

namespace App\Console\Commands;

use App\Models\Url;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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


        $urls = Url::all();

        $this->info("Iniciando o carregamento das URL: " . count($urls));


        foreach ($urls as $url) {
            try {

                $response = Http::timeout(5)->get($url->url);
                $url->status = $response->status();
                $url->save();
            } catch (\Throwable $th) {
                Log::critical($th);
                $url->status = 404;
                $url->save();
            }
        }
        $this->info("Processo finalizado com sucesso!!");
        return "Comando executado com sucesso:" . count($urls);
    }
}
