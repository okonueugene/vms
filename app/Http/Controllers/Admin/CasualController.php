<?php

namespace App\Http\Controllers\Admin;

use DB;
use Carbon\Carbon;
use App\Models\Casual;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Imports\CasualsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CasualsTemplateExport;

class CasualController extends Controller
{
    //pagination



    public function __construct()
    {
        $this->middleware('auth');
        $this->data['sitetitle'] = 'Casuals';

        $this->middleware(['permission:casuals'])->only('index');
        $this->middleware(['permission:casuals_create'])->only('create', 'store');
        $this->middleware(['permission:casuals_edit'])->only('edit', 'update');
        $this->middleware(['permission:casuals_delete'])->only('destroy');
    }

    public function index(Request $request)
    {
        $perPage = 8;
        $search = $request->input('search');

        $query = Casual::with('casualAttendance')->orderBy('id', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }

        $casuals = $query->paginate($perPage);

        return view('admin.casual.index', compact('casuals', 'search'));
    }



    public function create()
    {
        $departments = Department::all();
        $designations = DB::table("designations")->select("id", "name")->get();


        return view('admin.casual.create', compact('departments', 'designations'));
    }

    public function show($id)
    {
        $casual = Casual::findOrFail($id);

        if (!$casual) {
            return redirect()->back()->with('error', 'Casual not found');
        }

        return view('admin.casual.show', compact('casual'));
    }

    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'nullable|email|unique:casuals,email',
            'phone' => 'required|unique:casuals,phone',
            'designation_id' => 'required',
            'gender' => 'required',
            'official_identification_number' => 'required|unique:casuals,official_identification_number',
        ];

        $request->validate($rules);


        $data = $request->all();

        $data['date_of_joining'] = Carbon::parse($request->date_of_joining)->format('Y-m-d');
        $data['created_by'] = auth()->user()->id;
        $data['gender'] = $request->gender == 5 ? 'male' : 'female';
        $designation = Designation::where('id', $request->designation_id)->first();
        $data['designation'] = $designation->name;


        $casual = Casual::create($data);

        if ($casual) {
            return redirect()->route('admin.casuals.index')->with('success', 'Casual created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create the casual');
        }
    }

    public function edit($id)
    {
        $casual = Casual::findOrFail($id);
        $departments = Department::all();
        $statuses = [1 => 'active', 0 => 'inactive'];
        $designations = DB::table("designations")->select("id", "name")->get();

        if (!$casual) {
            return redirect()->back()->with('error', 'Casual not found');
        }

        return view('admin.casual.edit', compact('casual', 'departments', 'designations', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $casual = Casual::where('id', $id);

        if (!$casual) {
            return redirect()->back()->with('error', 'Casual not found');
        }

        $data ['first_name'] = $request->first_name;
        $data ['last_name'] = $request->last_name;
        $data ['email'] = $request->email;
        $data ['phone'] = $request->phone;
        $data ['official_identification_number'] = $request->official_identification_number;
        $data ['designation'] = $request->designation;
        $data ['status'] = $request->status;
        $data ['about'] = $request->about;
        $data ['updated_by'] = auth()->user()->id;

        $casual->update($data);

        return redirect()->route('admin.casuals.index')->with('success', 'Casual updated successfully');



    }


    public function destroy($id)
    {
        $casual = Casual::findOrFail($id);
        $casual->delete();

        return redirect()->route('admin.casuals.index')->with('success', 'Casual deleted successfully');
    }







    public function importCasuals(Request $request)
    {
        $rules = [
                  'file' => 'required|mimes:xls,xlsx'
              ];

        $messages = [
            'file.required' => 'Please upload a file',
            'file.mimes' => 'Incorrect file extension'
        ];

        $request->validate($rules, $messages);

        try {
            Excel::import(new CasualsImport(), $request->file('file'));

            return redirect()->back()->with('success', 'Casuals imported successfully.');
        } catch (ValidationException $e) {
            // Handle validation exception
            $errorMessage = implode('<br>', $e->validator->errors()->all());
            return redirect()->back()->with('error', $errorMessage);
        } catch (QueryException $e) {
            // Handle specific database exception (Integrity constraint violation)
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $errorMessage = 'Duplicate entry found. Please check your file for duplicate records.';

            } else {
                // Handle other database exceptions if needed
                $errorMessage = 'Database error during import.';

            }

            return redirect()->back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Handle other generic exceptions
            $errorMessage = $this->getErrorMessage($e);

            return redirect()->back()->with('error', $errorMessage);
        }
    }


    private function getErrorMessage(\Exception $e): string
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $errorMessage = implode($e->validator->errors()->all());
        } elseif ($e instanceof \Illuminate\Database\QueryException) {
            $errorMessage = 'Database error during import.';
        } else {
            $errorMessage = 'Error during import.';
        }

        return $errorMessage;
    }

    public function exportCasuals()
    {
        $data = Casual::all();

        if(count($data) == 0) {
            $data = collect();
        }

        return Excel::download(new CasualsTemplateExport($data), 'casuals.xlsx');
    }


}
