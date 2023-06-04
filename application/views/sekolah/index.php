<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sekolah</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap4.min.css')?>">

</head>
<body>
    <div class="container">
        <h2>Data Sekolah</h2>
        <div class="pull-left">
            <button type="button" class="btn btn-primary" onclick="add()">
                Tambah Sekolah
            </button>
        </div>
        <div class="text-right mb-2">
            <a href="<?= base_url('siswa')?>" class="btn btn-success btn-sm">
                Daftar Siswa
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped text-center" id="mytable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sekolah</th>
                            <th>Alamat Sekolah</th>
                            <th>Jumlah Kelas</th>
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
                    <input type="hidden" id="id_sekolah" name="id_sekolah" value="">
                    <label for="nama_depan">Nama Sekolah</label>
                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" placeholder="Masukan Nama Sekolah" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="alamat_sekolah">Alamat Sekolah</label>
                    <input type="text" class="form-control" id="alamat_sekolah" name="alamat_sekolah" placeholder="Masukan Alamat Sekolah" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="jml_kelas">Jumlah Kelas</label>
                    <input type="number" class="form-control" id="jml_kelas" name="jml_kelas" placeholder="Masukan Jumlah Kelas" autocomplete="off">
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
            tableData.DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?= base_url('sekolah/getData')?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "target": [-1],
                    "orderable": false
                }]
            })
        });

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

        function deleteAsk(id_sekolah, nama_sekolah){
            Swal.fire({
                text: 'Apakah Anda Ingin Menghapus Data '+ nama_sekolah + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(id_sekolah);
                }
            })
        }

        function add(){
            saveData = "tambah";
            formData[0].reset();
            modal.modal('show');
            modalTitle.text('Tambah Data Sekolah');
        }

        function save(){
            btnSave.text('Mohon Tunggu...');
            btnSave.attr('disabled', true);
            if(saveData == 'tambah'){
                url = "<?= base_url('sekolah/add')?>"
            }else{
                url = "<?= base_url('sekolah/update')?>"
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

        function byid(id_sekolah, type){
            if(type == 'edit'){
                saveData = 'edit';
                formData[0].reset();
            }

            $.ajax({
                type: "GET",
                url: "<?= base_url('sekolah/byid/')?>" + id_sekolah,
                dataType: "JSON",
                success: function (response) {
                    if(type == 'edit'){
                        formData.find('input').removeClass('is-invalid');
                        modal.modal('show');
                        modalTitle.text('Ubah Data');
                        btnSave.text('Simpan');
                        btnSave.attr('disabled', false);
                        $('[name="id_sekolah"]').val(response.id_sekolah);
                        $('[name="nama_sekolah"]').val(response.nama_sekolah);
                        $('[name="alamat_sekolah"]').val(response.alamat_sekolah);
                        $('[name="jml_kelas"]').val(response.jml_kelas);
                    }else{
                        deleteAsk(response.id_sekolah, response.nama_sekolah);
                    }
                },
                error: function(){
                    message('error', 'Sedang Gangguan Server');
                }
            });
        }

        function deleteData(id_sekolah){
            $.ajax({
                type: "POST",
                url: "<?= base_url('sekolah/delete/')?>" + id_sekolah,
                dataType: "json",
                success: function (response) {
                    message('success', 'Data Berhasil Di Hapus');
                    reloadTable();
                },
                error: function(){
                    message('error', 'Sedang Gangguan Server');
                }
            });
        }
    </script>
</body>
</html>