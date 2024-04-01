<?php

namespace App\Http\Controllers\Admin;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\StatusStore;
use App\Http\Controllers\Controller;

/**
 * @group ManagerStatus
 */
class ManagerStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * index.
     */
    public function index()
    {
    }

    /**
     * create.
     */
    public function create()
    {
    }

    /**
     * store.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(StatusStore $request)
    {
    }

    /**
     * show.
     *
     * @param int $id
     */
    public function show(Status $id)
    {
    }

    /**
     * edit.
     *
     * @param int $id
     */
    public function edit(Status $id)
    {
    }

    /**
     * update.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     */
    public function update(Status $id, StatusStore $request)
    {
        $this->hydrateCheckboxs(Status::class, $request);
    }

    /**
     * delete.
     *
     * @param int $id
     */
    public function destroy(Status $id)
    {
    }
}
