<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['category_id'];
    const CREATED_AT = 'category_created';
    const UPDATED_AT = 'category_updated';

    /**
     * Category creator (User who created it)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'category_creatorid', 'id');
    }

    /** ==== RELATIONSHIPS ==== */

    public function projects()
    {
        return $this->hasMany(Project::class, 'project_categoryid', 'category_id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'lead_categoryid', 'category_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'client_categoryid', 'category_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'bill_categoryid', 'category_id');
    }

    public function estimates()
    {
        return $this->hasMany(Estimate::class, 'bill_categoryid', 'category_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'doc_categoryid', 'category_id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'doc_categoryid', 'category_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_categoryid', 'category_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticket_categoryid', 'category_id');
    }

    public function articles()
    {
        return $this->hasMany(Knowledgebase::class, 'knowledgebase_categoryid', 'category_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'category_users', 'categoryuser_categoryid', 'categoryuser_userid');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'item_categoryid', 'category_id');
    }

    public function canned()
    {
        return $this->hasMany(Canned::class, 'canned_categoryid', 'category_id');
    }

    /**
     * Accessor: Count how many canned responses this category has
     */
    public function getCountCannedAttribute(): int
    {
        return $this->canned()->count();
    }
}
