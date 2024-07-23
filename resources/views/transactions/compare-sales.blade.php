<!-- resources/views/transactions/compare-sales.blade.php -->
@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Perbandingan Penjualan Kategori Barang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Perbandingan Penjualan Kategori Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3>{{ $maxSalesCategory['total_sales'] + $minSalesCategory['total_sales'] }}</h3>
                        <p>Total Penjualan</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                      </div>
                      <a href="#" class="small-box-footer">Total Penjualan</a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>{{ $maxSalesCategory['total_sales'] }}</h3>
                        <p>{{ $maxSalesCategory['category'] }}</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                      </div>
                      <a href="#" class="small-box-footer">Penjualan Terbanyak</a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small card -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>{{ $minSalesCategory['total_sales'] }}</h3>
                        <p>{{ $minSalesCategory['category'] }}</p>
                      </div>
                      <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                      </div>
                      <a href="#" class="small-box-footer">Penjualan Terendah</a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Semua Transaksi</h3>
                </div>
                <div class="card-body">
                    <!-- Date Range Filter Form -->
                    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="start_date">Start Date:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="end_date">End Date:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="form-group col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah Terjual</th>
                                <th>Kategori</th>
                                <th>Tanggal Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->items->nama_item }}</td>
                                    <td>{{ $transaction->jumlah_terjual }}</td>
                                    <td>{{ $transaction->category_name }}</td>
                                    <td>{{ $transaction->tanggal_transaksi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
