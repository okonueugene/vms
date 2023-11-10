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

        if (count(array_diff($requiredColumns, array_keys($row))) > 0) {
            //output error
            return 'error';
        }

        // Check if the date is in a valid format
        if (strtotime($row['date_of_joining']) !== false) {
            // If the date is a parsable string (e.g., '2023-10-26')

            $formattedDate = Carbon::parse($row['date_of_joining'])->format('Y-m-d');


        } elseif (is_numeric($row['date_of_joining'])) {
            // If the date is in an Excel serialized format
            $date = Date::excelToDateTimeObject($row['date_of_joining']);
            $formattedDate = Carbon::instance($date)->format('Y-m-d');
        } else {
            // If the date format isn't recognized, you need to decide how to handle this case
            $formattedDate = null; // Or set it to a default value or log an error
        }

        //validation rules
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:employees,phone', // Add validation for unique phone
            'gender' => 'required|in:male,female', // Add validation for valid gender values
            'official_identification_number' => 'required', // Add validation if necessary
            'department' => 'required', // Add validation if necessary
            'designation' => 'required', // Add validation if necessary
            'about' => 'nullable', // Add validation if necessary
        ];

        $request = new Request($row);
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return new Casual([
            'first_name' => $row['first_name'] ?? null,
            'last_name' => $row['last_name'] ?? null,
            'phone' => $row['phone'] ?? null,
            'designation' => $row['designation'] ?? null,
            'gender' => $row['gender'] ?? null,
            'official_identification_number' => $row['official_identification_number'] ?? null,
            'date_of_joining' => $formattedDate ?? null,
            'status' => $row['status'] ?? null,
            'about' => $row['about'] ?? null,

        ]);
    }
}
