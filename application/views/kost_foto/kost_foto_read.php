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
        <h2 style="margin-top:0px">Kost_foto Read</h2>
        <table class="table">
	    <tr><td>Id Kost Detail</td><td><?php echo $id_kost_detail; ?></td></tr>
	    <tr><td>Foto</td><td><?php echo $foto; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('kost_foto') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>