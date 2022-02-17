@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.salesDelivery.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-deliveries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.salesDelivery.fields.id') }}
                        </th>
                        <td>
                            {{ $salesDelivery->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesDelivery.fields.name') }}
                        </th>
                        <td>
                            {{ $salesDelivery->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesDelivery.fields.address') }}
                        </th>
                        <td>
                            {{ $salesDelivery->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesDelivery.fields.contact') }}
                        </th>
                        <td>
                            {{ $salesDelivery->contact }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesDelivery.fields.phone') }}
                        </th>
                        <td>
                            {{ $salesDelivery->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesDelivery.fields.note') }}
                        </th>
                        <td>
                            {{ $salesDelivery->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-deliveries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection