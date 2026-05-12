@extends('layouts.whatsapp-crm')

@section('pageTitle', 'Dashboard')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $totalLeads ?? 0 }}</div>
        <div class="stat-label">Total Leads</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $totalClients ?? 0 }}</div>
        <div class="stat-label">Converted Clients</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $pendingTasks ?? 0 }}</div>
        <div class="stat-label">Pending Tasks</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $conversionRate ?? 0 }}%</div>
        <div class="stat-label">Conversion Rate</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-chart-line" style="margin-right: 8px;"></i>
        Recent Activity
    </div>
    <div class="card-body">
        @if(isset($recentLeads) && count($recentLeads) > 0)
            @foreach($recentLeads as $lead)
                <div class="lead-item">
                    <div>
                        <div style="font-weight: 600; color: #111b21; margin-bottom: 4px;">
                            {{ $lead->name }}
                        </div>
                        <div style="color: #667781; font-size: 0.875rem;">
                            {{ $lead->email }} • {{ $lead->phone }}
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <span class="badge badge-{{ $lead->status === 'converted' ? 'success' : ($lead->status === 'pending' ? 'warning' : 'info') }}">
                            {{ ucfirst($lead->status) }}
                        </span>
                        <div style="font-size: 0.75rem; color: #667781; margin-top: 4px;">
                            {{ $lead->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 40px; color: #667781;">
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                <div>No recent activity</div>
            </div>
        @endif
    </div>
</div>

@if(auth()->user()->role == 1 || auth()->user()->role == 5)
<div class="card">
    <div class="card-header">
        <i class="fas fa-building" style="margin-right: 8px;"></i>
        Department Overview
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div style="text-align: center; padding: 16px; background: #f8f9fa; border-radius: 8px;">
                <div style="font-size: 1.5rem; font-weight: 700; color: #00a884;">{{ $departmentCount ?? 0 }}</div>
                <div style="color: #667781; font-size: 0.875rem;">Total Departments</div>
            </div>
            <div style="text-align: center; padding: 16px; background: #f8f9fa; border-radius: 8px;">
                <div style="font-size: 1.5rem; font-weight: 700; color: #00a884;">{{ $userCount ?? 0 }}</div>
                <div style="color: #667781; font-size: 0.875rem;">Total Users</div>
            </div>
            <div style="text-align: center; padding: 16px; background: #f8f9fa; border-radius: 8px;">
                <div style="font-size: 1.5rem; font-weight: 700; color: #00a884;">{{ $activeUsers ?? 0 }}</div>
                <div style="color: #667781; font-size: 0.875rem;">Active Users</div>
            </div>
        </div>
    </div>
</div>
@endif

@if(in_array(auth()->user()->role, [1, 4, 5]) || in_array(auth()->user()->position, ['CEO', 'Admin', 'Manager']))
<div class="card">
    <div class="card-header">
        <i class="fas fa-users" style="margin-right: 8px;"></i>
        Team Performance
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
            @if(isset($teamMembers) && count($teamMembers) > 0)
                @foreach($teamMembers as $member)
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8f9fa; border-radius: 8px;">
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #00a884; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #111b21;">{{ $member->name }}</div>
                            <div style="font-size: 0.875rem; color: #667781;">{{ $member->tasks_completed ?? 0 }} tasks completed</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #667781;">
                    <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                    <div>No team members assigned</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endif

@if(auth()->user()->role == 2 || auth()->user()->position == 'Staff')
<div class="card">
    <div class="card-header">
        <i class="fas fa-tasks" style="margin-right: 8px;"></i>
        My Tasks
    </div>
    <div class="card-body">
        @if(isset($myTasks) && count($myTasks) > 0)
            @foreach($myTasks as $task)
                <div class="lead-item">
                    <div>
                        <div style="font-weight: 600; color: #111b21; margin-bottom: 4px;">
                            {{ $task->title }}
                        </div>
                        <div style="color: #667781; font-size: 0.875rem;">
                            {{ $task->description }}
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <span class="badge badge-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        <div style="font-size: 0.75rem; color: #667781; margin-top: 4px;">
                            Due: {{ $task->due_date->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div style="text-align: center; padding: 40px; color: #667781;">
                <i class="fas fa-clipboard-check" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                <div>No tasks assigned</div>
            </div>
        @endif
    </div>
</div>
@endif
