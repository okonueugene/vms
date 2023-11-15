@extends('admin.layouts.master')

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>Casuals</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="search">
                        <form action="{{ route('admin.casuals.search') }}" method="GET" id="search">
                            <div class="input-group mb-3 w-50" id="search">
                                <input type="text" class="form-control" name="search" placeholder="Search Casuals"
                                    value="{{ $search }}">
                                <button class="btn btn-primary" type="submit">Search</button>
                                @if ($search)
                                    <button class="btn btn-danger" type="button" id="reset">Reset</button>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        @can('casuals_create')
                            <div class="card-header">
                                <a href="{{ route('admin.casuals.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                        class="fas fa-plus"></i>Add Casual</a>

                                <div style="position: relative;
                                left: 55vw; overflow:hidden;">
                                    <a href="javascript:void(0)" id="importCasual"
                                        class="btn btn-icon icon-left btn-success float-end" data-toggle="modal"
                                        data-target="#importCasualModal"><i class="fas fa-plus float-end"></i>Import
                                        Casual</a>

                                    <a href="{{ route('admin.casuals.export') }}"
                                        class="btn btn-icon icon-left btn-warning float-end"><i
                                            class="fas fa-plus float-end"></i>Export
                                        Casual</a>
                                </div>
                                <!-- Search input field -->

                            </div>
                        @endcan
                        <div id="calendar"></div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Mobile</th>
                                            <th>Designation</th>
                                            <th>Date of Joining</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($casuals->count() == 0)
                                            <tr>
                                                <td colspan="8" class="text-center">No Casuals Found</td>
                                            </tr>
                                        @endif
                                        @foreach ($casuals as $casual)
                                            <tr>
                                                <td>{{ $casual->id }}</td>
                                                <td>{{ $casual->first_name }}</td>
                                                <td>{{ $casual->last_name }}</td>
                                                <td>{{ $casual->phone }}</td>
                                                <td>{{ $casual->designation }}</td>
                                                <td>{{ $casual->date_of_joining }}</td>
                                                <td>
                                                    @if ($casual->status == 'active')
                                                        <div class="badge badge-success">Active</div>
                                                    @else
                                                        <div class="badge badge-danger">Inactive</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @can('casuals_edit')
                                                        <a href="{{ route('admin.casuals.edit', $casual->id) }}"
                                                            class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-icon btn-info"
                                                            onclick="viewCasual({{ $casual->casualAttendance }})">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endcan
                                                    @can('casuals_delete')
                                                        <a href="javascript:void(0)" class="btn btn-icon btn-danger"
                                                            onclick="deleteCasual({{ $casual->id }})">
                                                            <i class="fas fa-trash"></i>
                                                            <form id="delete-form-{{ $casual->id }}"
                                                                action="{{ route('admin.casuals.destroy', $casual->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination w-50 mx-auto">

                                </div>
                                <ul class="pagination justify-content-center" style="margin:10px 10px">
                                    {{ $casuals->links() }}
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

{{-- #importCasualModal --}}
<div class="modal fade" id="importCasualModal" tabindex="-1" role="dialog" aria-labelledby="exampleImportCasualModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleimportCasualModal">Import Casuals</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.casuals.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".xlsx, .xls">
                    <button type="submit">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>



{{-- lets receive error message from controller --}}
<script>
    @if (Session::has('error'))
        iziToast.error({
            title: 'Error',
            message: '{{ Session::get('error') }}',
            position: 'topRight'
        });
    @endif
</script>
<script>
    function deleteCasual(casualId) {
        if (confirm('Are you sure you want to delete this casual?')) {
            document.getElementById('delete-form-' + casualId).submit();
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#reset').click(function() {
            window.location.href = "{{ route('admin.casuals.index') }}";
        });
    });
</script>

<script>
    // casual example object
    //     {
    //     "id": 1,
    //     "casual_id": 198,
    //     "date": "2023-11-15",
    //     "clock_in": "12:21:39",
    //     "clock_out": "14:18:00",
    //     "created_at": "2023-11-15T09:21:39.000000Z",
    //     "updated_at": "2023-11-15T11:18:00.000000Z"
    // }

    function viewCasual(casual) {
        console.log(casual)
        let html = '';

        casual.forEach(element => {
            html += `
            <tr>
                <td>${element.date}</td>
                <td>${element.clock_in}</td>
                <td>${element.clock_out}</td>
            </tr>
            `
        });

        $('#casualAttendance').html(html);

        $('#viewCasualModal').modal('show');


    }
</script>



@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/casual/index.js') }}"></script>
@endsection
