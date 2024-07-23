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
                    <h1>Table Transaksi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Table Transaksi</li>
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
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createItemModal"><i class="fa fa-plus"></i> Tambah Transaksi</button>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">Table Transaksi</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Item</th>
                                        <th>Jumlah Terjual</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $transaction->items->nama_item }}</td>
                                            <td>{{ $transaction->jumlah_terjual }}</td>
                                            <td>{{ $transaction->tanggal_transaksi }}</td>
                                            <td>
                                                <!-- Actions for item (not transactions) -->
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $transaction->id }}"><i class="fa fa-pen"></i> Edit</button>
                                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Yakin ingin menghapus transaksi ini?')" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                        
                                        <!-- Edit Item Modal -->
                                        <div class="modal fade" id="editItemModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="editItemModalLabel{{ $transaction->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editItemModalLabel{{ $transaction->id }}">Edit Item</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="jumlah_terjual{{ $transaction->id }}" class="form-label">Jumlah Terjual</label>
                                                                <input type="number" name="jumlah_terjual" class="form-control" id="jumlah_terjual{{ $transaction->id }}" value="{{ $transaction->jumlah_terjual }}" required>
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
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_item" class="form-label">Nama Item</label>
                        <select name="item_id" class="form-control" id="item_id" required>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_terjual" class="form-label">Jumlah Terjual</label>
                        <input type="number" name="jumlah_terjual" class="form-control" id="jumlah_terjual" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
