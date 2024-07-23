<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{
    protected $apiUrl = 'http://127.0.0.1/Laris-Mart/public/api/items'; // Ganti dengan URL API Anda

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $items = $response->json();
        $categories = Http::get('http://127.0.0.1/Laris-Mart/public/api/categories')->json(); // Jika Anda juga memerlukan kategori

        return view('items.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required',
            'stok' => 'required|integer',
            'category_id' => 'required|integer|exists:category_items,id',
        ]);

        $response = Http::post($this->apiUrl, $request->all());

        if ($response->successful()) {
            return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
        }

        return redirect()->back()->withErrors(['error' => 'Gagal menambahkan barang'])->withInput();
    }

    public function update(Request $request, $id)
    {
        $response = Http::put("{$this->apiUrl}/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('items.index')->with('success', 'Barang berhasil diupdate.');
        }

        return redirect()->back()->withErrors(['error' => 'Gagal mengupdate barang'])->withInput();
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiUrl}/{$id}");

        if ($response->successful()) {
            return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
        }

        return redirect()->back()->withErrors(['error' => 'Gagal menghapus barang']);
    }
}
