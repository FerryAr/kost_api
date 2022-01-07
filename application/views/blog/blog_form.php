<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-4">
            <h2 style="margin-top:0px">Postingan Blog <?= $button ?></h2>
        </div>
        <div class="card" style="width:100%; height:100%">
            <div class="card-body">
                <form method="POST" action="<?php echo $action ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $judul; ?>" />
                    </div>
                    <div class="form-group">
                        <label>Thumbnail Blog</label>
                        <?php if ($thumbnail == '') { ?>
                            <input type="file" class="form-control dropify" name="file_thumbnail" id="thumbnail" />
                        <?php } else { ?>
                            <input type="file" class="form-control dropify" data-default-file="<?php echo base_url('assets/img/blog_thumb/' . $thumbnail) ?>" name="file_thumbnail" id="thumbnail" />
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" name="kategori" id="kategori">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategori as $k) { ?>
                                <option value="<?= $k->id ?>" <?php if ($k->id == $kategori_selected) {
                                                                    echo "selected";
                                                                } ?>><?= $k->nama_kategori ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Isi Blog</label>
                        <textarea class="form-control" rows="30" name="isi" id="isi"><?php echo $isi; ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
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
<script src="https://cdn.tiny.cloud/1/8mmmv801pzzoiwt7bqwxutz136kvplhwt8svvzamh03qbfdu/tinymce/5/tinymce.min.js"></script>

<script>
    $('.dropify').dropify();
    tinymce.init({
        selector: "#isi",
        height: 500,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image responsivefilemanager",
        automatic_uploads: true,
        image_advtab: true,
        images_upload_url: "<?php echo base_url("blog/tinymce_upload") ?>",
        file_picker_types: 'image',
        paste_data_images: true,
        relative_urls: false,
        remove_script_host: false,
        image_dimensions: false,
        image_class_list: [{
            title: 'Responsive',
            value: 'img-responsive'
        }],
        style_formats: [{
            title: 'Image Responsive',
            selector: 'img',
            styles: {
                'width': '100%',
                'height': '100%'
            }
        }],
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function() {
                    var id = 'post-image-' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var blobInfo = blobCache.create(id, file, reader.result);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                };
            };
            input.click();
        }
    });
</script>