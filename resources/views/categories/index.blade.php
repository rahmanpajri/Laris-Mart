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
                    <h1>Table Jenis Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Table Jenis Barang</li>
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
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createItemModal"><i class="fa fa-plus"></i> Tambah Jenis Barang</button>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">Table Jenis Barang</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Jenis Barang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $category->category }}</td>
                                            <td>
                                                <!-- Actions for item (not transactions) -->
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $category->id }}"><i class="fa fa-pen"></i> Edit</button>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Yakin ingin menghapus kategori ini?')" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                        
                                        <!-- Edit Jenis Barang Modal -->
                                        <div class="modal fade" id="editItemModal{{ $category->id }}" tabindex="-1" aria-labelledby="editItemModalLabel{{ $category->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editItemModalLabel{{ $category->id }}">Edit Jenis Barang</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="category{{ $category->id }}" class="form-label">Jenis Barang</label>
                                                                <input type="text" name="category" class="form-control" id="category{{ $category->id }}" value="{{ $category->category }}" required>
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

<!-- Create Jenis Barang Modal -->
<div class="modal fade" id="createItemModal" tabindex="-1" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createItemModalLabel">Tambah Jenis Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Jenis Barang</label>
                        <input type="text" name="category" class="form-control" id="category" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
