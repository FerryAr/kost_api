<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <h2 style="margin-top:0px">Kost List</h2>
        </div>
        <div class="col-md-4 text-center">
            <div style="margin-top: 4px" id="message">
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
            </div>
        </div>
        <?php if ($this->ion_auth->in_group(array(1, 2, 3))) { ?>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('kost/create'), 'Create', 'class="btn btn-primary"'); ?>
            </div>
        <?php } ?>
    </div>
    <table class="table table-bordered" id="mytable">
        <thead>
            <tr>
                <th width="80px">No</th>
                <th>Nama Kost</th>
                <th>Pemilik</th>
                <th>Alamat</th>
                <th>Jenis Kost</th>
                <th>Tipe Kost</th>
                <th>Harga</th>
                <th>Operator</th>
                <th>Fasilitas</th>
                <th>Unggulan</th>
                <th>Area Terdekat</th>
                <th width="200px">Aksi</th>
            </tr>
        </thead>

    </table>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

        var t = $("#mytable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode == 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= $url ?>",
                "type": "POST"
            },
            columns: [{
                    "data": "id",
                    "orderable": false
                }, {
                    "data": "nama_kost"
                }, {
                    "data": "pemilik"
                }, {
                    "data": "alamat"
                }, {
                    "data": "jenis"
                },
                {
                    "data": "type"
                },
                {
                    "data": "harga"
                },
                {
                    "data": "first_name"
                },
                {
                    "data": "fasilitas"
                },
                {
                    "data": "unggulan",
                    "render": function(data, type, row, meta) {
                        if (data == '1') {
                            return '<span class="badge badge-success"><i class="fas fa-check"></i></span>';
                        } else {
                            return '<span class="badge badge-danger"><i class="fas fa-times"></i></span>';
                        }
                    }
                },
                {
                    "data": "area_terdekat"
                },
                // {
                //     "data": "foto",
                //     "render": function(data) {
                //         var foto = data.split(',');
                //         var output = '';
                //         for (var i = 0; i < foto.length; i++) {
                //             output += '<img class="img-responsive" src="<?php echo base_url() ?>assets/img/foto_kost/' + foto[i] + '" style="margin: 2rem 2rem 2rem 2rem; width: 40%; height: 40%"/>';
                //         }
                //         return output;
                //         //return '<img src="<?php echo base_url() ?>assets/img/'+data+'" style="width: 100%; height: 100%;" />';
                //     },
                //     "orderable": false
                // },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }
            ],
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
    });
</script>
</body>

</html>