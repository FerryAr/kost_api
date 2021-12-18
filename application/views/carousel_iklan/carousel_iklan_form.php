<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <h2 style="margin-top:0px">Slider Iklan <?= $button ?></h2>
        </div>
        <div class="card" style="width:100%; height:100%">
            <div class="card-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="foto_iklan">Foto Iklan <?php echo form_error('foto_iklan') ?></label>
                        <input type="file" class="form-control dropify" name="foto_iklan" id="foto_iklan" />
                    </div>
                    <div class="form-group">
                        <label for="int">Level <?php echo form_error('level') ?></label>
                        <input type="number" class="form-control" name="level" id="level" placeholder="Level" value="<?php echo $level; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan <?php echo form_error('keterangan') ?></label>
                        <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('carousel_iklan') ?>" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/dropify/js/dropify.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

<script>
    $('.dropify').dropify();
</script>