@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cashflowIncomeCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-income-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncomeCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $cashflowIncomeCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncomeCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $cashflowIncomeCategory->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-income-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection