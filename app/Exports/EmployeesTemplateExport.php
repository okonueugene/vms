<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class EmployeesTemplateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function collection()
    {
        if ($this->data->isEmpty()) {
            [
    'first_name',
    'last_name',
    'phone',
    'nickname',
    'display_name',
    'gender',
    'official_identification_number',
    'date_of_joining',
    'status',
    'user_id',
    'department',
    'designation',
    'about'
    // 'creator_type',
    // 'creator_id',
    // 'editor_type',
    // 'editor_id',
    // 'created_at',
    // 'updated_at'
];
        }

        return new Collection($this->data);
    }


    public function headings(): array
    {
        if ($this->data->isEmpty()) {
            return [
                'first_name',
                'last_name',
                'phone',
                'nickname',
                'display_name',
                'gender',
                'official_identification_number',
                'date_of_joining',
                'status',
                'user_id',
                'department_id',
                'designation_id',
                'about'
                // 'creator_type',
                // 'creator_id',
                // 'editor_type',
                // 'editor_id',
                // 'created_at',
                // 'updated_at'
            ];
        } else {
            return [
                'first_name',
                'last_name',
                'phone',
                'nickname',
                'display_name',
                'gender',
                'official_identification_number',
                'date_of_joining',
                'status',
                'user_id',
                'department_id',
                'designation_id',
                'about',
                'creator_type',
                'creator_id',
                'editor_type',
                'editor_id',
                'created_at',
                'updated_at'
            ];
        }
    }

}