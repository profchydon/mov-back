<?php

namespace Database\Seeders;

use App\Domains\Constant\InvoiceConstant;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;
use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $company = Company::limit(1)->get();

        // Invoice::create([
        //     InvoiceConstant::COMPANY_ID => $company[0]->id,
        //     InvoiceConstant::TENANT_ID => $company[0]->tenant_id,
        //     InvoiceConstant::INVOICE_NUMBER => '4700000000',
        //     InvoiceConstant::DATE_ISSUED => now(),
        //     InvoiceConstant::DUE_DATE => now(),
        //     InvoiceConstant::PAID_AT => now(),
        //     InvoiceConstant::SUB_TOTAL => 2000,
        //     InvoiceConstant::TAX => 0,
        //     InvoiceConstant::CURRENCY_ID => 1,
        //     InvoiceConstant::TRANSACTION_REF => 'tx_regsg_123',
        //     InvoiceConstant::STATUS => InvoiceStatusEnum::PENDING->value,
        // ]);
    }
}
