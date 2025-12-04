<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $primaryKey = 'project_id';

    // Allow Laravel to manage created_at & updated_at
    public $timestamps = true;

    protected $fillable = [
        'project_title',
        'project_description',
        'project_clientid',
        'project_start_date',
        'project_end_date',
        'project_status'
    ];

    /**
     * Client Relationship
     * project.project_clientid → clients.client_id
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'project_clientid', 'client_id');
    }

    /**
     * Tasks Relationship
     * project.project_id → tasks.task_projectid
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_projectid', 'project_id');
    }

    /**
     * Invoices Relationship
     * project.project_id → invoices.invoice_projectid
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'invoice_projectid', 'project_id');
    }
}
