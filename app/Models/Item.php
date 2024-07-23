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

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'item_id');
    }

    public function adjustStock($amount)
    {
        $newStock = $this->stok + $amount;

        if ($newStock < 0) {
            throw new \Exception('Stok tidak cukup.');
        }

        $this->stok = $newStock;
        $this->save();
    }
}
