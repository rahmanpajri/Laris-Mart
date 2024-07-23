@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Table Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Table Category</li>
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
                            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createItemModal"><i class="fa fa-plus"></i> Tambah Category</button>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title">Table Category</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Category</th>
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
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $category->id }}">Edit</button>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Yakin ingin menghapus kategori ini?')" type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                        
                                        <!-- Edit Category Modal -->
                                        <div class="modal fade" id="editItemModal{{ $category->id }}" tabindex="-1" aria-labelledby="editItemModalLabel{{ $category->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editItemModalLabel{{ $category->id }}">Edit Category</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="category{{ $category->id }}" class="form-label">Nama Category</label>
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

<!-- Create Category Modal -->
<div class="modal fade" id="createItemModal" tabindex="-1" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createItemModalLabel">Tambah Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Nama Category</label>
                        <input type="text" name="category" class="form-control" id="category" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
