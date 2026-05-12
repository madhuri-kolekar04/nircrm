<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'invoice_id',
        'user_id',
        'update_point_1',
        'update_point_2',
        'update_point_3',
        'request_text',
        'update_date',
        'task_due_date',
        'task_priority',
        'task_status',
        'attachment',
    ];

    protected $casts = [
        'update_date' => 'datetime',
        'task_due_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
