@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.plotCode.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plot-codes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plotCode.fields.id') }}
                        </th>
                        <td>
                            {{ $plotCode->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotCode.fields.prefix') }}
                        </th>
                        <td>
                            {{ $plotCode->prefix }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotCode.fields.plant') }}
                        </th>
                        <td>
                            {{ $plotCode->plant }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plotCode.fields.note') }}
                        </th>
                        <td>
                            {{ $plotCode->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.plot-codes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection