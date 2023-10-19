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
                            <form id="form_siswa_hadist">
                                <div class="form-group col-md-12">
                                    <label class="text-lightdark">
                                        NIS
                                    </label>
                                    <div class="input-group">
                                        <input id="nisn" name="nisn" value="{{ $siswaBidangStudi->siswa->nisn }}"
                                            class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="name" class="text-lightdark">
                                        Nama Siswa
                                    </label>
                                    <div class="input-group">
                                        <input id="nama_siswa" name="nama_siswa"
                                            value="{{ $siswaBidangStudi->siswa->nama_siswa }}" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="nilai_uh_1_id" class="text-lightdark">
                                        Nilai UH 1
                                    </label>
                                    <div class="input-group">
                                        <input id="nilai_uh_1_id" name="nilai_uh_1_id"
                                            value="{{ old('nilai_uh_1_id', $siswaBidangStudi->nilai_uh_1_id) }}"
                                            class="form-control @error('nilai_uh_1_id') is-invalid @enderror" disabled>
                                        @error('nilai_uh_1_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="nilai_uh_2_id" class="text-lightdark">
                                        Nilai UH 2
                                    </label>
                                    <div class="input-group">
                                        <input id="nilai_uh_2_id" name="nilai_uh_2_id"
                                            value="{{ old('nilai_uh_2_id', $siswaBidangStudi->nilai_uh_2_id) }}"
                                            class="form-control @error('nilai_uh_2_id') is-invalid @enderror" disabled>
                                        @error('nilai_uh_2_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="nilai_uh_3_id" class="text-lightdark">
                                        Nilai UH 3
                                    </label>
                                    <div class="input-group">
                                        <input id="nilai_uh_3_id" name="nilai_uh_3_id"
                                            value="{{ old('nilai_uh_3_id', $siswaBidangStudi->nilai_uh_3_id) }}"
                                            class="form-control @error('nilai_uh_3_id') is-invalid @enderror" disabled>
                                        @error('nilai_uh_3_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="nilai_uh_4_id" class="text-lightdark">
                                        Nilai UH 4
                                    </label>
                                    <div class="input-group">
                                        <input id="nilai_uh_4_id" name="nilai_uh_4_id"
                                            value="{{ old('nilai_uh_4_id', $siswaBidangStudi->nilai_uh_4_id) }}"
                                            class="form-control @error('nilai_uh_4_id') is-invalid @enderror" disabled>
                                        @error('nilai_uh_4_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="nilai_tugas_1_id" class="text-lightdark">
                                        Nilai Tugas 1
                                    </label>
                                    <div class="input-group">
                                        <input id="nilai_tugas_1_id" name="nilai_tugas_1_id"
                                            value="{{ old('nilai_tugas_1_id', $siswaBidangStudi->nilai_tugas_1_id) }}"
                                            class="form-control @error('nilai_tugas_1_id') is-invalid @enderror" disabled>
                                        @error('nilai_tugas_1_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="nilai_tugas_2_id" class="text-lightdark">
                                        Nilai Tugas 2
                                    </label>
                                    <div class="input-group">
                                        <input id="nilai_tugas_2_id" name="nilai_tugas_2_id"
                                            value="{{ old('nilai_tugas_2_id', $siswaBidangStudi->nilai_tugas_2_id) }}"
                                            class="form-control @error('nilai_tugas_2_id') is-invalid @enderror" disabled>
                                        @error('nilai_tugas_2_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="nilai_uts_id" class="text-lightdark">
                                        Nilai UTS
                                    </label>
                                    <div class="input-group">
                                        <input id="nilai_uts_id" name="nilai_uts_id"
                                            value="{{ old('nilai_uts_id', $siswaBidangStudi->nilai_uts_id) }}"
                                            class="form-control @error('nilai_uts_id') is-invalid @enderror" disabled>
                                        @error('nilai_uts_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="nilai_pas_id" class="text-lightdark">
                                        Nilai UAS
                                    </label>
                                    <div class="input-group">
                                        <input id="nilai_pas_id" name="nilai_pas_id"
                                            value="{{ old('nilai_pas_id', $siswaBidangStudi->nilai_pas_id) }}"
                                            class="form-control @error('nilai_pas_id') is-invalid @enderror" disabled>
                                        @error('nilai_pas_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <x-adminlte-button id="edit" class="btn bg-purple col-12 edit" label="Edit Data"
                                    icon="fas fa fa-fw fa-edit" />
                                <x-adminlte-button id="simpan" class="btn bg-purple col-12 simpan" type="submit"
                                    label="Simpan Data" icon="fas fa fa-fw fa-save" />
                                <x-adminlte-button id="batal" class="btn bg-red col-12 cancel" label="Batal"
                                    icon="fas fa fa-fw fa-times" />
                            </form>
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

            $('#edit').show();
            $('#simpan').hide();
            $('#batal').hide();

            $('#form_siswa_hadist').on('submit', function(e) {
                e.preventDefault();
                $('#edit').show();
                $('#simpan').hide();
                $('#batal').hide();
                $('input').prop('disabled', true);
                var nilai_uh_1_id = $('#nilai_uh_1_id').val();
                var nilai_uh_2_id = $('#nilai_uh_2_id').val();
                var nilai_uh_3_id = $('#nilai_uh_3_id').val();
                var nilai_uh_4_id = $('#nilai_uh_4_id').val();
                var nilai_tugas_1_id = $('#nilai_tugas_1_id').val();
                var nilai_tugas_2_id = $('#nilai_tugas_2_id').val();
                var nilai_uts_id = $('#nilai_uts_id').val();
                var nilai_pas_id = $('#nilai_pas_id').val();

                $.ajax({
                    url: "{{ route('siswaBidangStudi.update', $siswaBidangStudi->id) }}",
                    type: "PATCH",
                    data: {
                        nilai_uh_1_id: nilai_uh_1_id,
                        nilai_uh_2_id: nilai_uh_2_id,
                        nilai_uh_3_id: nilai_uh_3_id,
                        nilai_uh_4_id: nilai_uh_4_id,
                        nilai_tugas_1_id: nilai_tugas_1_id,
                        nilai_tugas_2_id: nilai_tugas_2_id,
                        nilai_uts_id: nilai_uts_id,
                        nilai_pas_id: nilai_pas_id,
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil diupdate',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(err) {
                        if (err.status == 422) {
                            $('#form_siswa_hadist').find('.is-invalid').removeClass(
                                'is-invalid');
                            $('#form_siswa_hadist').find('.error').remove();

                            //send error to adminlte form
                            $.each(err.responseJSON.error, function(i, error) {
                                var el = $(document).find('[name="' + i + '"]');
                                if (el.hasClass('is-invalid')) {
                                    el.removeClass('is-invalid');
                                    el.next().remove();
                                }
                                el.addClass('is-invalid');
                                el.after($('<span class="error invalid-feedback">' +
                                    error[0] + '</span>'));
                            });
                            console.log(err.responseJSON.error);
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Mohon isi data dengan benar!',
                                icon: 'error',
                                iconColor: '#fff',
                                toast: true,
                                background: '#f8bb86',
                                position: 'top-center',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        }
                    }
                });
            });

            $('#edit').click(function() {
                $('#edit').hide();
                $('#simpan').show();
                $('#batal').show();
                $('input:not(#nisn, #nama_siswa)').prop('disabled', false);

            });

            $('#batal').click(function() {
                $('#edit').show();
                $('#simpan').hide();
                $('#batal').hide();
                $('input').prop('disabled', true);
            });
        });
    </script>
@stop