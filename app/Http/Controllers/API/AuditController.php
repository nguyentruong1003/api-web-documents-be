<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditResource;
use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    /**
     * Get audit
     *
     * @group Audit management
     * @authenticated
     */
    public function index()
    {
        return AuditResource::collection(Audit::query()->paginate(15));
    }
}
