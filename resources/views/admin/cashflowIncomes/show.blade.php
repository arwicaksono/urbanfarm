@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cashflowIncome.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-incomes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncome.fields.id') }}
                        </th>
                        <td>
                            {{ $cashflowIncome->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncome.fields.amount') }}
                        </th>
                        <td>
                            {{ $cashflowIncome->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncome.fields.date') }}
                        </th>
                        <td>
                            {{ $cashflowIncome->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncome.fields.time') }}
                        </th>
                        <td>
                            {{ $cashflowIncome->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncome.fields.category') }}
                        </th>
                        <td>
                            {{ $cashflowIncome->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncome.fields.tag') }}
                        </th>
                        <td>
                            @foreach($cashflowIncome->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncome.fields.image') }}
                        </th>
                        <td>
                            @foreach($cashflowIncome->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowIncome.fields.note') }}
                        </th>
                        <td>
                            {{ $cashflowIncome->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-incomes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection