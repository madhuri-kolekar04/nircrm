<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadReaction;
use App\Models\Lead;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReactionsSystemController extends Controller
{
    /**
     * Display the reactions system page
     */
    public function index()
    {
        $reactions = LeadReaction::with(['lead', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        $reactionTypes = [
            'positive' => '😊 Positive',
            'neutral' => '😐 Neutral', 
            'negative' => '😞 Negative',
            'follow_up' => '📞 Follow Up Required',
            'interested' => '🔥 Highly Interested',
            'not_reachable' => '📵 Not Reachable',
            'hot_lead' => '🔥 Hot Lead',
            'cold_lead' => '❄️ Cold Lead',
            'appointment_set' => '📅 Appointment Set',
            'meeting_scheduled' => '🤝 Meeting Scheduled',
            'proposal_sent' => '📄 Proposal Sent',
            'negotiation' => '💰 Negotiation',
            'closed_won' => '✅ Closed Won',
            'closed_lost' => '❌ Closed Lost'
        ];

        $priorities = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'];
        $statuses = ['active' => 'Active', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'postponed' => 'Postponed'];
        
        $leads = Lead::select('id', 'name', 'email', 'phone')->orderBy('name')->get();
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();
        $departments = Department::select('id', 'name')->orderBy('name')->get();

        return view('admin.reactions-system.index', compact(
            'reactions', 
            'reactionTypes', 
            'priorities', 
            'statuses',
            'leads',
            'users',
            'departments'
        ));
    }

    /**
     * Store a new reaction
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_id' => 'required|exists:leads,id',
            'reaction_type' => 'required|string|in:positive,neutral,negative,follow_up,interested,not_reachable,hot_lead,cold_lead,appointment_set,meeting_scheduled,proposal_sent,negotiation,closed_won,closed_lost',
            'notes' => 'nullable|string|max:2000',
            'reaction_details' => 'nullable|string|max:5000',
            'next_follow_up' => 'nullable|date|after_or_equal:today',
            'follow_up_time' => 'nullable|string',
            'follow_up_priority' => 'nullable|string|in:low,medium,high,urgent',
            'follow_up_notes' => 'nullable|string|max:1000',
            'call_duration' => 'nullable|integer|min:1|max:99999',
            'call_type' => 'nullable|string|in:incoming,outgoing,missed',
            'phone_number' => 'nullable|string|max:20',
            'meeting_date' => 'nullable|date|after_or_equal:today',
            'meeting_time' => 'nullable|string',
            'meeting_location' => 'nullable|string|max:200',
            'meeting_agenda' => 'nullable|string|max:1000',
            'priority' => 'nullable|string|in:low,medium,high,urgent',
            'rating' => 'nullable|integer|min:1|max:5',
            'source' => 'nullable|string|max:50',
            'campaign' => 'nullable|string|max:100',
            'value' => 'nullable|numeric|min:0|max:999999999.99',
            'tags' => 'nullable|string|max:500'
        ], [
            'lead_id.required' => 'Please select a lead',
            'lead_id.exists' => 'Selected lead does not exist',
            'reaction_type.required' => 'Please select a reaction type',
            'reaction_type.in' => 'Invalid reaction type selected',
            'notes.max' => 'Notes cannot exceed 2000 characters',
            'reaction_details.max' => 'Details cannot exceed 5000 characters',
            'next_follow_up.after_or_equal' => 'Follow-up date cannot be in the past',
            'call_duration.min' => 'Call duration must be at least 1 second',
            'call_duration.max' => 'Call duration cannot exceed 99999 seconds',
            'meeting_date.after_or_equal' => 'Meeting date cannot be in the past',
            'rating.min' => 'Rating must be at least 1',
            'rating.max' => 'Rating cannot exceed 5',
            'value.min' => 'Value must be at least 0',
            'value.max' => 'Value cannot exceed 999,999,999.99'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $reactionData = [
                'lead_id' => $request->lead_id,
                'user_id' => auth()->id(),
                'department_id' => auth()->user()->department ?? null,
                'reaction_type' => $request->reaction_type,
                'notes' => $request->notes,
                'reaction_details' => $request->reaction_details,
                'reaction_date' => now()->toDateString(),
                'reaction_time' => now()->toTimeString(),
                'reaction_timestamp' => now(),
                'next_follow_up' => $request->next_follow_up ? date('Y-m-d', strtotime($request->next_follow_up)) : null,
                'follow_up_time' => $request->follow_up_time,
                'follow_up_priority' => $request->follow_up_priority ?? 'medium',
                'follow_up_notes' => $request->follow_up_notes,
                'call_duration' => $request->call_duration ? (int)$request->call_duration : null,
                'call_type' => $request->call_type,
                'phone_number' => $request->phone_number,
                'meeting_date' => $request->meeting_date ? date('Y-m-d', strtotime($request->meeting_date)) : null,
                'meeting_time' => $request->meeting_time,
                'meeting_location' => $request->meeting_location,
                'meeting_agenda' => $request->meeting_agenda,
                'priority' => $request->priority ?? 'medium',
                'rating' => $request->rating ? (int)$request->rating : null,
                'source' => $request->source,
                'campaign' => $request->campaign,
                'value' => $request->value ? (float)$request->value : null,
                'tags' => $request->tags,
                'status' => 'active'
            ];

            Log::info('Creating reaction system record:', $reactionData);

            $reaction = ReactionsSystem::create($reactionData);

            // Send notifications if follow-up is set
            if ($request->next_follow_up) {
                $this->sendFollowUpNotifications($reaction, $request->next_follow_up);
            }

            // Send email notifications
            $this->sendReactionNotifications($reaction);

            DB::commit();

            Log::info('Reaction system record created successfully:', ['id' => $reaction->id]);

            return response()->json([
                'success' => true,
                'message' => 'Reaction recorded successfully!',
                'reaction' => $reaction->load(['lead', 'user', 'customer', 'department'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating reaction system record: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error recording reaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reaction details
     */
    public function show($id)
    {
        $reaction = ReactionsSystem::with(['lead', 'user', 'customer', 'department'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'reaction' => $reaction
        ]);
    }

    /**
     * Update reaction status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:active,completed,cancelled,postponed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $reaction = ReactionsSystem::findOrFail($id);
            $reaction->status = $request->status;
            $reaction->save();

            Log::info('Reaction status updated:', ['id' => $id, 'status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'reaction' => $reaction
            ]);

        } catch (\Exception $e) {
            Log::error('Error updating reaction status: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete reaction
     */
    public function destroy($id)
    {
        try {
            $reaction = ReactionsSystem::findOrFail($id);
            $reaction->delete();

            Log::info('Reaction deleted:', ['id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Reaction deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting reaction: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting reaction: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send follow-up notifications
     */
    private function sendFollowUpNotifications($reaction, $followUpDate)
    {
        try {
            // Send to assigned user
            if ($reaction->lead && $reaction->lead->assigned_to) {
                $assignedUser = User::find($reaction->lead->assigned_to);
                if ($assignedUser) {
                    Mail::to($assignedUser->email)->send(new \App\Mail\ReactionFollowUpNotification($reaction, $followUpDate));
                    $reaction->markNotificationSent();
                }
            }

            // Send to General Managers
            $generalManagers = User::where('role', 5)->get();
            foreach ($generalManagers as $gm) {
                Mail::to($gm->email)->send(new \App\Mail\ReactionFollowUpNotification($reaction, $followUpDate));
            }

        } catch (\Exception $e) {
            Log::error('Error sending follow-up notifications: ' . $e->getMessage());
        }
    }

    /**
     * Send reaction notifications
     */
    private function sendReactionNotifications($reaction)
    {
        try {
            // Send email notifications
            if ($reaction->lead && $reaction->lead->assigned_to) {
                $assignedUser = User::find($reaction->lead->assigned_to);
                if ($assignedUser) {
                    Mail::to($assignedUser->email)->send(new \App\Mail\ReactionCreatedNotification($reaction));
                    $reaction->markEmailSent();
                }
            }

            // Send to General Managers for important reactions
            if (in_array($reaction->reaction_type, ['hot_lead', 'closed_won', 'closed_lost'])) {
                $generalManagers = User::where('role', 5)->get();
                foreach ($generalManagers as $gm) {
                    Mail::to($gm->email)->send(new \App\Mail\ReactionCreatedNotification($reaction));
                }
            }

        } catch (\Exception $e) {
            Log::error('Error sending reaction notifications: ' . $e->getMessage());
        }
    }

    /**
     * Test notification system
     */
    public function testNotifications(Request $request)
    {
        try {
            // Run the notification command
            \Artisan::call('reactions:send-notifications');
            $output = \Artisan::output();
            
            return response()->json([
                'success' => true,
                'message' => 'Notification system test completed successfully. Check logs for details.',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            Log::error('Error testing notifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error testing notification system: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send pending notifications now
     */
    public function sendPendingNotifications(Request $request)
    {
        try {
            // Run the notification command
            \Artisan::call('reactions:send-notifications');
            $output = \Artisan::output();
            
            return response()->json([
                'success' => true,
                'message' => 'Pending notifications sent successfully.',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending pending notifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending pending notifications: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get system status for real-time updates
     */
    public function getSystemStatus(Request $request)
    {
        try {
            $stats = [
                'total' => \App\Models\LeadReaction::count(),
                'scheduled' => \App\Models\LeadReaction::where('notification_sent', false)
                    ->where('next_follow_up', '>=', now()->format('Y-m-d'))
                    ->count(),
                'sent_today' => \App\Models\LeadReaction::where('notification_sent', true)
                    ->whereDate('notification_sent_at', today())
                    ->count(),
                'overdue' => \App\Models\LeadReaction::where('notification_sent', false)
                    ->where('next_follow_up', '<', now()->format('Y-m-d'))
                    ->count(),
                'last_check' => now()->format('H:i:s'),
            ];
            
            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('Error getting system status: ' . $e->getMessage());
            return response()->json([
                'error' => 'Unable to fetch system status'
            ], 500);
        }
    }
}
