<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostReportResource;
use App\Models\PostReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    /**
     * Get or search post reports
     *
     * @group Post report management
     * @authenticated
     */
    public function index(Request $request)
    {
        $query = PostReport::query();
        if (isset($request->resolve)) {
            $query->where('resolve', 'like', $request->resolve);
        }
        return PostReportResource::collection($query->paginate(15));
    }

    /**
     * Show post report
     *
     * @group Post report management
     * @authenticated
     */
    public function show(PostReport $report)
    {
        return new PostReportResource($report);
    }

    /**
     * Delete post report
     *
     * @group Post report management
     * @authenticated
     */
    public function delete(PostReport $report)
    {
        $report->delete();
        return response()->json([
            'message' => __('view.notification.success.delete')
        ]);
    }

    /**
     * Solve/Unsolve post report
     * @group Post report management
     * @authenticated
     */
    public function solve(PostReport $report)
    {
        if ($report->resolve == 1) {
            $report->resolve = 2;
            return response()->json([
                'message' => 'Đã xử lý'
            ]);
        } else {
            $report->resolve = 1;
            return response()->json([
                'message' => 'Chưa xử lý'
            ]);
        }
    }
}
