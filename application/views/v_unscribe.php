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
            <h3>Berhenti Langganan</h3>
        </div>
        <div class="modal-body">
            <?php //$sukses = false;
            if ($sukses == true) { ?>
                <div class="alert alert-success">
                    <h4>Terima kasih , sekarang anda sudah berhenti langganan.</h4>
                </div>
            <?php } else { ?>
                <div class="alert alert-error">
                    <h4>Kesalahan sistem / email tidak terdaftar.</h4>
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