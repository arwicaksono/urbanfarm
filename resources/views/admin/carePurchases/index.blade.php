@extends('layouts.admin')
@section('content')
@can('care_purchase_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.care-purchases.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.carePurchase.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CarePurchase', 'route' => 'admin.care-purchases.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.carePurchase.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CarePurchase">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.time_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.time_end') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.problem_purchase') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.action') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.is_done') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.carePurchase.fields.person_in_charge') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('care_purchase_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.care-purchases.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.care-purchases.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time_start', name: 'time_start' },
{ data: 'time_end', name: 'time_end' },
{ data: 'problem_purchase_code', name: 'problem_purchase.code' },
{ data: 'action', name: 'action' },
{ data: 'status_name', name: 'status.name' },
{ data: 'tag', name: 'tags.name' },
{ data: 'is_done', name: 'is_done' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'person_in_charge', name: 'person_in_charges.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-CarePurchase').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection