@extends('layouts.admin')
@section('content')
@can('care_distribution_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.care-distributions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.careDistribution.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'CareDistribution', 'route' => 'admin.care-distributions.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.careDistribution.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CareDistribution">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.code') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.number') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.time_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.time_end') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.problem_dist') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.action') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.tag') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.is_done') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.note') }}
                    </th>
                    <th>
                        {{ trans('cruds.careDistribution.fields.person_in_charge') }}
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
@can('care_distribution_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.care-distributions.massDestroy') }}",
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
    ajax: "{{ route('admin.care-distributions.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'code', name: 'code' },
{ data: 'number', name: 'number' },
{ data: 'date', name: 'date' },
{ data: 'time_start', name: 'time_start' },
{ data: 'time_end', name: 'time_end' },
{ data: 'problem_dist_code', name: 'problem_dist.code' },
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
  let table = $('.datatable-CareDistribution').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection