@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.salesLabel.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-labels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.salesLabel.fields.id') }}
                        </th>
                        <td>
                            {{ $salesLabel->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesLabel.fields.name') }}
                        </th>
                        <td>
                            {{ $salesLabel->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesLabel.fields.quantity') }}
                        </th>
                        <td>
                            {{ $salesLabel->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesLabel.fields.price') }}
                        </th>
                        <td>
                            {{ $salesLabel->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesLabel.fields.unit') }}
                        </th>
                        <td>
                            {{ $salesLabel->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesLabel.fields.company') }}
                        </th>
                        <td>
                            @foreach($salesLabel->companies as $key => $company)
                                <span class="label label-info">{{ $company->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.salesLabel.fields.note') }}
                        </th>
                        <td>
                            {{ $salesLabel->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sales-labels.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection