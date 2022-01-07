<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <h2 style="margin-top:0px">Postingan Blog</h2>
        </div>
        <div class="col-md-4 text-center">
            <div style="margin-top: 4px" id="message">
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : '';
                ?>
            </div>
        </div>
        <div class="col-md-4 text-right">
            <?php echo anchor(site_url('blog/create'), 'Create', 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Thumbnail</th>
            <th>Kategori</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1;
        foreach ($blog as $b) { ?>
            <tr>

                <td><?= $no++ ?></td>
                <td><?= $b->judul ?></td>
                <td><img src="<?= base_url('assets/img/blog_thumb/'.$b->thumbnail) ?>" style="width: 6rem"></td>
                <td><?= $b->nama_kategori ?></td>
                <td>
                    <a role="button" class="btn btn-secondary btn-sm" href="<?= base_url() ?>blog/update/<?= $b->id ?>">Edit</a>
                    <a role="button" class="btn btn-danger btn-sm" href="<?= base_url() ?>blog/delete/<?= $b->id ?>">Hapus</a>
                </td>
            </tr>
        <?php } ?>
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