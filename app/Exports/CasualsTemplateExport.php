<?php

namespace App\Exports;

use App\Models\Casual;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class CasualsTemplateExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Casual::all();

    }

    public function headings(): array
    {
        return [
        'first_name',
        'last_name',
        'phone',
        'designation',
        'gender',
        'official_identification_number',
        'date_of_joining',
        'status',
        'about'
        ];


    }

    public function map($casual): array
    {
        return
        [
            $casual->first_name,
            $casual->last_name,
            $casual->phone,
            $casual->designation,
            $casual->gender,
            $casual->official_identification_number,
            $casual->date_of_joining,
            $casual->status,
            $casual->about
        ];
    }
}
