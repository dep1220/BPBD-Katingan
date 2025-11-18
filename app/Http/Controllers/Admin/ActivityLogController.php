<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs with filters
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activityLogs = $query->paginate(20);

        // Get unique users for filter dropdown
        $users = \App\Models\User::all();

        // Get unique actions
        $actions = ActivityLog::distinct('action')->pluck('action');

        return view('admin.activity-logs.index', compact('activityLogs', 'users', 'actions'));
    }

    /**
     * Delete old activity logs (older than specified days)
     */
    public function cleanOld(Request $request)
    {
        $days = $request->input('days', 30);
        $date = Carbon::now()->subDays($days);

        $count = ActivityLog::where('created_at', '<', $date)->count();

        if ($count > 0) {
            ActivityLog::where('created_at', '<', $date)->delete();
            return redirect()->back()->with('success', "{$count} log aktivitas lama berhasil dihapus!");
        }

        return redirect()->back()->with('info', 'Tidak ada log aktivitas lama untuk dihapus.');
    }

    /**
     * Delete all activity logs
     */
    public function deleteAll()
    {
        $count = ActivityLog::count();
        
        if ($count > 0) {
            ActivityLog::truncate();
            return redirect()->back()->with('success', "Semua {$count} log aktivitas berhasil dihapus!");
        }

        return redirect()->back()->with('info', 'Tidak ada log aktivitas untuk dihapus.');
    }

    /**
     * Delete specific activity log
     */
    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();
        return redirect()->back()->with('success', 'Log aktivitas berhasil dihapus!');
    }
}
