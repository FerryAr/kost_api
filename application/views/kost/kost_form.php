<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <h2 style="margin-top:0px">Kost Read</h2>
        </div>
        <div class="card" style="width:100%; height:100%">
            <div class="card-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="varchar">Nama Kost <?php echo form_error('nama_kost') ?></label>
                        <input type="text" class="form-control" name="nama_kost" id="nama_kost" placeholder="Nama Kost" value="<?php echo $nama_kost; ?>" />
                    </div>

                    <div class="form-group">
                        <label for="int">Pemilik <?php echo form_error('pemilik') ?></label>
                        <input type="text" class="form-control" name="pemilik" id="pemilik" placeholder="Pemilik" value="<?php echo $pemilik; ?>" <?php if ($this->ion_auth->in_group('pemilik')) {
                                                                                                                                                        echo 'readonly';
                                                                                                                                                    } ?> />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="varchar">Hp <?php echo form_error('hp') ?></label>
                        <input type="text" class="form-control" name="hp" id="hp" placeholder="Hp" value="<?php echo $hp; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="int">Jenis Kost <?php echo form_error('jenis_kost') ?></label>
                        <select class="form-control" id="jenis_kost" name="jenis_kost">
                            <option selected>Pilih Jenis Kost</option>
                            <?php foreach ($jenis_kost as $key => $value) { ?>
                                <option value="<?php echo $value->id ?>" <?php if ($value->id == $jenis_selected) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $value->jenis ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type_kost">Type Kost</label>
                        <select class="form-control" id="type_kost" name="type_kost">
                            <option selected disabled>Pilih Type Kost</option>
                            <?php foreach ($type_kost as $key => $value) { ?>
                                <option value="<?php echo $value->id ?>" <?php if ($value->id == $type_selected) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $value->type ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="int">Harga <?php echo form_error('harga') ?></label>
                        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" required />
                    </div>
                    <div class="form-group">
                        <label>Fasilitas</label>
                        <?php foreach ($fasilitas as $key => $value) { ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="<?php echo $value->id ?>" name="fasilitas[]" id="fasilitas" <?php if (in_array($value->id, $fasilitas_selected)) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                <label class="form-check-label" for="fasilitas"><?php echo $value->fasilitas ?></label>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Operator</label>

                        <select class="form-control" name="operator" id="operator">
                            <option selected disabled>Pilih Operator</option>
                            <?php foreach ($operator as $o) : ?>
                                <option value="<?php echo $o->id ?>" <?php if ($o->id == $operator_selected) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $o->first_name ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="area_terdekat">Area Terdekat <?php echo form_error('area_terdekat') ?></label>
                        <textarea class="form-control" rows="3" name="area_terdekat" id="area_terdekat" placeholder="Area Terdekat"><?php echo $area_terdekat; ?></textarea>
                    </div>
                    <div class="form-group" id="form-foto">
                        <label for="foto_kamar">Foto Kamar</label>
                        <div class="row">
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                            <div class="col-md-3">
                                <input type="file" class="form-control dropify" name="foto_kost[]" id="foto_kamar" />
                            </div>
                        </div>


                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url('kost') ?>" class="btn btn-default">Cancel</a>
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