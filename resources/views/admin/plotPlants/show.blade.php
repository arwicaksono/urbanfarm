@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.plotPlant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plot-plants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plotPlant.fields.id') }}
                        </th>
                        <td>
                            {{ $plotPlant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotPlant.fields.name') }}
                        </th>
                        <td>
                            {{ $plotPlant->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotPlant.fields.note') }}
                        </th>
                        <td>
                            {{ $plotPlant->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plot-plants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection