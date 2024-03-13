<?php

namespace Database\Seeders;

use App\Models\PaymentProcessor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class PaymentProcessorSeeder extends Seeder
{

    public function run(): void
    {
        $directoryPath = base_path('database/seeders/config/payment_processors');
        $files = File::files($directoryPath);

        foreach ($files as $file) {
            $seedFile = Yaml::parseFile($file->getPathname());
            PaymentProcessor::firstOrCreate($seedFile);
        }
    }
}
