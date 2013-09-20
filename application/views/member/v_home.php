<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/font-awesome-ie7.min.css">
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/fonts.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/validationEngine.jquery.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>jNotify-master/jquery/jNotify.jquery.css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jasny-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style_member.css">

</head>
<body>
<div class="container">
    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <div class="container">
                <!--            <a class="brand" href="#">Title</a>-->
                <ul class="nav">
                    <li class="active"><a href="#">Home</a></li>
                </ul>
                <div class="pull-right">
                    <ul class="nav pull-right">
                        <li class="active"><a href="#" class="waktu"></a></li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Selamat Datang, <?php echo $this->session->userdata('nama'); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" id="ubahdata" data-toggle="modal" data-target="#modubahdata"><i class="icon-cog"></i> Preferences</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url();?>member/logout"><i class="icon-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="push-medium"></div>

<div class="nav-member">
    <div class="row" style="width:1204px;">
        <div class="span3">
            <div class="sidebar-nav">
                <div class="well well-nav-member" style="width:200px; padding: 8px 0;">
                    <ul class="nav nav-list">
                        <li class="nav-header">Dashboard</li>
                        <li class=""><a href=""><i class="icon-home"></i> Home</a></li>
                        <?php if($is_premium){ ?>
                            <li class=""><a href="" id="gen_ticket" class="muted"><i class="icon-shopping-cart"></i> Upgrade to Premium</a></li>
                        <?php } else { ?>
                            <li class=""><a href="" id="gen_ticket" class=""><i class="icon-shopping-cart"></i> Upgrade to Premium</a></li>
                        <?php } ?>
                        <li class=""><a href="" id="pasang_iklan"><i class="icon-coffee"></i> Pasang Iklan</a></li>
                        <?php if($is_premium) {?>
                            <li class=""><a href="" id="kelola_produk"><i class="icon-plus-sign"></i> Kelola Produk</a></li>
                        <?php } else { ?>
                            <li class=""><a href="" id="kelola_produk" class="muted"><i class="icon-plus-sign"></i> Kelola Produk</a></li>
                        <?php } ?>
                        <li class=""><a href="" id="st_iklan"><i class="icon-dashboard"></i> Statistik Iklan </a></li>
                        <?php if($is_premium) {?>
                            <?php if(empty($count_pending_message)) {?>
                                <li class=""><a href="" id="pesan"><i class="icon-envelope"></i> Messages </a></li>
                            <?php } else { ?>
                                <li class=""><a href="" id="pesan"><i class="icon-envelope"></i> Messages <span class="badge badge-important" id="jumlah_pesan">
                                        <?php echo $count_pending_message; ?></span></a></li>
                            <?php } ?>
                        <?php } else { ?>
                            <li class="">
                                <a href="" id="pesan" class="muted">
                                    <i class="icon-envelope"></i> Messages
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="alert alert-info jmlproduk">
                Jumlah Produk terpilih : <span id="countproduk"></span>
            </div>
        </div>


        <div class="well span11 m-container ajaxcontent" style="padding: 0px">
<!--            <p class="m-judul">Information</p>-->
<!--            <div class="m-content">-->
<!--                Apa kabar ?-->
<!--            </div>-->

            <div class="alert alert-info">
                <h4>
                    INFORMASI <!--<ul class="pull-right text-right waktu">ok</ul>-->
                </h4>
<!--                <p class="text-right waktu"></p>-->
                <?php if($is_premium == true) {?>
                    <p>STATUS MEMBER : PREMIUM</p>
            </div>
            <div style="padding: 10px;">
                <p>Tgl Mulai Premium : <span class="label label-success"><?php echo date('d-m-Y',strtotime($data_premium->tgl_mulai)); ?></span></p>
                <p>Tgl Premium Berakhir : <span class="label label-success"> <?php echo date('d-m-Y',strtotime($data_premium->tgl_berakhir)); ?></span></p>
                <p>sisa waktu penggunaan : <span class="label label-success"><?php echo $data_premium->sisa; ?> hari</span></p>
                <span class="label label-info">Cara melakukan perpanjangan akun premium</span>
                <p>Kirim pesan pengajuan perpanjangan dengan format sebagai berikut :</p>
                <textarea rows="2" cols="70" style="width: 300px;">no ticket #<?php echo $data_premium->ticket."\n";?>Akun ini mengajukan perpanjangan premium </textarea>
            </div>
                <?php } else {?>
                    <p>STATUS MEMBER : FREE</p>
            </div>
                <?php } ?>

        </div>


    </div>
</div>

<div class="modal hide fade" id="modubahdata">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Ubah Data Anda</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" id="datamember">

            <!-- password -->
            <div class="control-group">
                <label class="control-label" for="pasword">Password baru </label>
                <div class="controls">
                    <input type="password" id="password" name="password">
                </div>
            </div>
            <!-- end password -->

            <!-- ulangi password -->
            <div class="control-group">
                <label class="control-label" for="upassword">Ulangi Password </label>
                <div class="controls">
                    <input type="password" id="upassword" name="upassword" class="validate[equals[password]]">
                </div>
            </div>
            <!-- end ulangi password -->

            <!-- Nama Depan -->
            <div class="control-group">
                <label class="control-label" for="namadepan">Nama Depan </label>
                <div class="controls">
                    <input type="text" id="namadepan" name="namadepan" value="<?php echo $data_member->nama_depan;?>">
                </div>
            </div>
            <!-- end nama depan -->

            <!-- nama belakang -->
            <div class="control-group">
                <label class="control-label" for="namabelakang">Nama Belakang </label>
                <div class="controls">
                    <input type="text" id="namabelakang" name="namabelakang" value="<?php echo $data_member->nama_belakang;?>">
                </div>
            </div>
            <!-- end nama belakang -->

            <!-- jkel -->
            <div class="control-group">
                <label class="control-label" for="jkel">Jenis Kelamin </label>
                <div class="controls">
                    <?php if($data_member->jkel == 'L') {?>
                    <label class="radio">
                        <input type="radio" name="jkel" id="jkel" value="L" checked> Laki-laki
                    </label>
                    <?php } else { ?>
                    <label class="radio">
                        <input type="radio" name="jkel" id="jkel" value="L"> Laki-laki
                    </label>
                    <?php } ?>

                    <?php if($data_member->jkel == 'P') {?>
                        <label class="radio">
                            <input type="radio" name="jkel" id="jkel" value="P"> Perempuan
                        </label>
                    <?php } else { ?>
                        <label class="radio">
                            <input type="radio" name="jkel" id="jkel" value="P"> Perempuan
                        </label>
                    <?php } ?>

                </div>
            </div>
            <!-- end jkel -->

            <!-- Provinsi -->
            <div class="control-group">
                <label class="control-label" for="provinsi">Provinsi </label>
                <div class="controls">
                    <select name="provinsi" id="provinsi">
                        <option value="-1">Pilih Provinsi</option>
                        <?php if(!empty($provinsi)){ ?>
                            <?php foreach($provinsi->result() as $prov){
                                if($prov->nama_provinsi == $data_member->nama_provinsi) {
                                ?>
                                    <option value="<?php echo $prov->id;?>" selected><?php echo $prov->nama_provinsi;?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $prov->id;?>"><?php echo $prov->nama_provinsi;?></option>
                                <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- end provinsi -->

            <!-- Kota -->
            <div class="control-group">
                <label class="control-label" for="kota">Kota </label>
                <div class="controls">
                    <input type="text" id="kota" name="kota" value="<?php echo $data_member->kota;?>">
                </div>
            </div>
            <!-- end Kota -->

            <!-- Alamat -->

            <div class="control-group">
                <label class="control-label" for="alamat">Alamat </label>
                <div class="controls">
                    <input type="text" id="alamat" name="alamat" value="<?php echo $data_member->alamat;?>">
                </div>
            </div>
            <!-- end Alamat -->

            <!-- nama toko -->
            <div class="control-group">
                <label class="control-label" for="namatoko">Nama Toko </label>
                <div class="controls">
                    <input type="text" name="namatoko" id="namatoko" value="<?php echo $data_member->nama_toko;?>">
                </div>
            </div>
            <!-- end nama toko -->

            <!-- hp -->
            <div class="control-group">
                <label class="control-label" for="hp">No HandPhone</label>
                <div class="controls">
                    <input type="text" name="nohp" id="nohp" value="<?php echo $data_member->no_hp;?>">
                </div>
            </div>
            <!-- end hp -->

        </form>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn">Close</a>
        <a href="#" id="updatedata" class="btn btn-primary">Simpan Data</a>
    </div>
</div>

<div class="modal hide fade" id="modlogout">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>logout to refreh data</h3>
    </div>
    <div class="modal-body">
        after successfully logout you can try login again to refreh changed data
    </div>
    <div class="modal-footer">
    </div>
</div>



<!-- Javascripts -->
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css">
<!--[if IE 7]>
<link rel="stylesheet" href="css/font-awesome-ie7.min.css">
<![endif]-->
<script src="<?php echo base_url(); ?>js/holder.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>jNotify-master/jquery/jNotify.jquery.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>js/jasny-bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url(); ?>js/autoNumeric.js"></script>
<script src="<?php echo base_url(); ?>js/moment_langs.min.js"></script>

<script type="text/javascript">
    $('.jmlproduk').hide();
    moment.lang('id');
    var update_waktu = function() {
        $('.waktu').html(moment().format('DD MMMM YYYY, h:mm:ss a'));
    };

    setInterval(update_waktu, 1000);

    $('#pesan').click(function(){

        if($(this).attr('class') == 'muted') {
            return false;
        } else {
            $(".ajaxcontent").html("<div class='preloader'><p class='text-center'><img src='<?php echo base_url();?>img/preloader.gif' >please wait..</p></div>");
            $.get("<?php echo base_url(); ?>member/view_pesan",function(data){
                $(".ajaxcontent").html(data);
            });
            return false;
        }
    });

    $('#gen_ticket').click(function(){

        if($(this).attr('class') == 'muted') {
            return false;
        } else {
            $(".ajaxcontent").html("<div class='preloader'><p class='text-center'><img src='<?php echo base_url();?>img/preloader.gif' >please wait..</p></div>");
            $.get("<?php echo base_url(); ?>member/gen_ticket",function(data){
                $(".ajaxcontent").html(data);
            });
            return false;
        }
    });

    $('#pasang_iklan').click(function(){
        $(".ajaxcontent").html("<div class='preloader'><p class='text-center'><img src='<?php echo base_url();?>img/preloader.gif' >please wait..</p></div>");
        $.get("<?php echo base_url(); ?>member/pasang_iklan",function(data){
            $(".ajaxcontent").html(data);
        });
        return false;
    });

    $('#kelola_produk').click(function(){
        if($(this).attr('class') == 'muted') {
            return false;
        } else {
            $(".ajaxcontent").html("<div class='preloader'><p class='text-center'><img src='<?php echo base_url();?>img/preloader.gif' >please wait..</p></div>");
            $.get("<?php echo base_url(); ?>member/kelola_produk",function(data){
                $(".ajaxcontent").html(data);
            });
            return false;
        }
    });

    $('#st_iklan').click(function(){
        $(".ajaxcontent").html("<div class='preloader'><p class='text-center'><img src='<?php echo base_url();?>img/preloader.gif' >please wait..</p></div>");
        $.get("<?php echo base_url(); ?>member/st_iklan",function(data){
            $(".ajaxcontent").html(data);
        });
        return false;
    });

//    if ($("#infotoko").validationEngine('validate')) {
//        return true;
//    } else {
//        return false;
//    }

    $('#modubahdata').on('hide', function () {

    });

    $("#datamember").validationEngine({
        // Auto-hide prompt
        autoHidePrompt: true,
        // Delay before auto-hide
        autoHideDelay: 3000,
        // Fade out duration while hiding the validations
        fadeDuration: 0.3,
        autoPositionUpdate: false
    });

    $('#updatedata').click(function(){
        //data

        if($('#password').val() != '') {
            $tmp_password = $('#password').val();
        } else {
            $tmp_password = 'false';
        }

        if ($("#datamember").validationEngine('validate')) {
            $.ajax({

            	url: '<?php echo base_url();?>member/ubah_data',
            	type: 'POST',
            	data: {
                    password: $tmp_password,
                    namadepan: $('#namadepan').val(),
                    namabelakang: $('#namabelakang').val(),
                    jkel: $('input[name=jkel]:checked', '#datamember').val(),
                    provinsi: $('#provinsi').val(),
                    kota: $('#kota').val(),
                    alamat: $('#alamat').val(),
                    nohp: $('#nohp').val(),
                    namatoko: $('#namatoko').val()
                },

            	success: function(result) {
            		if(result == 'ok') {
                        $('#modubahdata').modal('hide');
                        $('#modlogout').modal('show');
                        setTimeout(function(){
                            window.location.replace('member/logout');
                        },3000);


            		} else {

            		}
            	},
            	error: function() {

            	}

            });
        }
    });

</script>


</body>
</html>