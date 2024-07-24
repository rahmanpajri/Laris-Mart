<?php

namespace Database\Seeders;

use App\Models\CategoryItem;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $jenis1 = CategoryItem::create(['category' => 'Konsumsi']);
        $jenis2 = CategoryItem::create(['category' => 'Pembersih']);

        $barang1 = Item::create(['nama_item' => 'Kopi', 'stok' => 75, 'category_id' => $jenis1->id]);
        $barang2 = Item::create(['nama_item' => 'Teh', 'stok' => 76, 'category_id' => $jenis1->id]);
        $barang3 = Item::create(['nama_item' => 'Pasta Gigi', 'stok' => 80, 'category_id' => $jenis2->id]);
        $barang4 = Item::create(['nama_item' => 'Sabun Mandi', 'stok' => 70, 'category_id' => $jenis2->id]);
        $barang5 = Item::create(['nama_item' => 'Sampo', 'stok' => 75, 'category_id' => $jenis2->id]);

        Transaction::create(['item_id' => $barang1->id, 'jumlah_terjual' => 10, 'tanggal_transaksi' => '2021-05-01']);
        Transaction::create(['item_id' => $barang2->id, 'jumlah_terjual' => 19, 'tanggal_transaksi' => '2021-05-05']);
        Transaction::create(['item_id' => $barang1->id, 'jumlah_terjual' => 15, 'tanggal_transaksi' => '2021-05-10']);
        Transaction::create(['item_id' => $barang3->id, 'jumlah_terjual' => 20, 'tanggal_transaksi' => '2021-05-11']);
        Transaction::create(['item_id' => $barang4->id, 'jumlah_terjual' => 30, 'tanggal_transaksi' => '2021-05-11']);
        Transaction::create(['item_id' => $barang5->id, 'jumlah_terjual' => 25, 'tanggal_transaksi' => '2021-05-12']);
        Transaction::create(['item_id' => $barang2->id, 'jumlah_terjual' => 5, 'tanggal_transaksi' => '2021-05-12']);
    }
}
