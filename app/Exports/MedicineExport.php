<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicineExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Medicine::orderBy('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Type',
            'Name',
            'Stock',
            'Price',
            'Created At',
        ];
    }

    public function map($medicine): array
    {
        return [
            $medicine->id,
            $medicine->type,
            $medicine->name,
            $medicine->stock,
            "$ " . number_format($medicine->price, 2, '.', ','),
            $medicine->created_at,
        ];
    }
}
