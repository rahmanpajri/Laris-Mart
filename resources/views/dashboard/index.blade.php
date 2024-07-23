@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col">
                    <div class="col">
                        <!-- Info Boxes Style 2 -->
                        <div class="info-box mb-3 bg-warning">
                            <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Meja</span>
                                <span class="info-box-number">10</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="far fa-heart"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Item</span>
                                <span class="info-box-number">5</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                        <div class="info-box mb-3 bg-secondary">
                            <span class="info-box-icon"><i class="far fa-file"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Laporan</span>
                                <span class="info-box-number">20</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
@endsection
