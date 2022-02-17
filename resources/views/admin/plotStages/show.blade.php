@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.plotStage.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plot-stages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plotStage.fields.id') }}
                        </th>
                        <td>
                            {{ $plotStage->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotStage.fields.name') }}
                        </th>
                        <td>
                            {{ $plotStage->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotStage.fields.period') }}
                        </th>
                        <td>
                            {{ $plotStage->period }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plot-stages.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection