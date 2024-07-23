<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryItem;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('categories', 'transactions')->get();
        $categories = CategoryItem::all();
        return view('items.index', compact('items', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required',
            'stok' => 'required|integer',
            'category_id' => 'required|integer|exists:category_items,id',
        ]);

        Item::create($request->all());
        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'nama_item' => 'required',
            'stok' => 'required|integer',
            'category_id' => 'required|integer|exists:category_items,id',
        ]);

        $item->update($request->all());
        return redirect()->route('items.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(Item $item)
    {
        if ($item->transactions()->count() > 0) {
            return redirect()->back()->withErrors(['item' => 'Item tidak bisa dihapus karena data terpakai pada Transaksi'])->withInput();
        }

        $item->delete();
        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }
}
