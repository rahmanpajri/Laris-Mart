@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Table Item</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Table Item</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="col-sm-12 justify-content-md-end pr-4 pt-4">
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createItemModal"><i class="fa fa-plus"></i> Tambah Item</button>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">Table Item</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Item</th>
                                        <th>Stok</th>
                                        <th>Jenis Barang Item</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item['nama_item'] }}</td>
                                            <td>{{ $item['stok'] }}</td>
                                            <td>{{ $item['categories']['category'] }}</td>
                                            <td>
                                                <!-- Actions for item (not transactions) -->
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item['id'] }}"><i class="fa fa-pen"></i> Edit</button>
                                                <form action="{{ route('items.destroy', $item['id']) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Yakin ingin menghapus item ini?')" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                        
                                        <!-- Edit Item Modal -->
                                        <div class="modal fade" id="editItemModal{{ $item['id'] }}" tabindex="-1" aria-labelledby="editItemModalLabel{{ $item['id'] }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editItemModalLabel{{ $item['id'] }}">Edit Item</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('items.update', $item['id']) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="nama_item{{ $item['id'] }}" class="form-label">Nama Item</label>
                                                                <input type="text" name="nama_item" class="form-control" id="nama_item{{ $item['id'] }}" value="{{ $item['nama_item'] }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="stok{{ $item['id'] }}" class="form-label">Stok</label>
                                                                <input type="number" name="stok" class="form-control" id="stok{{ $item['id'] }}" value="{{ $item['stok'] }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="category_id{{ $item['id'] }}" class="form-label">Jenis Barang</label>
                                                                <select name="category_id" class="form-control" id="category_id{{ $item['id'] }}" required>
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category['id'] }}" {{ $item['category_id'] == $category['id'] ? 'selected' : '' }}>{{ $category['category'] }}</option>
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
                                <tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>

<!-- Create Item Modal -->
<div class="modal fade" id="createItemModal" tabindex="-1" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createItemModalLabel">Tambah Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('items.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_item" class="form-label">Nama Item</label>
                        <input type="text" name="nama_item" class="form-control" id="nama_item" required>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" id="stok" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Jenis Barang</label>
                        <select name="category_id" class="form-control" id="category_id" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['category'] }}</option>
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
