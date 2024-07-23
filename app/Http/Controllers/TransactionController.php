<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryItem;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;

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

        $item = Item::find($request->item_id);
        if ($item) {
            $item->stok -= $request->jumlah_terjual;
            $item->save();
        }

        Transaction::create($request->all());
        return redirect()->route('transactions.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'jumlah_terjual' => 'required|integer',
        ]);
        $request->merge(['tanggal_transaksi' => now()]);

        $item = $transaction->items;
        $oldQuantity = $transaction->jumlah_terjual;
        $newQuantity = $request->jumlah_terjual;

        // Update stok
        $item->stok += $oldQuantity; // Kembalikan stok lama
        $item->stok -= $newQuantity; // Kurangi stok baru
        $item->save();

        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Transaction $transaction)
    {
        $item = $transaction->items;
        $item->stok += $transaction->jumlah_terjual; // Tambah stok yang dihapus
        $item->save();

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function show(Request $request)
    {
        // Get the date range from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Get the categories with the highest and lowest sales
        $maxSalesCategory = Transaction::selectRaw('category_items.category, sum(transactions.jumlah_terjual) as total_sales')
            ->join('items', 'transactions.item_id', '=', 'items.id')
            ->join('category_items', 'items.category_id', '=', 'category_items.id')
            ->when($startDate, function($query, $startDate) {
                return $query->whereDate('transactions.tanggal_transaksi', '>=', $startDate);
            })
            ->when($endDate, function($query, $endDate) {
                return $query->whereDate('transactions.tanggal_transaksi', '<=', $endDate);
            })
            ->groupBy('category_items.category')
            ->orderBy('total_sales', 'desc')
            ->first();

        $minSalesCategory = Transaction::selectRaw('category_items.category, sum(transactions.jumlah_terjual) as total_sales')
            ->join('items', 'transactions.item_id', '=', 'items.id')
            ->join('category_items', 'items.category_id', '=', 'category_items.id')
            ->when($startDate, function($query, $startDate) {
                return $query->whereDate('transactions.tanggal_transaksi', '>=', $startDate);
            })
            ->when($endDate, function($query, $endDate) {
                return $query->whereDate('transactions.tanggal_transaksi', '<=', $endDate);
            })
            ->groupBy('category_items.category')
            ->orderBy('total_sales', 'asc')
            ->first();

        $allTransactions = Transaction::select('transactions.*', 'category_items.category as category_name')
            ->join('items', 'transactions.item_id', '=', 'items.id')
            ->join('category_items', 'items.category_id', '=', 'category_items.id')
            ->when($startDate, function($query, $startDate) {
                return $query->whereDate('transactions.tanggal_transaksi', '>=', $startDate);
            })
            ->when($endDate, function($query, $endDate) {
                return $query->whereDate('transactions.tanggal_transaksi', '<=', $endDate);
            })
            ->orderBy('transactions.jumlah_terjual', 'desc')
            ->get();

        return view('transactions.compare-sales', [
            'maxSalesCategory' => $maxSalesCategory,
            'minSalesCategory' => $minSalesCategory,
            'allTransactions' => $allTransactions
        ]);
    }
}