@extends('layouts.whatsapp-crm')

@section('pageTitle', 'Reports & Analytics')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $totalRevenue ?? 0 }}</div>
        <div class="stat-label">Total Revenue</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $monthlyGrowth ?? 0 }}%</div>
        <div class="stat-label">Monthly Growth</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $activeDeals ?? 0 }}</div>
        <div class="stat-label">Active Deals</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-value">{{ $avgDealSize ?? 0 }}</div>
        <div class="stat-label">Avg Deal Size</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
    <!-- Sales Funnel Chart -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-chart-funnel" style="margin-right: 8px;"></i>
            Sales Funnel
        </div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 120px; font-weight: 600; color: #111b21;">Leads</div>
                    <div style="flex: 1; background: #e9ecef; border-radius: 4px; height: 30px; position: relative;">
                        <div style="background: #00a884; height: 100%; width: 100%; border-radius: 4px; display: flex; align-items: center; padding: 0 12px; color: white; font-weight: 600;">
                            {{ $leadsCount ?? 0 }}
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 120px; font-weight: 600; color: #111b21;">Qualified</div>
                    <div style="flex: 1; background: #e9ecef; border-radius: 4px; height: 30px; position: relative;">
                        <div style="background: #007bff; height: 100%; width: 75%; border-radius: 4px; display: flex; align-items: center; padding: 0 12px; color: white; font-weight: 600;">
                            {{ $qualifiedCount ?? 0 }}
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 120px; font-weight: 600; color: #111b21;">Proposal</div>
                    <div style="flex: 1; background: #e9ecef; border-radius: 4px; height: 30px; position: relative;">
                        <div style="background: #ffc107; height: 100%; width: 50%; border-radius: 4px; display: flex; align-items: center; padding: 0 12px; color: #212529; font-weight: 600;">
                            {{ $proposalCount ?? 0 }}
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 120px; font-weight: 600; color: #111b21;">Negotiation</div>
                    <div style="flex: 1; background: #e9ecef; border-radius: 4px; height: 30px; position: relative;">
                        <div style="background: #fd7e14; height: 100%; width: 35%; border-radius: 4px; display: flex; align-items: center; padding: 0 12px; color: white; font-weight: 600;">
                            {{ $negotiationCount ?? 0 }}
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 120px; font-weight: 600; color: #111b21;">Closed Won</div>
                    <div style="flex: 1; background: #e9ecef; border-radius: 4px; height: 30px; position: relative;">
                        <div style="background: #28a745; height: 100%; width: 25%; border-radius: 4px; display: flex; align-items: center; padding: 0 12px; color: white; font-weight: 600;">
                            {{ $closedWonCount ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Department Performance -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-building" style="margin-right: 8px;"></i>
            Department Performance
        </div>
        <div class="card-body">
            @if(isset($departmentStats) && count($departmentStats) > 0)
                @foreach($departmentStats as $dept)
                <div style="margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <span style="font-weight: 600; color: #111b21;">{{ ucfirst($dept->name) }}</span>
                        <span style="color: #667781; font-size: 0.875rem;">{{ $dept->leads }} leads</span>
                    </div>
                    <div style="background: #e9ecef; border-radius: 4px; height: 8px;">
                        <div style="background: #00a884; height: 100%; width: {{ $dept->performance }}%; border-radius: 4px;"></div>
                    </div>
                </div>
                @endforeach
            @else
            <div style="text-align: center; padding: 20px; color: #667781;">
                <i class="fas fa-chart-bar" style="font-size: 2rem; margin-bottom: 8px; opacity: 0.5;"></i>
                <div>No department data available</div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-calendar-alt" style="margin-right: 8px;"></i>
                Monthly Performance
            </div>
            <select style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                <option value="6">Last 6 Months</option>
                <option value="12">Last 12 Months</option>
                <option value="3">Last 3 Months</option>
            </select>
        </div>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            @for($i = 5; $i >= 0; $i--)
            <div style="text-align: center; padding: 16px; background: #f8f9fa; border-radius: 8px;">
                <div style="font-weight: 600; color: #111b21; margin-bottom: 8px;">
                    {{ now()->subMonths($i)->format('M Y') }}
                </div>
                <div style="display: flex; justify-content: space-around; margin-bottom: 8px;">
                    <div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #00a884;">
                            {{ rand(20, 100) }}
                        </div>
                        <div style="font-size: 0.75rem; color: #667781;">Leads</div>
                    </div>
                    <div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: #007bff;">
                            {{ rand(10, 50) }}
                        </div>
                        <div style="font-size: 0.75rem; color: #667781;">Sales</div>
                    </div>
                </div>
                <div style="font-size: 0.875rem; color: #667781;">
                    Revenue: ${{ number_format(rand(10000, 100000), 0) }}
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

@if(auth()->user()->role == 1 || auth()->user()->role == 5)
<div class="card">
    <div class="card-header">
        <i class="fas fa-user-tie" style="margin-right: 8px;"></i>
        Top Performers
    </div>
    <div class="card-body">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Rank</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Name</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Department</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Leads</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Conversions</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 1; $i <= 5; $i++)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px;">
                            @if($i <= 3)
                                <span style="background: {{ $i == 1 ? '#ffd700' : ($i == 2 ? '#c0c0c0' : '#cd7f32') }}; color: white; padding: 4px 8px; border-radius: 12px; font-weight: 600; font-size: 0.875rem;">
                                    #{{ $i }}
                                </span>
                            @else
                                <span style="color: #667781; font-weight: 600;">#{{ $i }}</span>
                            @endif
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #00a884; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.875rem;">
                                    {{ chr(65 + $i - 1) }}
                                </div>
                                <span style="font-weight: 600; color: #111b21;">User {{ $i }}</span>
                            </div>
                        </td>
                        <td style="padding: 12px;">
                            <span class="badge badge-info">{{ ['Sales', 'Marketing', 'Development', 'HR', 'Operations'][$i - 1] }}</span>
                        </td>
                        <td style="padding: 12px; color: #111b21;">{{ rand(30, 100) }}</td>
                        <td style="padding: 12px; color: #111b21;">{{ rand(10, 40) }}</td>
                        <td style="padding: 12px; color: #111b21; font-weight: 600;">${{ number_format(rand(50000, 200000), 0) }}</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
