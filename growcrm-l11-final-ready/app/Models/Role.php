<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

/**
 * Class Role
 *
 * Represents a user role (e.g., Admin, Manager, Staff, Client).
 *
 * @property int $role_id
 * @property string $role_name
 * @property string|null $role_description
 * @property Carbon|null $role_created
 * @property Carbon|null $role_updated
 */
class Role extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $guarded = ['role_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'role_created';
    const UPDATED_AT = 'role_updated';

    protected $casts = [
        'role_created' => 'datetime',
        'role_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * A role can be assigned to many users.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Return a human-readable role name.
     * e.g., "Admin" instead of "admin"
     */
    public function getReadableRoleNameAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->role_name));
    }

    /**
     * Get the lowercase role name for logic or filtering.
     */
    public function getTeamRolesAttribute(): string
    {
        return strtolower($this->role_name ?? '');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Get only admin roles.
     */
    public function scopeAdmin($query)
    {
        return $query->where('role_name', 'admin');
    }

    /**
     * Scope: Get only manager roles.
     */
    public function scopeManager($query)
    {
        return $query->where('role_name', 'manager');
    }

    /**
     * Scope: Get only team roles (non-admin).
     */
    public function scopeTeamRoles($query)
    {
        return $query->whereNotIn('role_name', ['admin', 'super_admin']);
    }
}
