<?php

namespace App\Console\Commands;

use App\Exceptions\PersonalException;
use App\Service\Api\ApiService;
use App\Service\Categoria\CategoriaService;
use App\Service\TipoInvestimento\TipoInvestimentoService;
use Illuminate\Console\Command;
use Normalizer;

class teste extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:teste';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $string = 'Descrição';

        $normalized = Normalizer::normalize($string, Normalizer::NFD);
        echo preg_replace('/[\x{0300}-\x{036F}]/u', '', $normalized);
    }
}
