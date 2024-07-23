@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Barang</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createItemModal">Tambah Barang</button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            @foreach($items as $item)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{ $item->nama_item }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->categories->category }}</td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}">Edit</button>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Item Modal -->
                <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1" aria-labelledby="editItemModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editItemModalLabel{{ $item->id }}">Edit Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('items.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="nama_item{{ $item->id }}" class="form-label">Nama Barang</label>
                                        <input type="text" name="nama_item" class="form-control" id="nama_item{{ $item->id }}" value="{{ $item->nama_item }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stok{{ $item->id }}" class="form-label">Stok</label>
                                        <input type="number" name="stok" class="form-control" id="stok{{ $item->id }}" value="{{ $item->stok }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category_id{{ $item->id }}" class="form-label">Kategori</label>
                                        <select name="category_id" class="form-control" id="category_id{{ $item->id }}" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Create Item Modal -->
<div class="modal fade" id="createItemModal" tabindex="-1" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createItemModalLabel">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('items.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_item" class="form-label">Nama Barang</label>
                        <input type="text" name="nama_item" class="form-control" id="nama_item" required>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" id="stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select name="category_id" class="form-control" id="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
