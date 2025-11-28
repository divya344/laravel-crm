<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['number','project_id','amount','status','issue_date','due_date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
