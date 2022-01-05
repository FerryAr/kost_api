<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <h2 style="margin-top:0px">Daftar Pemilik</h2>
        </div>
        <div class="col-md-4 text-center">
            <div style="margin-top: 4px" id="message">
                <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
            </div>
        </div>
        <?php if ($this->ion_auth->in_group(array(1))) { ?>
            <div class="col-md-4 text-right">
                <?php echo anchor(site_url('auth/create_user?group=3'), 'Create', 'class="btn btn-primary"'); ?>
            </div>
        <?php } ?>
    </div>

    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>Nama Depan</th>
            <th>Nama Belakang</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>No. WhatsApp</th>
            <!-- <th><?php //echo lang('index_groups_th'); ?></th>
            <th><?php //echo lang('index_status_th'); ?></th> -->
            <th>Action</th>
        </tr>
        <?php $no=1;foreach ($users as $user) : ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($user->alamat, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($user->no_wa, ENT_QUOTES, 'UTF-8'); ?></td>
                <!-- <td>
                    <?php //foreach ($user->groups as $group) : ?>
                        <?php //echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?><br />
                    <?php //endforeach ?>
                </td>
                <td><?php //echo ($user->active) ? anchor("auth/deactivate/" . $user->id, lang('index_active_link')) : anchor("auth/activate/" . $user->id, lang('index_inactive_link')); ?></td> -->
                <td><?php echo anchor("auth/edit_user/" . $user->id . "?group=3", 'Edit'); ?> | <?php echo anchor("auth/delete_user/" . $user->id, 'Delete'); ?></td>
            </tr>
        <?php endforeach; ?>
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