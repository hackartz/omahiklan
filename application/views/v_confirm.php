<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style_confirm.css">

</head>
<body>
    <div class="content">
        <div class="modal">
            <div class="modal-header">
                <h3>KONFIRMASI PENDAFTARAN</h3>
            </div>
            <div class="modal-body">
                <?php //$is_confirmated = false;
                if ($is_confirmated == true) { ?>
                <div class="alert alert-success">
                    <h4>Selamat! Pendaftaran anda sukses... Silahkan Login dengan link dibawah dan mulai beriklan</h4>
                    <a href="<?php base_url(); ?>member/login" style="font-size: 16px;">LOGIN MEMBER</a>
                </div>
                <?php } else { ?>
                    <div class="alert alert-error">
                        <h4>Konfirmasi Pendaftaran Gagal!</h4>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                &copy; copyright 2013 - omahiklan.com
            </div>
        </div>
    </div>

<!-- Javascripts -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>

</body>
</html>