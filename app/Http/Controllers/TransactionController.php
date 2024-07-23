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
        // Validasi input
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'jumlah_terjual' => 'required|integer|min:1',
        ]);

        // Ambil item dari database
        $item = Item::find($request->item_id);

        // Periksa apakah stok mencukupi
        if ($item->stok < $request->jumlah_terjual) {
            return redirect()->back()->withErrors(['jumlah_terjual' => 'Stok tidak cukup.'])->withInput();
        }

        // Simpan transaksi
        $transaction = new Transaction($request->all());
        $transaction->tanggal_transaksi = now();
        $transaction->save();

        // Kurangi stok
        $item->stok -= $request->jumlah_terjual;
        $item->save();

        return redirect()->route('transactions.index')->with('success', 'Barang berhasil ditambahkan.');
    }


    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'jumlah_terjual' => 'required|integer|min:1',
        ]);

        $item = $transaction->items;

        // Kembalikan stok sebelumnya
        $item->stok += $transaction->jumlah_terjual;

        if ($item->stok < $request->jumlah_terjual) {
            return redirect()->back()->withErrors(['jumlah_terjual' => 'Stok tidak cukup untuk transaksi ini.'])->withInput();
        }

        // Update jumlah terjual
        $transaction->update($request->all());

        // Kurangi stok baru
        $item->stok -= $request->jumlah_terjual;
        $item->save();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate.');
    }


    public function destroy(Transaction $transaction)
    {
        $item = $transaction->items;

        // Tambah stok item
        $item->stok += $transaction->jumlah_terjual;
        $item->save();

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
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