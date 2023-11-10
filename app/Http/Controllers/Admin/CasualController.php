<?php

namespace App\Http\Controllers\Admin;

use DB;
use Carbon\Carbon;
use App\Models\Casual;
use App\Models\Department;
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

    public function index()
    {

        //pagination
        $casuals = Casual::orderBy('id', 'DESC')->paginate(10);

        return view('admin.casual.index', compact('casuals'));
    }

    public function create()
    {
        return view('admin.casual.create', $this->data);
    }

    public function show($id)
    {
        $this->data['casual'] = [];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:casuals,name',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        $data['status'] = 1;

        $casual = Casual::create($data);

        if ($casual) {
            return redirect()->route('admin.casuals.index')->with('success', 'Casual created successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
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

        $data = $request->all();
        $data['updated_by'] = auth()->user()->id;

        $updateResult = $casual->update($data);

        if ($updateResult) {
            return redirect()->route('admin.casuals.index')->with('success', 'Casual updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update the casual');
        }
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


        $file = $request->file('file');


        Excel::import(new CasualsImport(), $file);

        return redirect()->route('admin.casuals.index')->with('success', 'Casuals uploaded successfully');
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
