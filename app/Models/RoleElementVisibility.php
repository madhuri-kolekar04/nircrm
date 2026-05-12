<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleElementVisibility extends Model
{
    use HasFactory;

    protected $table = 'role_element_visibility';

    protected $fillable = [
        'page_url',
        'role_id',
        'element_type',
        'element_identifier',
        'element_name',
        'is_visible',
        'element_metadata'
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'element_metadata' => 'array'
    ];

    public static function getVisibilityForPage($pageUrl, $roleId)
    {
        return self::where('page_url', $pageUrl)
                  ->where('role_id', $roleId)
                  ->get()
                  ->keyBy('element_identifier');
    }

    public static function updateVisibility($pageUrl, $roleId, $elementIdentifier, $isVisible)
    {
        return self::updateOrCreate(
            [
                'page_url' => $pageUrl,
                'role_id' => $roleId,
                'element_identifier' => $elementIdentifier
            ],
            [
                'is_visible' => $isVisible
            ]
        );
    }
}
