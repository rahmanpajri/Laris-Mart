<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryItem;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('items')->get();
        $items = Item::all();
        return view('transactions.index', compact('transactions','items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'jumlah_terjual' => 'required|integer',
        ]);
        $request->merge(['tanggal_transaksi' => now()]);

        Transaction::create($request->all());
        return redirect()->route('transactions.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'jumlah_terjual' => 'required|integer',
        ]);
        $request->merge(['tanggal_transaksi' => now()]);

        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Barang berhasil dihapus.');
    }
}
