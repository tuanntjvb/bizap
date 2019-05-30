<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Request;

trait ResourceController
{
    use ResourceHelper;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewList', $this->getResourceModel());

        $paginatorData = [];
        $perPage = (int)$request->input('per_page', '');
        $perPage = (is_numeric($perPage) && $perPage > 0 && $perPage <= 100) ? $perPage : 15;
        if ($perPage != 15) {
            $paginatorData['per_page'] = $perPage;
        }
        $search = trim($request->input('search', ''));
        if (!empty($search)) {
            $paginatorData['search'] = $search;
        }
        $records = $this->getSearchRecords($request, $perPage, $search);
        $records->appends($paginatorData);

        return view($this->getResourceIndexPath(), $this->filterSearchViewData($request, [
            'records' => $records,
            'search' => $search,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
            'perPage' => $perPage,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', $this->getResourceModel());

        $class = $this->getResourceModel();
        return view($this->getResourceCreatePath(), $this->filterCreateViewData([
            'record' => new $class(),
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', $this->getResourceModel());

        $this->resourceValidate($request, 'store');

        $valuesToSave = $this->getValuesToSave($request);
        $request->merge($valuesToSave);

        if ($record = $this->getResourceModel()::create($this->alterValuesToSave($request, $valuesToSave))) {
            flash()->success(__('messages.inserted'));

            return $this->getRedirectAfterSave($record);
        } else {
            flash()->info(__('messages.not_inserted'));
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(route($this->getResourceRoutesAlias() . '.edit', $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $record = $this->getResourceModel()::findOrFail($id);

        $this->authorize('update', $record);

        return view($this->getResourceEditPath(), $this->filterEditViewData($record, [
            'record' => $record,
            'resourceAlias' => $this->getResourceAlias(),
            'resourceRoutesAlias' => $this->getResourceRoutesAlias(),
            'resourceTitle' => $this->getResourceTitle(),
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $record = $this->getResourceModel()::findOrFail($id);

        $this->authorize('update', $record);

        $this->resourceValidate($request, 'update', $record);

        $valuesToSave = $this->getValuesToSave($request, $record);

        $request->merge($valuesToSave);

        if ($record->update($this->alterValuesToSave($request, $valuesToSave))) {
            flash()->success(__('messages.updated'));

            return $this->getRedirectAfterSave($record);
        } else {
            flash()->info(__('messages.not_updated'));
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $record = $this->getResourceModel()::findOrFail($id);

        $this->authorize('delete', $record);

        if (!$this->checkDestroy($record)) {
            return redirect(route($this->getResourceRoutesAlias() . '.index'));
        }

        if ($record->delete()) {
            flash()->success(__('messages.deleted'));
        } else {
            flash()->info(__('messages.not_deleted'));
        }

        return $this->redirectBackTo(route($this->getResourceRoutesAlias() . '.index'));
    }

    public function getResourceIndexPath()
    {
        return '_resources.index';
    }

    public function getResourceCreatePath()
    {
        return '_resources.create';
    }

    public function getResourceEditPath()
    {
        return '_resources.edit';
    }
}
