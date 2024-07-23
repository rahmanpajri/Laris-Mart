<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json(Item::with('categories', 'transactions')->get());
    }

    public function show(Item $item)
    {
        return response()->json($item->load('categories', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_item' => 'required',
            'stok' => 'required|integer',
            'category_id' => 'required|integer|exists:category_items,id',
        ]);

        $item = Item::create($request->all());
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_item' => 'required',
            'stok' => 'required|integer',
            'category_id' => 'required|integer|exists:category_items,id',
        ]);

        $item = Item::findOrFail($id);
        $item->update($request->all());
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        if ($item->transactions()->count() > 0) {
            return response()->json(['error' => 'Item tidak bisa dihapus karena data terpakai pada Transaksi'], 400);
        }

        $item->delete();
        return response()->json(null, 204);
    }
}
