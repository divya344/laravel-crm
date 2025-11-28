<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Lead extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'leads';
    protected $primaryKey = 'lead_id';
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'lead_created';
    const UPDATED_AT = 'lead_updated';

    /** 
     * Allow mass assignment for these columns.
     * (Needed for Lead::create($request->all()))
     */
    protected $fillable = [
        'lead_name',
        'lead_email',
        'lead_phone',
        'lead_status',
    ];

    protected $casts = [
        'lead_created' => 'datetime',
        'lead_updated' => 'datetime',
        'lead_last_contacted' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */
    public function creator()
    {
        return $this->belongsTo(User::class, 'lead_creatorid', 'id');
    }

    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status', 'leadstatus_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'lead_categoryid', 'category_id');
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagresource');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentresource');
    }

    public function checklists()
    {
        return $this->morphMany(Checklist::class, 'checklistresource');
    }

    public function assignedRecords()
    {
        return $this->hasMany(LeadAssigned::class, 'leadsassigned_leadid', 'lead_id');
    }

    public function assigned()
    {
        return $this->belongsToMany(User::class, 'leads_assigned', 'leadsassigned_leadid', 'leadsassigned_userid');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentresource');
    }

    public function events()
    {
        return $this->morphMany(Event::class, 'eventresource');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'doc_lead_id', 'lead_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'doc_lead_id', 'lead_id');
    }

    public function reminders()
    {
        return $this->morphMany(Reminder::class, 'reminderresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */
    public function getFullNameAttribute(): string
    {
        $first = ucfirst($this->lead_firstname ?? '');
        $last = ucfirst($this->lead_lastname ?? '');
        return trim("$first $last") ?: ($this->lead_name ?? 'Unnamed Lead');
    }

    public function getCarbonLastContactedAttribute(): string
    {
        return $this->lead_last_contacted
            ? Carbon::parse($this->lead_last_contacted)->diffForHumans()
            : '—';
    }

    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->lead_created
            ? Carbon::parse($this->lead_created)->format('d M Y, h:i A')
            : null;
    }

    public function getLangLeadStatusAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->lead_status ?? 'unknown'));
    }

    /** ─────────────── SCOPES ─────────────── */
    public function scopeActive($query)
    {
        return $query->where('lead_status', 'active');
    }

    public function scopeRecentlyContacted($query, int $days = 7)
    {
        return $query->where('lead_last_contacted', '>=', now()->subDays($days));
    }

    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('lead_creatorid', $userId);
    }

    /** ─────────────── HELPERS ─────────────── */
    public function getSummaryAttribute(): string
    {
        return sprintf(
            '%s (%s)',
            $this->lead_name ?? $this->full_name ?? 'Unnamed Lead',
            ucfirst($this->lead_status ?? 'unknown')
        );
    }
}
