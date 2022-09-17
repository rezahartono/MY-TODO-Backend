@extends('template.main')

@push('extend-meta')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@section('main-content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#create-state-modal"><i class="fas fa-plus"></i> Create</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered states_datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('components.modals.create_state_modal')
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script> --}}
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <script type="text/javascript">
        $(function() {
            var table = $('.states_datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/master-data/states",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'no'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                "columnDefs": [{
                    "width": "5%",
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                /// sort at column three
                "order": [
                    [1, 'asc']
                ],
            });
        });
    </script>
@endpush
