<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password','role'];
    protected $hidden = ['password','remember_token'];

    public function isAdmin() { return $this->role === 'admin'; }
    public function isManager() { return $this->role === 'manager'; }
    public function isEmployee() { return $this->role === 'employee'; }
}
