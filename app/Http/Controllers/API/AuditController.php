<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditResource;
use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    //
    public function index()
    {
        return AuditResource::collection(Audit::query()->paginate());
    }
}
