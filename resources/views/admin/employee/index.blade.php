@extends('admin.layouts.master')

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('employee.employees') }}</h1>
            {{ Breadcrumbs::render('employees') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        @can('employees_create')
                            <div class="card-header">
                                <a href="{{ route('admin.employees.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                        class="fas fa-plus"></i> {{ __('employee.add_employee') }}</a>
                                <div style="position: absolute;left: 80%;">
                                    <a href="javascript:void(0)" id="importCasual"
                                        class="btn btn-icon icon-left btn-success float-end" data-toggle="modal"
                                        data-target="#exportCasualModal"><i class="fas fa-plus float-end"></i>Import
                                        Enployees</a>

                                    <a href="javascript:void(0)" id="exportEmployees" onclick="exportEmployees()"
                                        class="btn btn-icon icon-left btn-success float-end">
                                        <i class="fas fa-plus float-end"></i>Export Employees
                                    </a>


                                </div>
                            </div>
                        @endcan

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable"
                                    data-url="{{ route('admin.employees.get-employees') }}"
                                    data-status="{{ \App\Enums\Status::ACTIVE }}"
                                    data-hidecolumn="{{ auth()->user()->can('employees_show') ||auth()->user()->can('employees_edit') ||auth()->user()->can('employees_delete') }}">
                                    <thead>
                                        <tr>
                                            <th>{{ __('levels.id') }}</th>
                                            <th>{{ __('levels.image') }}</th>
                                            <th>{{ __('levels.name') }}</th>
                                            <th>{{ __('levels.email') }}</th>
                                            <th>{{ __('levels.phone') }}</th>
                                            <th>{{ __('employee.joining_date') }}</th>
                                            <th>{{ __('levels.status') }}</th>
                                            <th>{{ __('levels.actions') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
{{-- #exportCasualModal --}}
<div class="modal fade" id="exportCasualModal" tabindex="-1" role="dialog" aria-labelledby="exampleexportCasualModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleexportCasualModal">Import Casuals</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.employees.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xlsx, .xls">
                    <button type="submit">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>


@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/employee/index.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.0/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/file-saver"></script>


    <script>
        let employees = @json($employees);
        console.log(employees);

        function exportEmployees() {
            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet([
                ["First Name", "Last Name", "Phone", "Email", "Department", "Designation", "Gender",
                    "Date of Joining", "Status",
                    "Official Identification Number", "About"
                ],
                ...employees.map(employee => [
                    employee.first_name,
                    employee.last_name,
                    employee.phone,
                    employee.email,
                    employee.department,
                    employee.designation,
                    employee.gender == 5 ? "Male" : "Female",
                    employee.date_of_joining,
                    employee.status == 5 ? "Active" : "Inactive",
                    employee.official_identification_number,
                    employee.about
                ])
            ]);

            XLSX.utils.book_append_sheet(workbook, worksheet, "Employees");

            const blob = new Blob([s2ab(XLSX.write(workbook, {
                type: "binary",
                bookType: "xlsx"
            }))], {
                type: "application/octet-stream"
            });

            saveAs(blob, "employees.xlsx");
        }

        function s2ab(s) {
            const buf = new ArrayBuffer(s.length);
            const view = new Uint8Array(buf);
            for (let i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;
        }
    </script>
    <script>
        @if (Session::has('error'))
            iziToast.error({
                title: 'Error',
                message: '{{ Session::get('error') }}',
                position: 'topRight'
            });
        @endif
    </script>
@endsection
