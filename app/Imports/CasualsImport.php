<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Casual;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CasualsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        // Check if all required columns are present in the row
        $requiredColumns = ['first_name', 'last_name', 'phone', 'designation', 'gender', 'official_identification_number', 'date_of_joining', 'status', 'about'];
        if (count(array_diff($requiredColumns, array_keys($row))) !== 0) {
            throw new ValidationException(null, [
                'Some required columns are missing.',
            ]);
        }

        // Check if the date is in a valid format
        if (strtotime($row['date_of_joining']) !== false) {
            // If the date is a parsable string format
            $formattedDate = Carbon::parse($row['date_of_joining'])->format('Y-m-d');
        } elseif (is_numeric($row['date_of_joining'])) {
            // If the date is in an Excel serialized format
            $date = Date::excelToDateTimeObject($row['date_of_joining']);
            $formattedDate = Carbon::instance($date)->format('Y-m-d');
        } else {
            $formattedDate = null;
        }

        //validation rules
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:casuals',
            'gender' => 'required',
            'official_identification_number' => 'required|unique:casuals',
            'department' => 'required',
            'designation' => 'required',
            'about' => 'nullable',
        ];

        //validate request
        $messages = [
            'phone.unique' => 'Phone number already exists in the system for one of the entries please check',
            'official_identification_number.unique' => 'Official identification number already exists in the system for one of the entries please check',
        ];


        $request = new Request($row);

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        //insert or update data base on official_identification_number

        return Casual::updateOrCreate(
            [
                'official_identification_number' => $row['official_identification_number'] ?? null,
            ],
            [
                'first_name' => $row['first_name'] ?? null,
                'last_name' => $row['last_name'] ?? null,
                'phone' => $row['phone'] ?? null,
                'designation' => $row['designation'] ?? null,
                'gender' => $row['gender'] ?? null,
                'date_of_joining' => $formattedDate ?? null,
                'status' => $row['status'] ?? null,
                'about' => $row['about'] ?? null,
            ]
        );

    }
}
