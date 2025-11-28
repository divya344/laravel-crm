<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canned extends Model
{
    use HasFactory;

    protected $table = 'canned';
    protected $primaryKey = 'canned_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['canned_id'];
    const CREATED_AT = 'canned_created';
    const UPDATED_AT = 'canned_updated';

    /**
     * Relationship: Each canned response belongs to one category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'canned_categoryid', 'category_id');
    }
}
