<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Kost_foto <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Kost Detail <?php echo form_error('id_kost_detail') ?></label>
            <input type="text" class="form-control" name="id_kost_detail" id="id_kost_detail" placeholder="Id Kost Detail" value="<?php echo $id_kost_detail; ?>" />
        </div>
	    <div class="form-group">
            <label for="foto">Foto <?php echo form_error('foto') ?></label>
            <textarea class="form-control" rows="3" name="foto" id="foto" placeholder="Foto"><?php echo $foto; ?></textarea>
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('kost_foto') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>