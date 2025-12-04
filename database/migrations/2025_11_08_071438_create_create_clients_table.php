<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $primaryKey = 'client_id';   // ✔ Correct PK

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id', 'client_id');
    }
}
