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
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/lean-slider.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/validationEngine.jquery.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>jNotify-master/jquery/jNotify.jquery.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-wizard.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">

</head>
<body>

<div id="wrap">
    <div class="dashboard">
        <div class="row">
            <div class="container">
                <img src="<?php echo base_url();?>img/omahbanner.png" alt="">
                <ul class="menu pull-right">
                    <li class="home"><a href="<?php echo base_url(); ?>"> <i class="icon-home"></i>home</a></li>
                    <li class="daftar" id="daftar"><a href="#" id="daftar"><i class="icon-external-link"></i> daftar</a></li>
                    <li class="login"><a href="<?php echo base_url(); ?>member/login"><i class="icon-user"></i>login</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="push"></div>
    <div class="container">
        <div class="cari">
            <form class="form-inline form-cari" method='get' action="<?php echo base_url();?>search_iklan">
                <input type="text" class="input-xlarge" placeholder="smartphone samsung"name="keyword">
                <select name="kategori_iklan" id="kategori_iklan">
                    <option value="semua">Semua Kategori</option>
                    <?php if(!empty($kategori)){ ?>
                        <?php foreach($kategori->result() as $kat){ ?>
                            <option value="<?php echo $kat->nama_kategori;?>"><?php echo $kat->nama_kategori;?></option>
                        <?php } ?>
                    <?php } ?>

                </select>
                <select name="lokasi_iklan" id="lokasi_iklan">
                    <option value="semua">Semua Lokasi</option>
                    <?php if(!empty($provinsi)){ ?>
                        <?php foreach($provinsi->result() as $prov){ ?>
                            <option value="<?php echo $prov->nama_provinsi;?>"><?php echo $prov->nama_provinsi;?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <button class="btn btn-primary btn-large">Cari</button>
            </form>
        </div>
    </div>

    <div class="push"></div>
    <div class="container">

        <div class="span8">
            //isi disini
        </div>
        <div class="span3">
            <div class="menu-kategori">
                <!--        <img src="holder.js/200x500" alt="" class="img-polaroid"/>-->

                <ul class="menu-kat">
                    <li class="menu-kat-header">
                        Kategori Iklan
                    </li>
                    <?php if(!empty($kategori)){ ?>
                        <?php foreach($kategori->result() as $kat){ ?>
                            <li class="menu-kat-item">
                                <a href="<?php echo base_url(); ?>search_category?s=<?php echo $kat->nama_kategori?>"><?php echo $kat->nama_kategori?></a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</div>

<div class="push-small">

</div>
<div class="footer-top">

</div>
<footer>
    <div class="footer-content">
        <div class="container" style="width: 960px;">
            <div class="row footer-main-content">
                <div class="span3">
                    <h4>Panduan Umum</h4>
                    <p class="item-panduan"><a href="<?php echo base_url();?>cara_daftar">Cara Mendaftar</a></p>
                    <p class="item-panduan"><a href="<?php echo base_url();?>cara_upgrade">Cara Upgrade Premium</a></p>
                    <p class="item-panduan"><a href="<?php echo base_url();?>tips">Tip's Jual Beli</a></p>
                </div>
                <div class="span2">
                    <h4>&nbsp</h4>
                    <p class="item-panduan"><a href="<?php echo base_url();?>contact">Contact Support</a></p>
                    <p class="item-panduan"><a href="<?php echo base_url();?>terms">Terms & Conditions</a></p>
                    <!--                    <p class="item-panduan"><a href="">Hubungi Kami</a></p>-->
                </div>
            </div>
            <div class="row" style="color:#fff; margin-top: 5px; margin-bottom: 10px;">
                <p class="text-center">&copy; copyright 2013 Aji Sulistyono - omahiklan.com</p>
            </div>
        </div>
    </div>
</footer>

<!-- wizard daftar -->
<div class="wizard" id="daftar-wizard">

    <h1 href="#top">Daftar Member</h1>
    <!-- informasi -->
    <div class="wizard-card" data-cardname="card1">
        <h3>Informasi</h3>
        <div>
            <span class="label label-success">Keuntungan Pasang iklan di omahiklan.com </span>
            <ul>
                <li>pasang iklan gratis</li>
                <li>menaikkan traffic promosi</li>
            </ul>
        </div>
    </div>
    <!-- end card1 -->

    <div class="wizard-card" data-cardname="card2">
        <h3>Informasi Pribadi</h3>
        <span class="label label-info">(*) wajib diisi</span>
        <p></p>
        <form class="form-horizontal" id="infoprib">

            <!-- email -->
            <div class="control-group">
                <label class="control-label" for="email">Email Anda * </label>
                <div class="controls">
                    <input type="text" id="email" name="email" class="validate[required,custom[email]]">
                    <span id="chkemail"></span>
                </div>
            </div>
            <!-- end email -->

            <!-- password -->
            <div class="control-group">
                <label class="control-label" for="pasword">Password * </label>
                <div class="controls">
                    <input type="password" id="password" name="password" class="validate[required]">
                </div>
            </div>
            <!-- end password -->

            <!-- ulangi password -->
            <div class="control-group">
                <label class="control-label" for="upassword">Ulangi Password * </label>
                <div class="controls">
                    <input type="password" id="upassword" name="upassword" class="validate[required,equals[password]]">
                </div>
            </div>
            <!-- end ulangi password -->

            <!-- Nama Depan -->
            <div class="control-group">
                <label class="control-label" for="namadepan">Nama Depan * </label>
                <div class="controls">
                    <input type="text" id="namadepan" name="namadepan" class="validate[required]">
                </div>
            </div>
            <!-- end nama depan -->

            <!-- nama belakang -->
            <div class="control-group">
                <label class="control-label" for="namabelakang">Nama Belakang * </label>
                <div class="controls">
                    <input type="text" id="namabelakang" name="namabelakang" class="validate[required]">
                </div>
            </div>
            <!-- end nama belakang -->

            <!-- jkel -->
            <div class="control-group">
                <label class="control-label" for="jkel">Jenis Kelamin * </label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="jkel" id="jkel" value="L" class="validate[required]"> Laki-laki
                    </label>

                    <label class="radio">
                        <input type="radio" name="jkel" id="jkel" value="P" class="validate[required]"> Perempuan
                    </label>
                </div>
            </div>
            <!-- end jkel -->

            <!-- Provinsi -->
            <div class="control-group">
                <label class="control-label" for="provinsi">Provinsi * </label>
                <div class="controls">
                    <select name="provinsi" id="provinsi" class="validate[required,funcCall[validasi_provinsi]]">
                        <option value="-1">Pilih Provinsi</option>
                        <?php if(!empty($provinsi)){ ?>
                            <?php foreach($provinsi->result() as $prov){ ?>
                                <option value="<?php echo $prov->id;?>"><?php echo $prov->nama_provinsi;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- end provinsi -->

            <!-- Kota -->
            <div class="control-group">
                <label class="control-label" for="kota">Kota * </label>
                <div class="controls">
                    <input type="text" id="kota" name="kota" class="validate[required]">
                </div>
            </div>
            <!-- end Kota -->

            <!-- Alamat -->
            <div class="control-group">
                <label class="control-label" for="alamat">Alamat * </label>
                <div class="controls">
                    <input type="text" id="alamat" name="alamat" class="validate[required]">
                </div>
            </div>
            <!-- end Alamat -->

            <!-- hp -->
            <div class="control-group">
                <label class="control-label" for="hp">No HandPhone</label>
                <div class="controls">
                    <input type="text" name="nohp" id="nohp">
                </div>
            </div>
            <!-- end hp -->

        </form>
    </div>
    <!-- end card2 -->

    <div class="wizard-card" data-cardname="card3">
        <h3>Info Toko</h3>
        <form class="form-horizontal" id="infotoko" name="infotoko">
            <!-- nama toko -->
            <div class="control-group">
                <label class="control-label" for="namatoko">Nama Toko * </label>
                <div class="controls">
                    <input type="text" name="namatoko" id="namatoko" class="validate[required]">
                </div>
            </div>
            <!-- end nama toko -->
        </form>
    </div>
    <!-- end card3 -->

    <div class="wizard-success">

        <div id="tes"></div>


    </div>

    <div class="wizard-error">
        <div class="alert alert-error">
            Kesalahan Sistem
        </div>
        <h3>Pendaftaran Gagal</h3>

    </div>

</div>
<!-- end wizard -->

<!---->
<div class="modal hide fade" id="modlangganan" style="width:390px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Berlanggan Produk iklan ini</h3>
    </div>
    <div class="modal-body">
        <form class="form-inline form-langganan">
            <label for="email">Email&nbsp;&nbsp; </label>
            <div class="input-prepend">
                <span class="add-on"><i class="icon-envelope"></i> </span>
                <input type="email" name="email-langganan" id="email-langganan" class="input-xlarge">
                <input type="hidden" data-sendemail="" class="dataemail"/>
            </div>
            <div>
                <p class="text-right" id="email-er-pc"></p>
            </div>
        </form>
        <div><p class="pesan-sukses"></p></div>
    </div>
    <div class="modal-footer">
        <a href="#" data-dismiss="modal" aria-hidden="true" class="btn">Close</a>
        <button class="btn btn-primary" id="submit-email">berlangganan</button>
    </div>
</div>
<!---->

<!-- Javascripts -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/holder.js"></script>
<script src="<?php echo base_url(); ?>js/lean-slider.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-wizard.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>jNotify-master/jquery/jNotify.jquery.min.js"></script>


<!-- slider js -->
<script type="text/javascript">
    var valid_email_langganan = false;
    $('#modlangganan').on('hide', function () {
        $('#email-langganan').val("");
        $('.form-langganan').show();
        $('.pesan-sukses').html('');
    });

    $('.form-langganan').submit(function(){
        e.preventDefault();
        return false;
    });

    $('#submit-email').click(function(){

        if(valid_email_langganan == true) {
            $(this).text('saving..');
            $(this).addClass('disabled');
            var id = $('.dataemail').attr('data-sendemail');
            var email_subscriber = $('#email-langganan').val();
            $.ajax({

                url: '<?php echo base_url();?>home/add_subscriber',
                type: 'POST',
                data: {
                    id_member: id,
                    email: email_subscriber
                },

                success: function(result) {
                    if(result == 'ok') {
                        console.log('ok coy');
                        $('#submit-email').removeClass('disabled');
                        $('#submit-email').text('berlangganan');
                        $('.form-langganan').hide();
                        $('.pesan-sukses').html('terima kasih sudah berlangganan iklan kami');
                    } else {
                        $('#submit-email').removeClass('disabled');
                        $('#submit-email').text('berlangganan');
                        $('.form-langganan').hide();
                        $('.pesan-sukses').html('maaf terjadi kesalahan dalam sistem');
                    }
                },
                error: function() {
                    $('#submit-email').removeClass('disabled');
                    $('#submit-email').text('berlangganan');
                    $('.form-langganan').hide();
                    $('.pesan-sukses').html('maaf terjadi kesalahan dalam sistem');
                }

            });
        }

    });

    $('.langganan').click(function(){
        var id_member = $(this).attr('data-iklan');
        $('.dataemail').attr('data-sendemail',id_member);
    });

    $(function(){
        $('#email-langganan').keyup(function(){
            if(!isValidEmailAddress($(this).val())) {
                valid_email_langganan = false;
                $('#email-er-pc').html('<span class="label label-important"> email not valid</span>');
            } else {
                valid_email_langganan = true;
                $('#email-er-pc').html('<span class="label label-success">email valid</span>');
            }
        })

        $('#email-langganan').blur(function(){
            if(!isValidEmailAddress($(this).val())) {
                valid_email_langganan = false;
                $('#email-er-pc').html('<span class="label label-important"> email not valid</span>');
            } else {
                valid_email_langganan = true;
                $('#email-er-pc').html('<span class="label label-success">email valid</span>');
            }
        })

        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return pattern.test(emailAddress);
        };

    });

    $("#infoprib").validationEngine({
        // Auto-hide prompt
        autoHidePrompt: true,
        // Delay before auto-hide
        autoHideDelay: 3000,
        // Fade out duration while hiding the validations
        fadeDuration: 0.3,
        autoPositionUpdate: false
    });

    $("#infotoko").validationEngine({
        // Auto-hide prompt
        autoHidePrompt: true,
        // Delay before auto-hide
        autoHideDelay: 3000,
        // Fade out duration while hiding the validations
        fadeDuration: 0.3
    });

</script>

<!-- wizard js -->
<script type="text/javascript">
    var is_email_ok = false;
    function remove_whitespaces(str) {
        var str=str.replace(/^\s+|\s+$/,'');
        return str;
    }

    function validasi_provinsi(field, rules, i, options) {
        var provinsi_index = document.getElementById("provinsi").selectedIndex;
        if (provinsi_index == 0) {
            return options.allrules.validateprovinsi.alertText;
        }
    }

    $(function(){
        $('#email').change(function(){
            var chk_email = remove_whitespaces($(this).val());
            //console.log($("#email").validationEngine('validate'));
            var j_email = $("#email").validationEngine('validate');
            if(j_email != true) {
                $('#chkemail').fadeIn(400).html('checking..');
                $.ajax({
                    url: "<?php echo base_url(); ?>home/is_valid_email",
                    type: "POST",
                    data: {
                        email: $(this).val()
                    },
                    cache: false,
                    success: function(res) {
                        if (res == "true") {
                            is_email_ok = true;
                            $('#chkemail').fadeIn(400).html('<i class="icon-ok chkemail-true"></i> email tersedia');
                        } else {
                            is_email_ok = false;
                            $('#chkemail').fadeIn(400).html('<i class="icon-remove chkemail-false"></i> email sudah digunakan');
                        }
                    }
                });
            } else {
                $('#chkemail').fadeIn(400).html('');
            }

        });

    });

    $(function() {

        var options = { width: 1000 };
        var wizard = $("#daftar-wizard").wizard(options);

        $("#daftar").click(function() {
            wizard.show();
        });

        wizard.on("submit", function(wizard) {
            var tmp_email = $("#email").val();
            var tmp_namadepan = $("#namadepan").val();
            var tmp_namabelakang = $("#namabelakang").val();
            var tmp_namalengkap = tmp_namadepan+" "+tmp_namabelakang;
            $.ajax({
                url: "<?php echo base_url(); ?>home/member_baru",
                type: "POST",
                data: {
                    email: $("#email").val(),
                    password: $("#password").val(),
                    namadepan: $('#namadepan').val(),
                    namabelakang: $('#namabelakang').val(),
                    jkel: $('input[name=jkel]:checked', '#infoprib').val(),
                    provinsi: $('#provinsi').val(),
                    kota: $('#kota').val(),
                    alamat: $('#alamat').val(),
                    nohp: $('#nohp').val(),
                    namatoko: $('#namatoko').val()
                },

                success: function (result) {
                    if(result == "ok") {

                        $('.wizard-success').html("<div class='alert alert-success'>Konfirmasi Pendaftaran</div><h4>Terima kasih sudah mendaftar di omahiklan.com</h4><p>Yth "+tmp_namalengkap+"</p><p>Email pendaftaran anda : "+tmp_email+"</p><p>Sebuah link konfirmasi telah kami kirimkan ke "+tmp_email+", Silahkan buka email anda dan ikuti langkah selanjutnya.</p>");
                        wizard.submitSuccess();
                        wizard.hideButtons();
                        wizard.showSubmitCard("success");
                        wizard.updateProgressBar(0);
                    } else {
                        wizard.submitError();
                        wizard.hideButtons();
                        wizard.showSubmitCard("error");
                        wizard.updateProgressBar(0);
                    }
                },
                error: function() {
                    wizard.submitError();
                    wizard.hideButtons();
                    wizard.showSubmitCard("error");
                    wizard.updateProgressBar(0);
                }
            });

        });


        wizard.cards["card2"].on("validate", function() {
            //console.log($("#infoprib").validationEngine('validate'));
            if ($("#infoprib").validationEngine('validate')) {
                if(is_email_ok == true) {
                    return true;
                } else {
                    $('#email').focus();
                    return false;
                }
            } else {
                return false;
            }
        });

        wizard.cards["card3"].on("validate", function() {

            if ($("#infotoko").validationEngine('validate')) {
                return true;
            } else {
                return false;
            }

        });

        wizard.on("reset", function(wizard) {
            $.each(wizard.cards, function(name, card) {
                card.el.find("input").val("");
                document.getElementById("provinsi").selectedIndex = 0;
                $('input[name="jkel"]').prop('checked', false);
            });
            $('#chkemail').html('');
        });

    });

</script>



</body>
</html>