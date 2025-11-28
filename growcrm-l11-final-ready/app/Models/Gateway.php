<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Gateway extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'gateways';
    protected $primaryKey = 'gateway_id';
    protected $guarded = ['gateway_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'gateway_created';
    const UPDATED_AT = 'gateway_updated';

    /**
     * If your gateways table stores JSON config/options (e.g. credentials),
     * cast to array/object so you can use $gateway->config safely.
     */
    protected $casts = [
        'gateway_config' => AsArrayObject::class,
        'gateway_created' => 'datetime',
        'gateway_updated' => 'datetime',
        'is_active' => 'boolean',
    ];

    /** ─────────────── ACCESSORS / HELPERS ─────────────── */

    /**
     * Return the gateway human name or fallback to code.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->gateway_name ?? strtoupper($this->gateway_code ?? 'GATEWAY');
    }

    /**
     * Returns config item or default.
     *
     * Usage: $gateway->getConfig('secret_key', null)
     */
    public function getConfig(string $key, $default = null)
    {
        $config = $this->gateway_config ?? [];
        return $config[$key] ?? $default;
    }

    /**
     * Is the gateway enabled for use?
     */
    public function isEnabled(): bool
    {
        return (bool) ($this->is_active ?? false);
    }

    /** ─────────────── SCOPES ─────────────── */

    public function scopeEnabled($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCode($query, string $code)
    {
        return $query->where('gateway_code', $code);
    }
}
