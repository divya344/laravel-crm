<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * ProductTasksDependency Model
 *
 * Represents dependencies between product tasks,
 * defining which tasks must be completed before others.
 */
class ProductTasksDependency extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'product_tasks_dependencies';
    protected $primaryKey = 'product_task_dependency_id';
    protected $guarded = ['product_task_dependency_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'product_task_dependency_created';
    const UPDATED_AT = 'product_task_dependency_updated';

    protected $casts = [
        'product_task_dependency_created' => 'datetime',
        'product_task_dependency_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The task that depends on another task.
     */
    public function dependentTask()
    {
        return $this->belongsTo(ProductTask::class, 'dependent_task_id', 'product_task_id');
    }

    /**
     * The prerequisite task that must be completed first.
     */
    public function prerequisiteTask()
    {
        return $this->belongsTo(ProductTask::class, 'prerequisite_task_id', 'product_task_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->product_task_dependency_created
            ? Carbon::parse($this->product_task_dependency_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->product_task_dependency_updated
            ? Carbon::parse($this->product_task_dependency_updated)->format('d M Y, h:i A')
            : null;
    }
}
