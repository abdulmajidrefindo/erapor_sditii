@extends('adminlte::page')

@section('title', 'Data Tahun Ajaran')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Data Tahun Ajaran</h1>
    </div>
    <div class="col-sm-6">
        {{-- <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('merek') }}
        </ol> --}}
    </div>
</div>
@stop

@section('content')
<!-- /.card -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | DataTables</title>
  
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>
<body>
    <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Siswa</h3>
        </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Tahun</th>
                        <th>Semester</th>
                    </tr>
                </thead>
    @foreach ($periode as $p)
    <tr>
        <td>{{ $p->id }}</p>
        <td>{{ $p->tahun_ajaran }}</p>
        <td>{{ $p->semester }}</td>
    </tr>
    @endforeach
    <tbody>
    </tfoot>
  </table>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</body>
@stop