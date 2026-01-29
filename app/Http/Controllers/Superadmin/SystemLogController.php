<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SystemLog::query();

        // Search
        if ($request->search) {
            $query->where('message', 'like', "%{$request->search}%");
        }

        // Filter Level
        if ($request->level && $request->level != 'all') {
            $query->where('level', $request->level);
        }

        // Filter Status
        if ($request->status == 'resolved') {
            $query->where('is_resolved', true);
        }

        if ($request->status == 'unresolved') {
            $query->where('is_resolved', false);
        }

        $logs = $query->latest()->paginate(10);

        $stats = [
            'total_logs' => SystemLog::count(),
            'critical_errors' => SystemLog::where('level', 'error')->count(),
            'warnings' => SystemLog::where('level', 'warning')->count(),
            'info_logs' => SystemLog::where('level', 'info')->count(),
        ];

        return view('superadmin.logs.index', compact('logs', 'stats'));
    }

    // View Detail Page
    public function show($id)
    {
        $log = SystemLog::findOrFail($id);

        return view('superadmin.logs.show', compact('log'));
    }

    // Delete Single Log
    public function destroy($id)
    {
        SystemLog::findOrFail($id)->delete();

        return back()->with('success', 'Log deleted successfully');
    }

    // Mass Delete
    public function deleteAll()
    {
        SystemLog::truncate();

        return back()->with('success', 'All logs deleted successfully');
    }

    //Export


    public function export(Request $request)
    {
        // Optional: filter logs by search/level/status same as index
        $logs = SystemLog::query();

        if ($request->search) {
            $logs->where('message', 'like', "%{$request->search}%");
        }

        if ($request->level && $request->level != 'all') {
            $logs->where('level', $request->level);
        }

        if ($request->status == 'resolved') {
            $logs->where('is_resolved', true);
        }

        if ($request->status == 'unresolved') {
            $logs->where('is_resolved', false);
        }

        $logs = $logs->latest()->get();

        // CSV Headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="system_logs.csv"',
        ];

        // CSV Data
        $columns = ['ID', 'Level', 'Message', 'Stack Trace', 'User', 'IP', 'Status', 'URL', 'Method', 'File', 'Line', 'Created At'];

        $callback = function () use ($logs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->level,
                    $log->message,
                    $log->trace,
                    $log->user?->name ?? 'N/A',
                    $log->ip,
                    $log->is_resolved ? 'Resolved' : 'Unresolved',
                    $log->url,
                    $log->method,
                    $log->file,
                    $log->line,
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
