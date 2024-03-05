<?php

namespace App\Imports;

use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Models\Asset;
use App\Models\Company;
use App\Rules\HumanNameRule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AssetImport implements WithValidation, WithHeadingRow, ToModel, ShouldQueue, WithChunkReading
{
    public function __construct(private readonly Company $company)
    {
    }

    public function prepareForValidation($data, $index)
    {
        $data['purchase_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['purchase_date'])->format('Y-m-d');

        return $data;
    }

    public function rules(): array
    {
        return [
            'make' => 'required|string',
            'model' => 'required|string',
            'type_id' => ['required', 'string', Rule::exists('asset_types', 'id')],
            'purchase_price' => ['required', 'numeric', 'min:1'],
            'purchase_date' => 'nullable|date_format:Y-m-d',
            'office_id' => ['required', Rule::exists('offices', 'id')],
            'currency' => ['required', Rule::exists('currencies', 'code')],
        ];
    }

    public function model(array $row)
    {
        return new Asset([
            'tenant_id' => $this->company->tenant_id,
            'company_id' => $this->company->id,
            'make' => $row['make'],
            'model' => $row['model'],
            'type_id' => $row['type_id'],
            'purchase_price' => $row['purchase_price'],
            'purchase_date' => Date::createFromFormat('Y-m-d', $row['purchase_date']),
            'office_id' => $row['office_id'],
            'currency' => $row['currency'],
            'added_at' => now(),
            'status' => AssetStatusEnum::AVAILABLE,
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
