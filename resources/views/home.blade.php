@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="{{ $settings1['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings1['total_number']) }}</div>
                                    <div>{{ $settings1['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings2['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings2['total_number']) }}</div>
                                    <div>{{ $settings2['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings3['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings3['total_number']) }}</div>
                                    <div>{{ $settings3['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings4['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings4['total_number']) }}</div>
                                    <div>{{ $settings4['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings5['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings5['total_number']) }}</div>
                                    <div>{{ $settings5['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings6['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings6['total_number']) }}</div>
                                    <div>{{ $settings6['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings7['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings7['total_number']) }}</div>
                                    <div>{{ $settings7['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings8['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings8['total_number']) }}</div>
                                    <div>{{ $settings8['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings9['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings9['total_number']) }}</div>
                                    <div>{{ $settings9['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings10['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings10['total_number']) }}</div>
                                    <div>{{ $settings10['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings11['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings11['total_number']) }}</div>
                                    <div>{{ $settings11['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings12['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings12['total_number']) }}</div>
                                    <div>{{ $settings12['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings13['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings13['total_number']) }}</div>
                                    <div>{{ $settings13['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings14['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings14['total_number']) }}</div>
                                    <div>{{ $settings14['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $settings15['column_class'] }}">
                            <div class="card text-white bg-primary">
                                <div class="card-body pb-0">
                                    <div class="text-value">{{ number_format($settings15['total_number']) }}</div>
                                    <div>{{ $settings15['chart_title'] }}</div>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <div class="{{ $chart16->options['column_class'] }}">
                            <h3>{!! $chart16->options['chart_title'] !!}</h3>
                            {!! $chart16->renderHtml() !!}
                        </div>
                        <div class="{{ $chart17->options['column_class'] }}">
                            <h3>{!! $chart17->options['chart_title'] !!}</h3>
                            {!! $chart17->renderHtml() !!}
                        </div>
                        <div class="{{ $chart18->options['column_class'] }}">
                            <h3>{!! $chart18->options['chart_title'] !!}</h3>
                            {!! $chart18->renderHtml() !!}
                        </div>
                        <div class="{{ $chart19->options['column_class'] }}">
                            <h3>{!! $chart19->options['chart_title'] !!}</h3>
                            {!! $chart19->renderHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>{!! $chart16->renderJs() !!}{!! $chart17->renderJs() !!}{!! $chart18->renderJs() !!}{!! $chart19->renderJs() !!}
@endsection