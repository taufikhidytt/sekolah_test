<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap4.min.css')?>">

</head>
<body>
    <div class="container">
        <h2>Data Siswa</h2>
        <div class="pull-left">
            <button type="button" class="btn btn-primary" onclick="add()" id="tomboltambah">
                Tambah Data
            </button>
        </div>
        <div class="text-right mb-2">
            <a href="<?= base_url('sekolah')?>" class="btn btn-success btn-sm">
                Daftar Sekolah
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped text-center" id="mytable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Alamat Siswa</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Sekolah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body form">
            <form action="#" id="formData">
                <div class="form-group">
                    <input type="hidden" id="id_siswa" name="id_siswa" value="">
                    <label for="nama_siswa">Nama Siswa</label>
                    <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" placeholder="Masukan Nama Siswa" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="alamat_siswa">Alamat Siswa</label>
                    <input type="text" class="form-control" id="alamat_siswa" name="alamat_siswa" placeholder="Masukan Alamat Siswa" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukan Tempat Lahir Anda" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Masukan Tanggal Lahir">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                        <option value="">--Pilih--</option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="id_sekolah">Sekolah</label>
                    <select name="id_sekolah" id="id_sekolah" class="form-control"></select>
                    <div class="invalid-feedback"></div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">Simpan</button>
        </div>
        </div>
    </div>
    </div>

    <script src="<?= base_url('assets/js/jquery-3.5.1.slim.min.js')?>" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    
    <script src="<?= base_url('assets/js/jquery-3.5.1.js')?>"></script>

    <script src="<?= base_url('assets/js/sweetalert2@11.js')?>"></script>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js')?>" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <script src="<?= base_url('assets/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js')?>"></script>

    <script>
        var saveData;
        var modal = $('#modalData');
        var tableData = $('#mytable');
        var formData = $('#formData');
        var modalTitle = $('#modalTitle');
        var btnSave = $('#btnSave');

        $(document).ready(function(){
            form_load_sekolah();
            tableData.DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?= base_url('siswa/getData')?>",
                    "type": "POST",
                },
                "columnDefs": [{
                    "target": [-1],
                    "orderable": false
                }]
            })
        });

        function form_load_sekolah(){
            $.ajax({
                url: "<?php echo site_url('siswa/load_sekolah'); ?>",
                dataType: "JSON",
                async: false,
                type: "POST",
                success: function(data) {
                    $('[name="id_sekolah"]').empty();

                    $('[name="id_sekolah"]').append('<option value="-">--Pilih Sekolah--</option>');
                    for (var i = 0; i < data.sekolah.length; i++) {
                        $('[name="id_sekolah"]').append('<option value=' + data.sekolah[i].id_sekolah + '>' + data.sekolah[i].nama_sekolah.toUpperCase() + '</option>');
                    }
                },
            });
        }

        function reloadTable(){
            tableData.DataTable().ajax.reload();
        }

        function message(icon, text){
            Swal.fire({
                position: 'center',
                icon: icon,
                title: text,
                showConfirmButton: true,
            })
        }

        function deleteAsk(id, name_depan){
            Swal.fire({
                text: 'Apakah Anda Ingin Menghapus Data '+ name_depan + ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(id);
                }
            })
        }

        function add(){
            saveData = "tambah";
            formData[0].reset();
            modal.modal('show');
            modalTitle.text('Tambah Data');
        }

        function save(){
            btnSave.text('Mohon Tunggu...');
            btnSave.attr('disabled', true);
            if(saveData == 'tambah'){
                url = "<?= base_url('siswa/add')?>"
            }else{
                url = "<?= base_url('siswa/update')?>"
            }
            $.ajax({
                type: "POST",
                url: url,
                data: formData.serialize(),
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success'){
                        modal.modal('hide');
                        btnSave.text('Simpan');
                        btnSave.attr('disabled', false);
                        reloadTable();
                        if(saveData == 'tambah'){
                            message('success', 'Data Berhasil Di Tambah');
                        }else{
                            message('success', 'Data Berhasil Di Ubah');
                        }
                    }else{
                        for(var i = 0; i < response.inputerror.length; i++){
                            $('[name="' + response.inputerror[i] +'"]').addClass('is-invalid');
                            $('[name="' + response.inputerror[i] +'"]').next().text(response.error_string[i]);
                        }
                    }
                    btnSave.text('Simpan');
                    btnSave.attr('disabled', false);
                },
                error: function(){
                    message('error', 'Sedang Gangguan Server');
                }
            });
        }

        function byid(id, type){
            if(type == 'edit'){
                saveData = 'edit';
                formData[0].reset();
            }

            $.ajax({
                type: "GET",
                url: "<?= base_url('siswa/byid/')?>" + id,
                dataType: "JSON",
                success: function (response) {
                    if(type == 'edit'){
                        formData.find('input').removeClass('is-invalid');
                        modal.modal('show');
                        modalTitle.text('Simpan');
                        btnSave.text('Simpan');
                        btnSave.attr('disabled', false);
                        $('[name="id_siswa"]').val(response.id_siswa);
                        $('[name="nama_siswa"]').val(response.nama_siswa);
                        $('[name="alamat_siswa"]').val(response.alamat_siswa);
                        $('[name="tempat_lahir"]').val(response.tempat_lahir);
                        $('[name="tgl_lahir"]').val(response.tgl_lahir);
                        $('[name="jenis_kelamin"]').val(response.jenis_kelamin);
                        $('[name="id_sekolah"]').val(response.id_sekolah);
                    }else{
                        deleteAsk(response.id_siswa, response.nama_siswa);
                    }
                },
                error: function(){
                    message('error', 'Sedang Gangguan Server');
                }
            });
        }

        function deleteData(id){
            $.ajax({
                type: "POST",
                url: "<?= base_url('siswa/delete/')?>" + id,
                dataType: "json",
                success: function (response) {
                    message('success', 'Data Berhasil Di Hapus');
                    reloadTable();
                },
                error: function(){
                    message('erroe', 'Sedang Gangguan Server');
                }
            });
        }
    </script>
</body>
</html>