<?php

namespace App\Models;

use App\Models\Concerns\BelongsToCampus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    // We don't use BelongsToCampus trait here because campus_id is nullable for global settings
    
    protected $fillable = [
        'campus_id',
        'group',
        'key',
        'value',
        'type',
    ];

    public static function get($key, $default = null, $campus_id = null)
    {
        $campus_id = $campus_id ?: auth()->user()?->campus_id;
        
        $setting = self::where('key', $key)
            ->where(function($q) use ($campus_id) {
                $q->where('campus_id', $campus_id)
                  ->orWhereNull('campus_id');
            })
            ->orderBy('campus_id', 'desc') // Campus specific settings take precedence
            ->first();

        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $group = 'general', $campus_id = null)
    {
        return self::updateOrCreate(
            ['key' => $key, 'campus_id' => $campus_id],
            ['value' => $value, 'group' => $group]
        );
    }
}
