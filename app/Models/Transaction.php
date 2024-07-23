<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'jumlah_terjual', 'tanggal_transaksi'];

    public function barang()
    {
        return $this->belongsTo(Items::class);
    }
}
