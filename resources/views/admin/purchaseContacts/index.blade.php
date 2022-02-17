@extends('layouts.admin')
@section('content')
@can('purchase_contact_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.purchase-contacts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.purchaseContact.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'PurchaseContact', 'route' => 'admin.purchase-contacts.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchaseContact.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-PurchaseContact">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.address') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.linkedin') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.twitter') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.facebook') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.instagram') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.purchaseContact.fields.note') }}
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
@can('purchase_contact_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.purchase-contacts.massDestroy') }}",
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
    ajax: "{{ route('admin.purchase-contacts.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'phone', name: 'phone' },
{ data: 'address', name: 'address' },
{ data: 'email', name: 'email' },
{ data: 'linkedin', name: 'linkedin' },
{ data: 'twitter', name: 'twitter' },
{ data: 'facebook', name: 'facebook' },
{ data: 'instagram', name: 'instagram' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'note', name: 'note' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-PurchaseContact').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection