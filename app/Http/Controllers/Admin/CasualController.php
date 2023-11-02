<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CasualController extends Controller
{
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
        $this->data['casuals'] = [];
        return view('admin.casual.index', $this->data);
    }

    public function create()
    {
        return view('admin.casual.create', $this->data);
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
        $this->data['casual'] = Casual::findOrFail($id);
        return view('admin.casual.edit', $this->data);
    }




}
