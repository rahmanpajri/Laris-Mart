<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

    protected $fillable = ['category'] ;
    
    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}
