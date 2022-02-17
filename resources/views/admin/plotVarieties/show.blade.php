@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.plotVariety.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plot-varieties.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plotVariety.fields.id') }}
                        </th>
                        <td>
                            {{ $plotVariety->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotVariety.fields.name') }}
                        </th>
                        <td>
                            {{ $plotVariety->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotVariety.fields.brand') }}
                        </th>
                        <td>
                            {{ $plotVariety->brand->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotVariety.fields.note') }}
                        </th>
                        <td>
                            {{ $plotVariety->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plot-varieties.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection