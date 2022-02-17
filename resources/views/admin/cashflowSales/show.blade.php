@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cashflowSale.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-sales.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.id') }}
                        </th>
                        <td>
                            {{ $cashflowSale->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.code') }}
                        </th>
                        <td>
                            {{ $cashflowSale->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.number') }}
                        </th>
                        <td>
                            {{ $cashflowSale->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.date') }}
                        </th>
                        <td>
                            {{ $cashflowSale->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.time') }}
                        </th>
                        <td>
                            {{ $cashflowSale->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.packing_code') }}
                        </th>
                        <td>
                            {{ $cashflowSale->packing_code->code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.sales_qty') }}
                        </th>
                        <td>
                            {{ $cashflowSale->sales_qty }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.unit') }}
                        </th>
                        <td>
                            {{ $cashflowSale->unit->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.unit_price') }}
                        </th>
                        <td>
                            {{ $cashflowSale->unit_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.discount') }}
                        </th>
                        <td>
                            {{ $cashflowSale->discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.total_price') }}
                        </th>
                        <td>
                            {{ $cashflowSale->total_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.tag') }}
                        </th>
                        <td>
                            @foreach($cashflowSale->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.is_income') }}
                        </th>
                        <td>
                            {{ App\Models\CashflowSale::IS_INCOME_SELECT[$cashflowSale->is_income] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.is_active') }}
                        </th>
                        <td>
                            {{ App\Models\CashflowSale::IS_ACTIVE_SELECT[$cashflowSale->is_active] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.is_problem') }}
                        </th>
                        <td>
                            {{ App\Models\CashflowSale::IS_PROBLEM_SELECT[$cashflowSale->is_problem] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.is_priority') }}
                        </th>
                        <td>
                            {{ $cashflowSale->is_priority->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.image') }}
                        </th>
                        <td>
                            @foreach($cashflowSale->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.note') }}
                        </th>
                        <td>
                            {{ $cashflowSale->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowSale.fields.person_in_charge') }}
                        </th>
                        <td>
                            @foreach($cashflowSale->person_in_charges as $key => $person_in_charge)
                                <span class="label label-info">{{ $person_in_charge->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-sales.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection