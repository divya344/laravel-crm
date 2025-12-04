<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Expense extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'expenses';
    protected $primaryKey = 'expense_id';
    protected $guarded = ['expense_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'expense_created';
    const UPDATED_AT = 'expense_updated';

    protected $casts = [
        'expense_created' => 'datetime',
        'expense_updated' => 'datetime',
        'expense_date' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created the expense.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'expense_creatorid', 'id');
    }

    /**
     * The category this expense belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'expense_categoryid', 'category_id');
    }

    /**
     * The client associated with this expense.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'expense_clientid', 'client_id');
    }

    /**
     * The project associated with this expense.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'expense_projectid', 'project_id');
    }

    /**
     * Any attachments linked to this expense.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted expense date.
     */
    public function getFormattedDateAttribute(): ?string
    {
        return $this->expense_date ? $this->expense_date->format('d M Y') : null;
    }

    /**
     * Get formatted created timestamp.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->expense_created ? $this->expense_created->format('d M Y, h:i A') : null;
    }

    /**
     * Get formatted amount (with currency symbol).
     */
    public function getFormattedAmountAttribute(): string
    {
        $currency = config('app.currency_symbol', '₹');
        return $currency . ' ' . number_format($this->expense_amount ?? 0, 2);
    }

    /**
     * Get readable expense type (e.g., "Office Supplies" instead of "office_supplies").
     */
    public function getReadableTypeAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->expense_type ?? 'general'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: filter expenses by client.
     */
    public function scopeForClient($query, int $clientId)
    {
        return $query->where('expense_clientid', $clientId);
    }

    /**
     * Scope: filter expenses by project.
     */
    public function scopeForProject($query, int $projectId)
    {
        return $query->where('expense_projectid', $projectId);
    }

    /**
     * Scope: filter expenses by category.
     */
    public function scopeForCategory($query, int $categoryId)
    {
        return $query->where('expense_categoryid', $categoryId);
    }

    /**
     * Scope: filter expenses between two dates.
     */
    public function scopeBetweenDates($query, string $start, string $end)
    {
        return $query->whereBetween('expense_date', [Carbon::parse($start), Carbon::parse($end)]);
    }

    /**
     * Scope: only recent expenses (default 30 days).
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('expense_date', '>=', now()->subDays($days));
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Check if the expense is billable to a client.
     */
    public function getIsBillableAttribute(): bool
    {
        return (bool) $this->expense_billable;
    }

    /**
     * Status label (e.g. Paid, Pending, Unpaid).
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->expense_status ?? 'unpaid') {
            'paid' => "<span class='badge bg-success'>Paid</span>",
            'pending' => "<span class='badge bg-warning text-dark'>Pending</span>",
            'unpaid' => "<span class='badge bg-danger'>Unpaid</span>",
            default => "<span class='badge bg-secondary'>Unknown</span>",
        };
    }
}
