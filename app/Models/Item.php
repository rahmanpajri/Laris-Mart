<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['nama_barang', 'stok', 'category_id'] ;

    public function categories()
    {
        return $this->belongsTo(CategoryItem::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
