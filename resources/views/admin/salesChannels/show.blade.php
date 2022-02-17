@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.salesChannel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-channels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.salesChannel.fields.id') }}
                        </th>
                        <td>
                            {{ $salesChannel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesChannel.fields.name') }}
                        </th>
                        <td>
                            {{ $salesChannel->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesChannel.fields.sales_type') }}
                        </th>
                        <td>
                            {{ App\Models\SalesChannel::SALES_TYPE_SELECT[$salesChannel->sales_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesChannel.fields.note') }}
                        </th>
                        <td>
                            {{ $salesChannel->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-channels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection