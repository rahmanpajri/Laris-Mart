<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('items')->get();
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'jumlah_terjual' => 'required|integer|min:1',
        ]);

        $item = Item::find($request->item_id);

        if ($item->stok < $request->jumlah_terjual) {
            return response()->json(['error' => 'Stok tidak cukup.'], 400);
        }

        $transaction = new Transaction($request->all());
        $transaction->tanggal_transaksi = now();
        $transaction->save();

        $item->stok -= $request->jumlah_terjual;
        $item->save();

        return response()->json(['success' => 'Transaksi berhasil ditambahkan.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_terjual' => 'required|integer|min:1',
        ]);

        $transaction = Transaction::findOrFail($id);
        $item = $transaction->items;

        $item->stok += $transaction->jumlah_terjual;

        if ($item->stok < $request->jumlah_terjual) {
            return response()->json(['error' => 'Stok tidak cukup untuk transaksi ini.'], 400);
        }

        $transaction->update($request->all());
        $item->stok -= $request->jumlah_terjual;
        $item->save();

        return response()->json(['success' => 'Transaksi berhasil diupdate.']);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $item = $transaction->items;

        $item->stok += $transaction->jumlah_terjual;
        $item->save();

        $transaction->delete();

        return response()->json(['success' => 'Transaksi berhasil dihapus.']);
    }

    public function show(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
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
    
        $allTransactions = Transaction::select('transactions.*', 'items.nama_item', 'category_items.category as category_name')
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
    
        return response()->json([
            'maxSalesCategory' => $maxSalesCategory,
            'minSalesCategory' => $minSalesCategory,
            'allTransactions' => $allTransactions
        ]);
    }    
}
