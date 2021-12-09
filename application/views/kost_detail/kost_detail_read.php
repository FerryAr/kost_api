<!doctype html>
<html>

<head>
    <title>harviacode.com - codeigniter crud generator</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" />
    <style>
        body {
            padding: 15px;
        }
    </style>
</head>

<body>
    <h2 style="margin-top:0px">Kost_detail Read</h2>
    <table class="table">
        <tr>
            <td>Nama Kost</td>
            <td><?php echo $nama_kost; ?></td>
        </tr>
        <tr>
            <td>Nama Kamar</td>
            <td><?php echo $nama_kamar; ?></td>
        </tr>
        <tr>
            <td>Deskripsi Kamar</td>
            <td><?php echo $deskripsi_kamar; ?></td>
        </tr>
        <tr>
            <td>Harga</td>
            <td><?php echo $harga; ?></td>
        </tr>
        <tr>
            <td>Foto Kamar</td>
            <td>
                <?php
                $foto = explode(',', $foto);
                foreach ($foto as $foto) {
                    echo '<img src="' . base_url('assets/img/' . $foto) . '" style="margin-top: 2rem;margin-bottom: 2rem; width:50%; height:50%">';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>Fasilitas</td>
            <td><?php echo $fasilitas; ?></td>
        </tr>
        <tr>
            <td></td>
            <td><a href="<?php echo site_url('kost_detail') ?>" class="btn btn-default">Cancel</a></td>
        </tr>
    </table>
</body>

</html>