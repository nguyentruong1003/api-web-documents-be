<?php

namespace App\Http\Controllers\API;

use App\Editors\MasterDataEditor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\MasterDataRequest;
use App\Http\Resources\MasterDataResource;
use App\Models\MasterData;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
        /**
     * Get or search masterdatas
     *
     * @group User management
     * @authenticated
     * @queryParam name string Search by name
     */
    public function index()
    {
        return MasterDataResource::collection(MasterData::query()->paginate());
    }

    /**
     * Create masterdata
     *
     * @group User management
     * @authenticated
     */
    public function create(MasterDataRequest $request)
    {
        $masterdata = MasterDataEditor::open(new MasterData())->withDataFromRequest($request)->save();
        return (new MasterDataResource($masterdata))->withMessage(__('view.notification.success.create'));
    }

    /**
     * Edit masterdata
     *
     * @group User management
     * @authenticated
     */
    public function edit(MasterDataRequest $request, MasterData $masterdata)
    {
        $masterdata = MasterDataEditor::open($masterdata)->withDataFromRequest($request)->save();
        return (new MasterDataResource($masterdata))->withMessage(__('view.notification.success.edit'));
    }

    /**
     * Show masterdata
     *
     * @group User management
     * @authenticated
     */
    public function show(MasterData $masterdata)
    {
        return new MasterDataResource($masterdata);
    }

    /**
     * Delete masterdata
     *
     * @group User management
     * @authenticated
     */
    public function delete(MasterData $masterdata)
    {
        $masterdata->delete();
        return response()->json([
            'message' => __('view.notification.success.delete')
        ]);
    }
}
