@extends('template.main')

@section('main-content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-calendar-day"></i></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Daily Task</span>
                            <span class="info-box-number">{{ $count['daily_tasks'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-calendar-week"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Weekly Task</span>
                            <span class="info-box-number">{{ $count['weekly_tasks'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tasks"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Task</span>
                            <span class="info-box-number">{{ $count['total_tasks'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Users</span>
                            <span class="info-box-number">{{ $count['total_users'] }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Report
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane" id="revenue-chart" style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane active" id="sales-chart"
                                    style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">5 Today Task</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Number</th>
                                        <th>Title</th>
                                        <th>Progress</th>
                                        <th style="width: 40px;text-align:center;">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if ($tasks) --}}
                                    @foreach ($tasks as $task)
                                        @php
                                            $percent = round(($task->subTasks->whereIn('state_id', [$allowedState[0]->id, $allowedState[1]->id])->count() * 100) / $task->subTasks->count());
                                        @endphp
                                        <tr>
                                            <td>{{ $task->number }}</td>
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar
                                                    @if ($percent <= 25) progress-bar-danger
                                                    @elseif ($percent > 25 && $percent <= 75)
                                                    progress-bar-warning
                                                    @elseif ($percent > 750 && $percent <= 100)
                                                    progress-bar-success @endif"
                                                        style="width: {{ $percent }}%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span
                                                    class="badge @if ($percent <= 25) bg-danger
                                                    @elseif ($percent > 25 && $percent <= 75)
                                                    bg-warning
                                                    @elseif ($percent > 750 && $percent <= 100)
                                                    bg-success @endif">{{ $percent }}%</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- @else
                                        <tr>
                                            <td>1.</td>
                                            <td>Update software</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-danger">55%</span></td>
                                        </tr>
                                    @endif --}}
                                </tbody>
                            </table>
                        </div>
                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-6 connectedSortable">
                    <!-- Calendar -->
                    <div class="card bg-gradient-white">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="far fa-calendar-alt"></i>
                                Calendar
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pt-0">
                            <!--The calendar -->
                            <div id="calendar" style="width: 100%;"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        /*
         * Author: Abdullah A Almsaeed
         * Date: 4 Jan 2014
         * Description:
         *      This is a demo file used only for the main dashboard (index.html)
         **/

        /* global moment:false, Chart:false, Sparkline:false */

        $(function() {
            'use strict'

            // Make the dashboard widgets sortable Using jquery UI
            $('.connectedSortable').sortable({
                placeholder: 'sort-highlight',
                connectWith: '.connectedSortable',
                handle: '.card-header, .nav-tabs',
                forcePlaceholderSize: true,
                zIndex: 999999
            })
            $('.connectedSortable .card-header').css('cursor', 'move')

            // bootstrap WYSIHTML5 - text editor
            $('.textarea').summernote()

            $('.daterange').daterangepicker({
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function(start, end) {
                // eslint-disable-next-line no-alert
                alert('You chose: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            })

            /* jQueryKnob */
            $('.knob').knob()

            // The Calender
            $('#calendar').datetimepicker({
                format: 'L',
                inline: true
            })

            // SLIMSCROLL FOR CHAT WIDGET
            $('#chat-box').overlayScrollbars({
                height: '250px'
            })

            // Donut Chart
            var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
            var chartData = {!! json_encode($count) !!};
            // console.log(chartData);
            var pieData = {
                labels: [
                    'Total Task',
                    'Daily Tasks',
                    'Weekly Tasks',
                ],
                datasets: [{
                    data: [chartData['total_tasks'], chartData['daily_tasks'], chartData[
                        'weekly_tasks']],
                    backgroundColor: ['#28a745', '#17a2b8', '#dc3545']
                }]
            }
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true
            }
            // Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            // eslint-disable-next-line no-unused-vars
            var pieChart = new Chart(pieChartCanvas, { // lgtm[js/unused-local-variable]
                type: 'doughnut',
                data: pieData,
                options: pieOptions
            })
        })
    </script>
@endpush
