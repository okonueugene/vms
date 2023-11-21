<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EmployeesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    // public function rules(): array
    // {
    //     return [
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'phone' => 'required|unique:employees,phone', // Add validation for unique phone
    //         'gender' => 'required|in:male,female', // Add validation for valid gender values
    //         'official_identification_number' => 'required', // Add validation if necessary
    //         'date_of_joining' => 'required|date', // Add validation for valid date format
    //         'status' => 'required|in:Active,Inactive', // Add validation for valid status values
    //         'department' => 'required', // Add validation if necessary
    //         'designation' => 'required', // Add validation if necessary
    //         'about' => 'nullable', // Add validation if necessary
    //     ];
    // }

    public function model(array $row)
    {
        // Check if all required columns are present in the row
        $required = [
        'first_name',
        'last_name',
        'phone',
        'gender',
        'official_identification_number',
        'date_of_joining',
        'status',
        'department',
        'designation',
        'about'];

        if (count(array_diff($required, array_keys($row))) > 0) {
            //output error
            return 'error';
        }

        // Check if the date is in a valid format
        if (strtotime($row['date_of_joining']) !== false) {
            // If the date is a parsable string (e.g., '2023-10-26')

            $formattedDate = Carbon::parse($row['date_of_joining'])->format('Y-m-d');


        } elseif (is_numeric($row['date_of_joining'])) {
            // If the date is in an Excel serialized format
            $formattedDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_joining'])->format('Y-m-d');

        } else {
            // If the date format isn't recognized, you need to decide how to handle this case
            $formattedDate = null; // Or set it to a default value or log an error
        }

        //validate data
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:employees,phone', // Add validation for unique phone
            'gender' => 'required', // Add validation for valid gender values
            'official_identification_number' => 'required', // Add validation if necessary
            'status' => 'required|in:Active,Inactive', // Add validation for valid status values
            'department' => 'required', // Add validation if necessary
            'designation' => 'required', // Add validation if necessary
            'about' => 'nullable', // Add validation if necessary
        ];

        $request = new Request($row);
        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // create user then employee

        $input['first_name'] = $row['first_name'] ?? null;
        $input['last_name'] = $row['last_name'] ?? null;
        $input['username'] = $this->username($row['email']);
        $input['email'] = $row['email'] ?? null;
        $input['phone'] = $row['phone'] ?? null;
        $input['status'] = $row['status'] == 'Active' ? 5 : 10;
        $input['password'] = Hash::make('vmspbc@2023');
        $user = User::create($input);
        $role = Role::find(2);
        $user->assignRole($role->name);

        Department::firstOrCreate(['name' => $row['department'], 'status' => 5]);
        Designation::firstOrCreate(['name' => $row['designation'], 'status' => 5]);

        $department_id = Department::where('name', 'like', '%' . $row['department'] . '%')->first()->id;

        $designation_id = Designation::where('name', 'like', '%' . $row['designation'] . '%')->first()->id;


        //user created now create employee
        $result = '';
        if($user) {
            $data['first_name'] = $row['first_name'];
            $data['last_name'] = $row['last_name'];
            $data['phone'] = $row['phone'];
            $data['user_id'] = $user->id;
            $data['gender'] = strtolower($row['gender']) == 'male' ? 5 : 10;
            $data['department_id'] = $department_id;
            $data['designation_id'] = $designation_id;
            $data['date_of_joining'] = $formattedDate ?? null;
            $data['about'] = $row['about'];
            $data['status'] = strtolower($row['status']) == 'active' ? 5 : 10;
            $result = Employee::create($data);


        }
        return $result;

    }

    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }

}
