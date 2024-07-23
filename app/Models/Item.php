<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['nama_item', 'stok', 'category_id'] ;

    public function categories()
    {
        return $this->belongsTo(CategoryItem::class, 'category_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'item_id');
    }
}
