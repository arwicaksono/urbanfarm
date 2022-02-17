@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.attCategoryComp.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.att-category-comps.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.attCategoryComp.fields.id') }}
                        </th>
                        <td>
                            {{ $attCategoryComp->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attCategoryComp.fields.name') }}
                        </th>
                        <td>
                            {{ $attCategoryComp->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.att-category-comps.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection