<div class="container-fluid">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <h2 style="margin-top:0px">Slider Iklan Read</h2>
        </div>
        <table class="table">
            <tr>
                <td>Foto Iklan</td>
                <td><img style="width:25%;height:25%" src="<?php echo base_url('assets/img/sliders/' . $foto_iklan); ?>" /></td>
            </tr>
            <tr>
                <td>Level</td>
                <td><?php echo $level; ?></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td><?php echo $keterangan; ?></td>
            </tr>
            <tr>
                <td></td>

            </tr>
        </table>
        <a href="<?php echo site_url('carousel_iklan') ?>" class="btn btn-secondary">Kembali</a>
    </div>

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