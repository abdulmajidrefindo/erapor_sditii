@extends('adminlte::page')

{{-- @section('title', 'Data User') --}}

@section('content_header')
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="vendor/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="vendor/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="vendor/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="vendor/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="vendor/adminlte/dist/css/adminlte.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="vendor/select2/css/select2.min.css">
<link rel="stylesheet" href="vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@stop
@section('content')
<div class="card card-secondary card-tabs" id="app">
  <div class="card-header p-0 pt-0">
    {{-- tab control --}}
    <ul class="nav nav-tabs" id="kategori-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="controller-tab-user-table" data-toggle="pill" href="#content-tab-user-table" role="tab" aria-controls="content-tab-user-table" aria-selected="true">
          <i class="fas fa-xs fa-table fa-fw"></i>
          Daftar User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="controller-tab-user-add" data-toggle="pill" href="#content-tab-user-add" role="tab" aria-controls="content-tab-user-add" aria-selected="false">
            <i class="fas fa-xs fa-plus fa-fw"></i>
            Tambah User</a>
          </li>
        </ul>
      </div>
      {{-- /tab control --}}
      <div class="card-body">
        {{-- tab daftar --}}
        <div class="tab-content" id="userTabContent">
          <div class="tab-pane active show" id="content-tab-user-table" role="tabpanel"
          aria-labelledby="controller-tab-user-table">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Peran</th>
              </tr>
            </thead>
            @forelse ($data as $u)
            <tr>
              <td>{{ $u->user->name }}</td>
              <td>{{ $u->user->user_name }}</td>
              <td>{{ $u->role->role }}</td>
            </tr>
            @empty
            <td>-</td> 
            @endforelse
          </table>
        </div>
        {{-- /tab daftar --}}
        {{-- tab tambah --}}
        <div class="tab-pane fade" id="content-tab-user-add" role="tabpanel" aria-labelledby="controller-tab-user-add">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="bs-stepper-content">
                  <form action="{{route('dataUser.store')}}" method="post" id="form_tambah_user">
                    @csrf
                    <div class="form-group">
                      <label for="name" class="form-label">Nama</label>
                      <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="-masukkan nama pengguna-">
                      {{-- @error('name')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror --}}
                    </div>
                    <div class="form-group">
                      <label for="email" class="form-label">E-mail</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="-masukkan nama pengguna-">
                      {{-- @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror --}}
                    </div>
                    <div class="form-group">
                      <label for="user_name" class="form-label">Username</label>
                      <input type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" placeholder="-masukkan username pengguna-">
                      {{-- @error('user_name')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror --}}
                    </div>
                    <div class="form-group">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="-masukkan password pengguna-">
                      {{-- @error('password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror --}}
                    </div>
                    <div class="form-group">
                      <label for="role_id" class="form-label">Peran</label>
                      <select class="select2 form-control @error('role_id') is-invalid @enderror" multiple="multiple" name="role_id" data-placeholder="-pilih peran pengguna-" style="width: 100%;">
                        @foreach ($role as $r)
                        <option value="{{ $r->id }}">{{ $r->role }}</option>
                        @endforeach
                      </select>
                      {{-- @error('role_id')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                      @enderror --}}
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- /tab tambah --}}
      </div>
    </div>
  </div>
</div>
@stop
@section('head_js')
@push('head')
<!-- jQuery -->
<script type="text/javascript" src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Select2 -->
<script type="text/javascript" src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script type="text/javascript" src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/pdfmake/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="vendor/pdfmake/vfs_fonts.js"></script>
<!-- AdminLTE App -->
<script src="vendor/adminlte/dist/js/adminlte.min.js"></script>

@endpush
@stop
@section('js')
<script type="text/javascript">
  $(document).ready(function () {
    //DataTable
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      "buttons": ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    //Initialize Select2 Elements
    $('.select2').select2({
      placeholder:"pilih dulu"
    });
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
  });
</script>

{{-- vue tambah user --}}
<script type="module">
import { createApp, ref } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

createApp({
  data() {
    return {
      formData: {
        name: '',
        email: '',
        user_name: '',
        password: '',
        role_id: ''
      }
    };
  },
  methods: {
    tambahUser() {
      axios
        .post("{{ route('dataUser.store') }}", this.formData)
        .then(response => {
          if (response.data.success !== null) {
            this.$refs.exampleTable.refresh();
            this.resetForm();
            this.showSuccessAlert();
          } else {
            this.showErrorAlert("Data Gagal Disimpan");
          }
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.handleValidationError(error.response.data.errors);
            this.showErrorAlert("Mohon isi data dengan benar!");
          }
        });
    },
    resetForm() {
      this.formData = {
        name: '',
        email: '',
        user_name: '',
        password: '',
        role_id: ''
      };
    },
    showSuccessAlert() {
      this.$swal({
        title: 'Berhasil!',
        text: 'Data Berhasil Ditambahkan!',
        icon: 'success',
        iconColor: '#fff',
        color: '#fff',
        background: '#8D72E1',
        position: 'center',
        showCancelButton: true,
        confirmButtonColor: '#541690',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Kembali Ke Daftar User',
        cancelButtonText: 'Tutup',
      }).then(result => {
        if (result.isConfirmed) {
          this.$refs.exampleTable.refresh();
          this.$refs.contentTabUserTable.click();
          setTimeout(() => {
            this.resetForm();
          }, 1000);
        } else {
          this.$refs.exampleTable.refresh();
          this.resetForm();
        }
      });
    },
    showErrorAlert(message) {
      this.$swal({
        title: 'Gagal!',
        text: message,
        icon: 'error',
        iconColor: '#fff',
        toast: true,
        background: '#f8bb86',
        position: 'center-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      });
    },
    handleValidationError(errors) {
      Object.keys(errors).forEach(field => {
        const el = document.querySelector(`[name="${field}"]`);
        if (el) {
          el.classList.remove('is-invalid');
          el.insertAdjacentHTML('afterend', `<span class="error invalid-feedback">${errors[field][0]}</span>`);
        }
      });
    },
  },
}).mount('#app')
</script>
@stop