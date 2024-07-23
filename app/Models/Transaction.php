<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'jumlah_terjual', 'tanggal_transaksi'];

    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
