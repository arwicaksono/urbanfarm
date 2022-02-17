@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cashflowExpenseCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-expense-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpenseCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $cashflowExpenseCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpenseCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $cashflowExpenseCategory->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-expense-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection