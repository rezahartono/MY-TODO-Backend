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
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Task Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" placeholder="Title" disabled
                                        value="{{ $task->title }}">
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="number">Number</label>
                                            <input type="text" class="form-control" id="number" placeholder="Number"
                                                disabled value="{{ $task->number }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="percentage">Percentage</label>
                                            <input type="text" class="form-control" id="percentage"
                                                placeholder="Percentage" disabled value="{{ $percentage }} %">
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-primary">
                                    <div class="card-header">
                                        Sub Tasks
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-bordered sub_tasks_datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Description</th>
                                                        <th width="100px" class="text-center">State</th>
                                                        <th width="100px" class="text-center">Start At</th>
                                                        <th width="100px" class="text-center">End At</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <a href="{{ url()->previous() }}" class="btn btn-warning text-white"><i
                                        class="fas fa-arrow-left"></i>
                                    Back</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.12.1/dataRender/datetime.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script> --}}
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    <script type="text/javascript">
        $(function() {
            $.fn.dataTable.render.moment = function(from, to, locale) {
                // Argument shifting
                if (arguments.length === 1) {
                    locale = 'en';
                    to = from;
                    from = 'YYYY-MM-DD';
                } else if (arguments.length === 2) {
                    locale = 'en';
                }

                return function(d, type, row) {
                    if (!d) {
                        return type === 'sort' || type === 'type' ? 0 : d;
                    }

                    var m = window.moment(d, from, locale, true);

                    // Order and type get a number value from Moment, everything else
                    // sees the rendered value
                    return m.format(type === 'sort' || type === 'type' ? 'x' : to);
                };
            };

            var table = $('.sub_tasks_datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/tasks/{!! Request::segment(2) !!}",
                columns: [{
                        name: 'description',
                        data: 'description'
                    },
                    {
                        name: 'state',
                        data: 'state.name'
                    },
                    {
                        name: 'start_at',
                        data: 'start_at',
                        render: function(data) {
                            return moment(data, 'YYYY-MM-DD HH:mm:ss').format(
                                'MM/DD/YYYY HH:mm')
                        }
                    },
                    {
                        name: 'end_at',
                        data: 'end_at',
                        render: function(data) {
                            if (data != null) {
                                return moment(data, 'YYYY-MM-DD HH:mm:ss').format(
                                    'MM/DD/YYYY HH:mm')
                            } else {
                                return data
                            }
                        }
                    },
                ],
                /// sort at column three
                order: [
                    [0, 'asc']
                ],
            });
        });
    </script>
@endpush
