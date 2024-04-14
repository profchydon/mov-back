<?php

namespace App\Console\Commands;

use App\Models\Asset;
use Illuminate\Console\Command;

class UpdateAssetsScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-assets-score';

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
        Asset::query()->oldest()->chunk(500, function($assets){
            foreach ($assets as $asset){
                $asset->update([
                    'score' => $asset->calculateScore()
                ]);
            }
        });
    }
}
