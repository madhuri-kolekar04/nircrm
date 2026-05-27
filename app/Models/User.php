<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'designation',
        'position',
        'profile_photo_path',
        'contact_number',
        'email',
        'email_verified_at',
        'password',
        'password_change_required',
        'role',
        'group',
        'assign',
        'employeeID',
        'location',
        'comapny_name',
        'pan_number',
        'aadhar_number',
        'remember_token',
        'otp',
        'otp_expires_at',
        'is_verified',
        'department',
        'department_id',
        'manager_id',
        'employee_id',
        'joining_date',
        'salary',
        'work_shift',
        'is_active',
        'address',
        'phone',
        'date_of_birth',
        'shift_id',
        'deactivated_at',
        'deactivation_reason',
        'deactivated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'joining_date' => 'date',
        'date_of_birth' => 'date',
        'salary' => 'decimal:2',
        'is_active' => 'boolean',
        'deactivated_at' => 'datetime',
    ];

    /**
     * Get the role name attribute
     */
    public function getRoleNameAttribute()
    {
        $roles = [
            1 => 'Admin',
            2 => 'Employee',
            3 => 'Customer',
            4 => 'Manager',
            5 => 'General Manager'
        ];
        
        // Handle null or invalid role values
        $roleId = $this->role;
        if ($roleId === null || !is_numeric($roleId)) {
            return 'Unknown';
        }
        
        return $roles[$roleId] ?? 'Unknown';
    }

    public function Groupname(){
        return $this->belongsTo(Group::class,'group','id');
    }

    // Attendance System Relationships
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    // Add accessor to handle department field conflict
    // public function getDepartmentAttribute()
    // {

      
    //     if ($this->department_id) {
    //         return $this->department()->first();
    //     }
        
    //     return $this->attributes['department'] ?? null;
    // }

 

public function getDepartmentNameAttribute()
{
    if ($this->department_id && $this->department) {
        return $this->department->department;
    }

    return $this->attributes['department'] ?? null;
}

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function deactivatedBy()
    {
        return $this->belongsTo(User::class, 'deactivated_by');
    }

    public function getTodayAttendanceAttribute()
    {
        return $this->attendances()->where('date', now()->format('Y-m-d'))->first();
    }

    public function isCheckedIn()
    {
        $today = $this->attendances()->where('date', now()->format('Y-m-d'))->first();
        return $today && $today->check_in_time && !$today->check_out_time;
    }

    public function isCheckedOut()
    {
        $today = $this->attendances()->where('date', now()->format('Y-m-d'))->first();
        return $today && $today->check_in_time && $today->check_out_time;
    }

    public function canApproveLeave($leave = null)
    {
        if ($this->role === 1 || $this->role === 5) return true; // Admin and General Manager
        
        if ($this->role === 4) { // Manager
            if ($leave) {
                return $leave->user->manager_id === $this->id || 
                       $leave->user->department_id === $this->department_id;
            }
            return true; // Managers can approve leaves in general
        }
        
        return false;
    }

    public function getSubordinatesIds()
    {
        return $this->subordinates()->pluck('id')->toArray();
    }

    public function getDepartmentUsersIds()
    {
        if ($this->department_id) {
            return User::where('department_id', $this->department_id)
                      ->where('id', '!=', $this->id)
                      ->pluck('id')->toArray();
        }
        return [];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . ($this->last_name ?? '');
    }
}
