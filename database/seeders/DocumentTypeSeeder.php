<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            'License',
            'Policy',
            'Invoice',
            'Receipt',
            'Warranty'
        ])->each(fn($type) => DocumentType::firstOrCreate(['name' => $type]));
    }
}
