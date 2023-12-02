@extends('adminlte::page')

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
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card card-dark">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Detail Siswa </h3>
                    <div class="card-tools">
                        <!-- button to edit page-->

                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-12">

                            <div class="form-group col-md-12">
                                <label class="text-lightdark">
                                    ID Siswa
                                </label>
                                <div class="input-group">
                                    <input id="id" name="id" value="{{ $siswa->id }}" class="form-control"
                                        disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="name" class="text-lightdark">
                                    Nama Siswa
                                </label>
                                <div class="input-group">
                                    <input id="nama_siswa" name="nama_siswa" value="{{ $siswa->nama_siswa }}"
                                        class="form-control" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="nip" class="text-lightdark">
                                    NISN
                                </label>
                                <div class="input-group">
                                    <input id="nisn" name="nisn" value="{{ $siswa->nisn }}" class="form-control"
                                        disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="orangtua_wali" class="text-lightdark">
                                    Orang Tua/Wali
                                </label>
                                <div class="input-group">
                                    <input id="orangtua_wali" name="orangtua_wali" value="{{ $siswa->orangtua_wali }}"
                                        class="form-control" disabled>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="kelas" class="text-lightdark">
                                    Kelas
                                </label>
                                <select id="kelas" name="kelas" disabled
                                    class="form-control select2bs4 @error('kelas') is-invalid @enderror">
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}"
                                            {{ $siswa->sub_kelas_id == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('kelas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <x-adminlte-input name="created_at" type="text" value="{{ $siswa->created_at }}"
                                label="Waktu Ditambahkan" fgroup-class="col-md-12" disabled>

                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-purple">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>

                            </x-adminlte-input>

                            <x-adminlte-input name="updated_at" type="text" value="{{ $siswa->updated_at }}"
                                label="Waktu Diperbaharui" fgroup-class="col-md-12" disabled>

                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-purple">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </x-slot>

                            </x-adminlte-input>

                            <x-adminlte-button id="edit" class="btn bg-purple col-12 edit" type="submit"
                                label="Edit Data" icon="fas fa fa-fw fa-edit" />
                            <x-adminlte-button id="simpan" class="btn bg-purple col-12 simpan" type="submit"
                                label="Simpan Data" icon="fas fa fa-fw fa-save" hidden />
                            <x-adminlte-button id="batal" class="btn bg-red col-12 cancel" type="submit"
                                label="Batal" icon="fas fa fa-fw fa-times" hidden />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

    <script>
        $(document).ready(function() {
            //set csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
            $('#edit').click(function() {
                $('#nama_siswa').prop('disabled', false);
                $('#nisn').prop('disabled', false);
                $('#orangtua_wali').prop('disabled', false);
                $('#kelas').prop('disabled', false);
                $('#simpan').prop('hidden', false);
                $('#edit').prop('hidden', true);
                $('#batal').prop('hidden', false);
            });

            $('#batal').click(function() {
                $('#nama_siswa').prop('disabled', true);
                $('#nisn').prop('disabled', true);
                $('#orangtua_wali').prop('disabled', true);
                $('#kelas').prop('disabled', true);
                $('#simpan').prop('hidden', true);
                $('#edit').prop('hidden', false);
                $('#batal').prop('hidden', true);
            });

            $('#simpan').click(function() {
                //ajax update data
                $.ajax({
                    url: "{{ route('dataSiswa.update', $siswa->id) }}",
                    type: 'PUT',
                    data: {
                        nama_siswa: $('#nama_siswa').val(),
                        nisn: $('#nisn').val(),
                        orangtua_wali: $('#orangtua_wali').val(),
                        kelas: $('#kelas').val(),
                    },
                    success: function(data) {
                        $('#nama_siswa').prop('disabled', true);
                        $('#nisn').prop('disabled', true);
                        $('#orangtua_wali').prop('disabled', true);
                        $('#kelas').prop('disabled', true);
                        $('#simpan').prop('hidden', true);
                        $('#edit').prop('hidden', false);
                        $('#batal').prop('hidden', true);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil diperbaharui',
                        });
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data gagal diperbaharui',
                        });
                    }
                });

                // set updated_at with now
                var now = new Date();
                var date = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();
                var time = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
                var dateTime = date + ' ' + time;
                // var dateTime = now();
                $('#updated_at').val(dateTime);

            });

        });
    </script>
@stop
