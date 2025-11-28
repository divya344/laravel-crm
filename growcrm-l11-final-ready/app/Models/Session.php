<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Session
 *
 * Represents a user session record.
 *
 * @property string $id
 * @property int|null $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $payload
 * @property int|null $last_activity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Session extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'sessions'; // Laravel default session table
    protected $primaryKey = 'id';
    public $incrementing = false; // Default session IDs are strings (not auto-incremented)
    protected $keyType = 'string';

    protected $guarded = [];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_activity' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * If sessions are linked to users (optional).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Returns human-readable session creation time.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->created_at?->format('d M Y, h:i A');
    }

    /**
     * Returns human-readable last activity time.
     */
    public function getFormattedLastActivityAttribute(): ?string
    {
        return $this->last_activity?->format('d M Y, h:i A');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope to get active sessions in the last 30 minutes.
     */
    public function scopeActive($query)
    {
        return $query->where('last_activity', '>=', now()->subMinutes(30));
    }

    /**
     * Scope to get sessions of a specific user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
