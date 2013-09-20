<p class="m-judul">Kelola Produk</p>
<div class="m-content">

    <p>
        <div class="">
            <button class="btn btn-success" data-toggle="modal" data-target="#modtambah"><i class="icon-plus-sign"></i> tambah produk</button>
            <button class="btn btn-danger" id="deleteproduct"><i class="icon-remove"></i> delete selected</button>
            <button class="btn btn-inverse" id="sendmail"><i class="icon-envelope"></i> send selected product</button>
            <span class="label label-info">Jumlah produk terpilih(max 3 untuk pengiriman email)</span>
            <span class="label label-inverse" id="stemail"></span>
        </div>
    </p>


    <div class="catalog">

<!--        <div class="div catalog-item" style="float: left; padding: 5px;">-->
<!--            <div class="row-fluid">-->
<!--                <div class="btn-group btn-group-vertical" style="padding: 0px; position: relative;margin-right: -21px;margin-top: -85px">-->
<!--                    <button class="btn btn-mini btn-primary"><i class="icon-pencil"></i></button>-->
<!--                    <button class="btn btn-mini btn-danger"><i class="icon-remove"></i></button>-->
<!---->
<!--                </div>-->
<!--                <input type="checkbox" value="">-->
<!--                <img src="holder.js/120x120" alt="" class="img-polaroid"/>-->
<!--            </div>-->
<!--            <div class="row-fluid" style="padding-top: 5px;margin-left: 5px;">-->
<!--                <p><span class="label label-info"> harga : Rp 0000,- </span></p>-->
<!--            </div>-->
<!--        </div>-->

        <?php
        if(!empty($catalog_item)) {
            foreach($catalog_item->result() as $item) { ?>
                <div class="div catalog-item" style="float: left; padding: 5px;">

                    <div class="row-fluid">
                        <div class="btn-group btn-group-vertical" style="padding: 0px; position: relative;margin-right: -21px;margin-top: -85px">
                            <button class="btn btn-mini btn-primary"><i class="icon-pencil"></i></button>
                            <button class="btn btn-mini btn-danger hapus-produk" data-hapus="<?php echo $item->id; ?>" data-image="<?php echo $item->foto; ?>"><i class="icon-remove"></i></button>

                        </div>
                        <?php if($item->aktif == 1) {?>
                            <input type="checkbox" value="<?php echo $item->id;?>">
                        <?php } else { ?>
                            <input type="checkbox" value="<?php echo $item->id;?>" disabled>
                        <?php } ?>
                        <img data-toggle="tooltip" title="<?php echo $item->nama_produk;?>" src="<?php echo base_url(); ?>img_produk/<?php echo $item->foto;?>" alt="" width="120px" height="120px" class="img-polaroid img-catalog"/>
                    </div>
                    <div class="row-fluid" style="padding-top: 5px;margin-left: 5px;">
                        <p><span class="label label-info"> harga : Rp <?php echo $item->harga; ?> </span></p>
                    </div>
                </div>
        <?php }
        } else {
            echo "produk masih kosong...";
        }?>

    </div>

</div>
<!--        modal tambah-->
        <div class="modal hide fade" id="modtambah" style="width: 600px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Tambah Produk</h3>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" id="form-produk-tambah">

                    <div class="control-group">
                        <label class="control-label" for="hp">Nama Produk</label>
                        <div class="controls">
                            <input type="text" name="namaproduk" id="namaproduk" class="input-xlarge">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="harga">Harga </label>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">Rp </span>
                                <input type="text" name="harga" id="harga" class="input-large">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="foto">Foto (max 2mb, .jpg)</label>
                        <div class="controls">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="input-append">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="input-append">
                                            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p>Ukuran file <span class="label label-inverse" id="lblSize"></span></p>
                            <span id="error-message" class="label label-warning"></span><span id="error-message1" class="label label-warning"></span>
                        </div>
                    </div>



            </div>
            <div class="modal-footer">
                <input type="submit" value="simpan" class="btn btn-primary" id="simpan"/>
                <a href="#" data-dismiss="modal" aria-hidden="true" class="btn">Close</a>

            </div>
            </form>
        </div>

<!--<script src="--><?php //echo base_url(); ?><!--js/holder.js"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--js/jquery.isloading.min.js"></script>-->

