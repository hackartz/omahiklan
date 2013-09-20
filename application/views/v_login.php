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
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/validationEngine.jquery.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>jNotify-master/jquery/jNotify.jquery.css" media="screen" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style_login.css">

</head>
<body>
<div class="content">
    <div class="modal">
        <div class="modal-header">
            <center><h3>Login Member</h3></center>
        </div>
        <div class="modal-body">
            <p style="padding-top: 30px; "></p>
            <div class="content">
                <form id="form-login" class="form-login">
                    <input type="text" id="email" name="email" class="validate[required,custom[email]]" placeholder="youremail@mail.com">
                    <input type="password" id="password" name="password" class="validate[required]" placeholder="password">
                    <p class=""><input type="submit" class="btn btn-primary btn-block btn-large" value="login"></p>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <p class="text-left"><a href="<?php echo base_url();?>">back to home</a></p>
              &copy; copyright 2013 - omahiklan.com
        </div>
    </div>
</div>

<!-- Javascripts -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>jNotify-master/jquery/jNotify.jquery.min.js"></script>

<script type="text/javascript">

    $("#form-login").validationEngine({
        // Auto-hide prompt
        autoHidePrompt: true,
        // Delay before auto-hide
        autoHideDelay: 3000,
        // Fade out duration while hiding the validations
        fadeDuration: 0.3,
        promptPosition: "topLeft"
    });

    $('#form-login').on("submit",function(){

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url();?>home/act_login",

            data: {
                email: $("#email").val(),
                password: $("#password").val()
            },

            success: function(result) {

                if (result == 'true') {
                    window.location.replace('/member');
                } else {
                    jError(
                        'Login Failed, kombinasi email dan password salah',
                        {
                            autoHide : true, // added in v2.0
                            clickOverlay : false, // added in v2.0
                            MinWidth : 250,
                            TimeShown : 1500,
                            ShowTimeEffect : 200,
                            HideTimeEffect : 200,
                            LongTrip :20,
                            HorizontalPosition : 'right',
                            VerticalPosition : 'top',
                            ShowOverlay : false,
                            ColorOverlay : '#000',
                            OpacityOverlay : 0.3,
                        }
                    );
                    return false;
                }
            }
        });

        return false;

    });
</script>

</body>
</html>