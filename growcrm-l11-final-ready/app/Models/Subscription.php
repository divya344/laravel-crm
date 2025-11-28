<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Subscription
 *
 * Represents a recurring subscription that may be linked to clients, projects, and invoices.
 *
 * @property int $subscription_id
 * @property string|null $subscription_reference
 * @property string|null $subscription_status
 * @property Carbon|null $subscription_created
 * @property Carbon|null $subscription_updated
 */
class Subscription extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'subscriptions';
    protected $primaryKey = 'subscription_id';
    protected $guarded = ['subscription_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'subscription_created';
    const UPDATED_AT = 'subscription_updated';

    protected $casts = [
        'subscription_created' => 'datetime',
        'subscription_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created the subscription.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'subscription_creatorid', 'id');
    }

    /**
     * The client associated with this subscription.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'subscription_clientid', 'client_id');
    }

    /**
     * The project related to this subscription.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'subscription_projectid', 'project_id');
    }

    /**
     * The category assigned to this subscription.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'subscription_categoryid', 'category_id');
    }

    /**
     * Invoices generated from this subscription.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'bill_subscriptionid', 'subscription_id');
    }

    /**
     * Payments made under this subscription.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'payment_subscriptionid', 'subscription_id');
    }

    /**
     * Tags assigned to this subscription.
     */
    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagresource');
    }

    /**
     * Logs related to this subscription.
     */
    public function logs()
    {
        return $this->morphMany(Log::class, 'logresource');
    }

    /**
     * Taxes applied to this subscription.
     */
    public function taxes()
    {
        return $this->morphMany(Tax::class, 'taxresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Format the subscription ID (e.g. SUB-000001).
     */
    public function getFormattedSubscriptionIdAttribute(): string
    {
        return runtimeSubscriptionIdFormat($this->subscription_id);
    }

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->subscription_created?->format('d M Y, h:i A');
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->subscription_updated?->format('d M Y, h:i A');
    }
}
