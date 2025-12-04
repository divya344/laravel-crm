<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';                // table name

    protected $primaryKey = 'client_id';        // ✔ your actual PK (change if different)

    public $incrementing = true;                // ✔ true if auto-increment
    protected $keyType = 'int';                 // ✔ integer primary key

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'client_company',
        'client_address'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id', 'client_id');
    }
}
