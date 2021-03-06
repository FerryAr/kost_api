<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <h2 style="margin-top:0px">Informasi Kost</h2>
        </div>
        <table class="table table-striped">
            <tr>
                <td>Nama Kost</td>
                <td><?php echo $nama_kost; ?></td>
            </tr>
            <tr>
                <td>Pemilik</td>
                <td><?php echo $pemilik; ?></td>
            </tr>
            <tr>
                <td>Operator</td>
                <td><?php echo $operator; ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><?php echo $alamat; ?></td>
            </tr>
            <tr>
                <td>Tipe Kost</td>
                <td><?php echo $type_kost; ?></td>
            </tr>
            <tr>
                <td>Jenis Kost</td>
                <td><?php echo $jenis_kost; ?></td>
            </tr>
            <tr>
                <td>Fasilitas</td>
                <td>
                    <ul>
                        <?php foreach ($fasilitas as $f) { ?>
                            <li><?php echo $f; ?></li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>Harga</td>
                <td><?php echo number_format($harga, 0, ',', '.'); ?></td>
            </tr>
            <tr>
                <td>Area Terdekat</td>
                <td><?php echo $area_terdekat; ?></td>
            </tr>
            <tr>
                <td>Foto Kost</td>
                <td>
                    <?php foreach ($foto as $f) { ?>
                        <img src="<?= base_url('assets/img/foto_kost/'. $f) ?>" class="img-responsive mt-3" style="width: 852px; height:480px" />
                    <?php } ?>
                </td>
            </tr>
        </table>
        <!-- <div class="col-md-4">
            <h2 style="margin-top:0px">Detail Kost</h2>
        </div>
        <table class="table table-striped" style="margin-top:1rem">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kamar</th>
                    <th>Deskripsi Kamar</th>
                    <th>Harga</th>
                    <th>Fasilitas</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // $no = 1;
                // foreach ($detail_kost as $k) {
                ?>
                    <tr>
                        <td><?php //echo $no++ 
                            ?></td>
                        <td><?php //echo $k->nama_kamar 
                            ?></td>
                        <td><?php //echo $k->deskripsi_kamar 
                            ?></td>
                        <td><?php //echo $k->harga 
                            ?></td>
                        <td><?php //echo $k->fasilitas 
                            ?></td>
                        <!-- <td><img src="<?php //echo base_url('assets/img/kamar/' . $k->foto) 
                                            ?>" width="100" height="100"></td> -->
        <td>
            <?php
            //$data_foto = $k->foto;
            //$foto = explode(",", $data_foto);
            //foreach ($foto as $f) {
            ?>
            <!-- <img src="<?php //echo base_url('assets/img/' . $f) 
                            ?>" style="margin-top:2rem; margin-bottom:2rem">
                            <?php //} 
                            ?> -->
        </td>
        </tr>
        <?php
        //}
        ?>
        <!-- </table> --> -->
        <a href="<?php echo site_url('/') ?>" class="btn btn-secondary">Kembali</a>
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