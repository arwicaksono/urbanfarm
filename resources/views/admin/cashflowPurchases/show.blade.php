@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cashflowPurchase.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.id') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.code') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.number') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.date') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.time') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.name') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.quantity') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.unit_price') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->unit_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.discount') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.total_price') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->total_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.is_expense') }}
                        </th>
                        <td>
                            {{ App\Models\CashflowPurchase::IS_EXPENSE_SELECT[$cashflowPurchase->is_expense] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\CashflowPurchase::IS_PROBLEM_SELECT[$cashflowPurchase->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.is_priority') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->is_priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.status') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.tag') }}
                        </th>
                        <td>
                            @foreach($cashflowPurchase->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.image') }}
                        </th>
                        <td>
                            @foreach($cashflowPurchase->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.note') }}
                        </th>
                        <td>
                            {{ $cashflowPurchase->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowPurchase.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($cashflowPurchase->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection