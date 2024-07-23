<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $apiUrl = 'http://127.0.0.1/Laris-Mart/public/api/transactions';

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $transactions = $response->json();
        $itemsResponse = Http::get('http://127.0.0.1/Laris-Mart/public/api/items');
        $items = $itemsResponse->json();

        return view('transactions.index', compact('transactions','items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'jumlah_terjual' => 'required|integer|min:1',
        ]);

        $response = Http::post($this->apiUrl, $request->all());

        if ($response->failed()) {
            return redirect()->back()->withErrors(['jumlah_terjual' => 'Stok tidak cukup.'])->withInput();
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_terjual' => 'required|integer|min:1',
        ]);

        $response = Http::put("{$this->apiUrl}/{$id}", $request->all());

        if ($response->failed()) {
            return redirect()->back()->withErrors(['jumlah_terjual' => 'Stok tidak cukup untuk transaksi ini.'])->withInput();
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiUrl}/{$id}");

        if ($response->successful()) {
            return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
        }

        return redirect()->back()->withErrors(['error' => 'Gagal menghapus barang']);
    }

    public function show(Request $request)
    {
        $response = Http::get("{$this->apiUrl}/show", $request->all());

        $data = $response->json();

        return view('transactions.compare-sales', [
            'maxSalesCategory' => $data['maxSalesCategory'],
            'minSalesCategory' => $data['minSalesCategory'],
            'allTransactions' => $data['allTransactions']
        ]);
    }
}
