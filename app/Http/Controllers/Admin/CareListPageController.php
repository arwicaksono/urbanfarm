<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCareListPageRequest;
use App\Http\Requests\StoreCareListPageRequest;
use App\Http\Requests\UpdateCareListPageRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CareListPageController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('care_list_page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.careListPages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('care_list_page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.careListPages.create');
    }

    public function store(StoreCareListPageRequest $request)
    {
        $careListPage = CareListPage::create($request->all());

        return redirect()->route('admin.care-list-pages.index');
    }

    public function edit(CareListPage $careListPage)
    {
        abort_if(Gate::denies('care_list_page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.careListPages.edit', compact('careListPage'));
    }

    public function update(UpdateCareListPageRequest $request, CareListPage $careListPage)
    {
        $careListPage->update($request->all());

        return redirect()->route('admin.care-list-pages.index');
    }

    public function show(CareListPage $careListPage)
    {
        abort_if(Gate::denies('care_list_page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.careListPages.show', compact('careListPage'));
    }

    public function destroy(CareListPage $careListPage)
    {
        abort_if(Gate::denies('care_list_page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $careListPage->delete();

        return back();
    }

    public function massDestroy(MassDestroyCareListPageRequest $request)
    {
        CareListPage::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