<script type="text/javascript">

    var cproduk = 0;
    var cekedprodukid = [];
    $(document).ready(function(){
        cproduk = 0;
        $('#countproduk').html(cproduk);
    });
    $('.jmlproduk').show();

    $('.catalog input:checkbox').click(function(){
        var allVals = [];
        cproduk = $('input:checkbox:checked').length;
        $('#countproduk').html(cproduk);
        $('.catalog input:checked').each(function() {
            allVals.push($(this).val());
        });
        cekedprodukid = allVals;
        //alert(cekedprodukid);
    });

    $('#deleteproduct').click(function(){
        if(cproduk == 0) {
            bootbox.alert("pilih produk yang akan dihapus",function(){});
        } else {
            $('#deleteproduct').html("<i class='icon-remove'></i> deleting...");
            $('#deleteproduct').addClass('disabled');
            $.ajax({
                url: "<?php echo base_url(); ?>member/delete_selected_product",
                type: 'POST',
                data: {
                    produk_id: cekedprodukid.join(",")
                },
                success: function(res) {
                    $('#deleteproduct').html("<i class='icon-remove'></i> delete selected");
                    $('#deleteproduct').removeClass('disabled');
                    $('.catalog').find(':checked').each(function() {
                        $(this).removeAttr('checked');
                    });
                    cproduk = 0;
                    $('#countproduk').html(cproduk);
                    cekedprodukid = [];
                    if(res == 'deleted') {
                        setTimeout(function(){
                            jSuccess(
                                'Data Produk sudah dihapus',
                                {
                                    autoHide : true, // added in v2.0
                                    clickOverlay : false, // added in v2.0
                                    MinWidth : 250,
                                    TimeShown : 3000,
                                    ShowTimeEffect : 200,
                                    HideTimeEffect : 200,
                                    LongTrip :20,
                                    HorizontalPosition : 'right',
                                    VerticalPosition : 'top',
                                    ShowOverlay : false,
                                    ColorOverlay : '#000',
                                    OpacityOverlay : 0.3
                                }
                            );
                        },2000);
                        $(".ajaxcontent").html("<div class='preloader'><p class='text-center'><img src='<?php echo base_url();?>img/preloader.gif' >please wait..</p></div>");
                        $.get("<?php echo base_url(); ?>member/kelola_produk",function(data){
                            $(".ajaxcontent").html(data);
                        });
                    }
                }

            });
        }
    });

    $('#sendmail').click(function(){
       if(cproduk == 0 || cproduk > 3) {
           bootbox.alert("pilih produk yang akan dikirim <br>dan maksimal produk yang dipilih 3",function(){});
       } else {
           $('#sendmail').html("<i class='icon-envelope'></i> sending email...");
           $('#sendmail').addClass('disabled');
           $.ajax({
              url: "<?php echo base_url();?>member/send_produk_email",
              type: 'POST',
              data: {
                   produk_id: cekedprodukid.join(",")
              },
              success: function(res) {
                  if(res == 'send') {
                      $('#sendmail').html("<i class='icon-envelope'></i> send selected product");
                      $('#sendmail').removeClass('disabled');
                      $('.catalog').find(':checked').each(function() {
                          $(this).removeAttr('checked');
                      });
                      cproduk = 0;
                      $('#countproduk').html(cproduk);
                      cekedprodukid = [];
                      jSuccess(
                          'email sudah terkirim ke subscriber anda.',
                          {
                              autoHide : true, // added in v2.0
                              clickOverlay : false, // added in v2.0
                              MinWidth : 250,
                              TimeShown : 3000,
                              ShowTimeEffect : 200,
                              HideTimeEffect : 200,
                              LongTrip :20,
                              HorizontalPosition : 'right',
                              VerticalPosition : 'top',
                              ShowOverlay : false,
                              ColorOverlay : '#000',
                              OpacityOverlay : 0.3
                          }
                      );
                  }
              }

           });
       }
    });


    $('#harga').autoNumeric('init', {});

    $('#modtambah').on('hide', function () {
        $('.fileupload').fileupload('reset');
        $('#namaproduk').val("");
        $('#harga').val("");
    });

    $(".hapus-produk").click(function(){
       //alert($(this).attr('data-hapus'));
        var id = $(this).attr('data-hapus');
        var img_name = $(this).attr('data-image');

        bootbox.confirm("yakin akan dihapus", function(result) {
            if(result == true) {
                $.ajax({
                    url: "<?php echo base_url();?>member/delete_produk",
                    type: 'POST',
                    data: {
                        id_produk: id,
                        foto_name: img_name
                    },
                    beforeSend: function(xhr){
                        $.isLoading({
                            text: "please wait.. menghapus data"
                        });
                    },
                    success: function(res) {
                        if(res == 'deleted') {

                            setTimeout(function(){
                                jSuccess(
                                    'Data Produk sudah dihapus',
                                    {
                                        autoHide : true, // added in v2.0
                                        clickOverlay : false, // added in v2.0
                                        MinWidth : 250,
                                        TimeShown : 3000,
                                        ShowTimeEffect : 200,
                                        HideTimeEffect : 200,
                                        LongTrip :20,
                                        HorizontalPosition : 'right',
                                        VerticalPosition : 'top',
                                        ShowOverlay : false,
                                        ColorOverlay : '#000',
                                        OpacityOverlay : 0.3
                                    }
                                );
                            },2000);

                            $(".ajaxcontent").html("<div class='preloader'><p class='text-center'><img src='<?php echo base_url();?>img/preloader.gif' >please wait..</p></div>");
                            $.get("<?php echo base_url(); ?>member/kelola_produk",function(data){
                                $(".ajaxcontent").html(data);
                            });
                        }
                    },
                    complete: function(xhr, textstatus) {
                        $.isLoading( "hide" );
                    }
                });
            }

        });
    });


    var file_size = 0;
    var max_size = 1024*2;

    function validasi_image() {
        var valid1 = false;
        var valid2 = false;
        if(!validate_image_type()) {
//            setTimeout(function() {
//                    $('#error-message').html('')
//                },2000
//            )
            $('#error-message').html('file type harus jpeg/jpg');
            valid1 = false;
        } else {
            $('#error-message').html('');
            valid1 = true;
        }

        if(cek_image_size() == false) {
            valid2 = false
            $('#error-message1').html('ukuran file melebihi 2mb');
        } else {
            $('#error-message1').html('');
            valid2 = true
        }

        if(valid1 && valid2) {
            return true;
        } else {
            return false;
        }
    }

    $('#form-produk-tambah').submit(function() {

        if(validasi_image() == true) {
            //('#preload-save').html("please wait.. saving and uploading data");
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo base_url();?>member/simpan_produk",
                type: 'POST',
                data: formData,
                async: false,
                success: function (res) {
                    if(res == 'saved') {
                        $('#modtambah').modal('hide');
                        bootbox.alert("data iklan tersimpan !<br> iklan akan ditampilkan setelah diaktifkan admin", function() {});
                        $(".ajaxcontent").html("<div class='preloader'><p class='text-center'><img src='<?php echo base_url();?>img/preloader.gif' >please wait..</p></div>");
                        $.get("<?php echo base_url(); ?>member/kelola_produk",function(data){
                            $(".ajaxcontent").html(data);
                        });
                    }
                },
                error: function(res) {
                    jError(
                        'Terjadi kesalahan sistem',
                        {
                            autoHide : true, // added in v2.0
                            clickOverlay : false, // added in v2.0
                            MinWidth : 250,
                            TimeShown : 3000,
                            ShowTimeEffect : 200,
                            HideTimeEffect : 200,
                            LongTrip :20,
                            HorizontalPosition : 'right',
                            VerticalPosition : 'top',
                            ShowOverlay : false,
                            ColorOverlay : '#000',
                            OpacityOverlay : 0.3
                        }
                    );
                },
                cache: false,
                contentType: false,
                processData: false
            });
            return false;
        }

        return false;

    });

    $('.fileupload').fileupload({
        uploadtype: "image",
        name: "foto"
    });

    function validate_image_type() {
        //validate if image type is jpg and image exists
        var imagename = $("[type=file]").val();
        var imageextension = imagename.substr((imagename.lastIndexOf('.') +1));
        if (imageextension != 'jpg' || $("[type=file]").val() == "") {
            return false;
        } else {
            return true;
        }
    }

    function cek_image_size() {

        if(file_size > max_size) {
            return false;
        } else {
            return true;
        }

    }

    $('input[type=file]').bind('change', function() {

        file_size = ($(this)[0].files[0].size / 1024);
        var iSize = ($(this)[0].files[0].size / 1024);
        if (iSize / 1024 > 1)
        {
            if (((iSize / 1024) / 1024) > 1)
            {
                iSize = (Math.round(((iSize / 1024) / 1024) * 100) / 100);
                $("#lblSize").html( iSize + "Gb");
            }
            else
            {
                iSize = (Math.round((iSize / 1024) * 100) / 100)
                $("#lblSize").html( iSize + "Mb");
            }
        }
        else
        {
            iSize = (Math.round(iSize * 100) / 100)
            $("#lblSize").html( iSize  + "kb");
        }
    });
</script>