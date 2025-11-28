<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryUser extends Model
{
    use HasFactory;

    protected $table = 'category_users';
    protected $primaryKey = 'categoryuser_id';
    protected $guarded = ['categoryuser_id'];
    protected $dateFormat = 'Y-m-d H:i:s';
    const CREATED_AT = 'categoryuser_created';
    const UPDATED_AT = 'categoryuser_updated';

    /**
     * Relationship: This entry belongs to a Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryuser_categoryid', 'category_id');
    }

    /**
     * Relationship: This entry belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'categoryuser_userid', 'id');
    }
}
