@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cashflowExpense.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-expenses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpense.fields.id') }}
                        </th>
                        <td>
                            {{ $cashflowExpense->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpense.fields.amount') }}
                        </th>
                        <td>
                            {{ $cashflowExpense->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpense.fields.date') }}
                        </th>
                        <td>
                            {{ $cashflowExpense->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpense.fields.time') }}
                        </th>
                        <td>
                            {{ $cashflowExpense->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpense.fields.category') }}
                        </th>
                        <td>
                            {{ $cashflowExpense->category->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpense.fields.tag') }}
                        </th>
                        <td>
                            @foreach($cashflowExpense->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpense.fields.image') }}
                        </th>
                        <td>
                            @foreach($cashflowExpense->image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cashflowExpense.fields.note') }}
                        </th>
                        <td>
                            {{ $cashflowExpense->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cashflow-expenses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection