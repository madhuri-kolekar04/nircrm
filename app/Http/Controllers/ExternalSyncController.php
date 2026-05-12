<?php

namespace App\Http\Controllers;

use App\Services\ExternalDatabaseSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExternalSyncController extends Controller
{
    protected $externalSyncService;

    public function __construct(ExternalDatabaseSyncService $externalSyncService)
    {
        $this->externalSyncService = $externalSyncService;
    }

    /**
     * Show external sync configuration page
     */
    public function index()
    {
        return view('admin.external-sync.index');
    }

    /**
     * Sync from external database
     */
    public function sync(Request $request)
    {
        try {
            $externalDbConfig = [
                'host' => $request->input('host'),
                'port' => $request->input('port', '3306'),
                'database' => $request->input('database'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'table' => $request->input('table'),
            ];

            $result = $this->externalSyncService->syncFromExternalDatabase($externalDbConfig);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => "Sync completed! Imported {$result['synced_count']} new leads, updated {$result['updated_count']} leads.",
                    'synced_count' => $result['synced_count'],
                    'updated_count' => $result['updated_count'],
                    'errors' => $result['errors']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 500);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate SQL commands for manual setup
     */
    public function generateSQL(Request $request)
    {
        try {
            $externalDbConfig = [
                'host' => $request->input('host'),
                'port' => $request->input('port', '3306'),
                'database' => $request->input('database'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'table' => $request->input('table'),
            ];

            $sqlCommands = $this->externalSyncService->generateSQLCommands($externalDbConfig);

            return response()->json([
                'success' => true,
                'sql_commands' => $sqlCommands
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate SQL: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get sync status
     */
    public function status()
    {
        try {
            $syncStats = DB::table('external_leads_sync')
                ->selectRaw('
                    COUNT(*) as total_synced,
                    COUNT(CASE WHEN last_synced_at > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 END) as synced_last_24h,
                    COUNT(CASE WHEN last_synced_at > DATE_SUB(NOW(), INTERVAL 1 HOUR) THEN 1 END) as synced_last_1h,
                    MAX(last_synced_at) as last_sync
                ')
                ->first();

            $recentSyncs = DB::table('external_leads_sync')
                ->orderBy('last_synced_at', 'desc')
                ->limit(10)
                ->get(['name', 'email', 'company_name', 'external_database_name', 'last_synced_at']);

            return response()->json([
                'success' => true,
                'stats' => $syncStats,
                'recent_syncs' => $recentSyncs
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get sync status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create database trigger
     */
    public function createTrigger(Request $request)
    {
        try {
            $externalDbConfig = [
                'host' => $request->input('host'),
                'port' => $request->input('port', '3306'),
                'database' => $request->input('database'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'table' => $request->input('table'),
            ];

            $result = $this->externalSyncService->createDatabaseTrigger($externalDbConfig);

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create trigger: ' . $e->getMessage()
            ], 500);
        }
    }
}
