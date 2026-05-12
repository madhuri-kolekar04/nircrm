<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staprio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'type',
        'color',
        'is_protected',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_protected' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get active statuses for dropdown.
     */
    public static function getActiveStatuses(): array
    {
        return self::where('type', 'status')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'value')
            ->toArray();
    }

    /**
     * Get active priorities for dropdown.
     */
    public static function getActivePriorities(): array
    {
        return self::where('type', 'priority')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'value')
            ->toArray();
    }

    /**
     * Get status color for specific value.
     */
    public static function getStatusColorForValue(string $value): string
    {
        $staprio = self::where('type', 'status')
            ->where('value', $value)
            ->where('is_active', true)
            ->first();

        return $staprio ? $staprio->color : '#6c757d';
    }

    /**
     * Get priority color for specific value.
     */
    public static function getPriorityColorForValue(?string $value): string
    {
        // Handle null values by providing a default
        $value = $value ?? 'medium';
        
        $staprio = self::where('type', 'priority')
            ->where('value', $value)
            ->where('is_active', true)
            ->first();

        return $staprio ? $staprio->color : '#6c757d';
    }

    /**
     * Get all statuses with details.
     */
    public static function getAllStatuses()
    {
        return self::where('type', 'status')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get all priorities with details.
     */
    public static function getAllPriorities()
    {
        return self::where('type', 'priority')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * Check if a status value is protected.
     */
    public static function isStatusProtected(string $value): bool
    {
        $staprio = self::where('type', 'status')
            ->where('value', $value)
            ->first();

        return $staprio ? $staprio->is_protected : false;
    }

    /**
     * Add new status or priority.
     */
    public static function addStaprio(array $data): self
    {
        // Check for duplicates
        $exists = self::where('type', $data['type'])
            ->where('value', $data['value'])
            ->exists();

        if ($exists) {
            throw new \Exception('This ' . $data['type'] . ' already exists.');
        }

        return self::create($data);
    }

    /**
     * Update status or priority.
     */
    public static function updateStaprio(int $id, array $data): bool
    {
        $staprio = self::findOrFail($id);

        // Check if it's protected
        if ($staprio->is_protected) {
            throw new \Exception('This ' . $staprio->type . ' is protected and cannot be modified.');
        }

        // Check for duplicates (excluding current)
        $exists = self::where('type', $staprio->type)
            ->where('value', $data['value'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            throw new \Exception('This ' . $staprio->type . ' already exists.');
        }

        return $staprio->update($data);
    }

    /**
     * Delete status or priority.
     */
    public static function deleteStaprio(int $id): bool
    {
        $staprio = self::findOrFail($id);

        // Check if it's protected
        if ($staprio->is_protected) {
            throw new \Exception('This ' . $staprio->type . ' is protected and cannot be deleted.');
        }

        return $staprio->delete();
    }

    /**
     * Get next sort order for a type.
     */
    public static function getNextSortOrder(string $type): int
    {
        $maxOrder = self::where('type', $type)
            ->max('sort_order');

        return $maxOrder ? $maxOrder + 1 : 1;
    }
}
