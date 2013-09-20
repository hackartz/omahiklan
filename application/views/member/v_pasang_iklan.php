<p class="m-judul">Pasang Iklan</p>
<div class="m-content">
<div class="alert alert-success">
    <span class="label label-inverse">Notes</span>
    <p>Ukuran foto harus sesuai dengan ketentuan</p>
    <p>Tidak boleh menggunakan kata-kata dan foto yang mengandung unsur sara / pornografi</p>
    <p>Apabila tidak sesuai dengan ketentuan di atas maka tidak akan diaktifkan</p>
    <span class='label label-info'>
    <?php echo $is_aktif == false ? "iklan sebelumnya sudah aktif" : "iklan kosong / belum aktif";?></span>
</div>
<form class="form-horizontal" id="form-iklan">
    <div class="control-group">
        <label class="control-label" for="hp">Nama Iklan</label>
        <div class="controls">
            <input type="text" name="namaiklan" id="namaiklan" class="input-xlarge">
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="posiklan">Posisi Iklan</label>
        <div class="controls">
            <?php if($is_premium == false || $all_kuota == 15) {?>
                <select id="posiklan" name="posiklan" id="posiklan" disabled>
            <?php } else { ?>
                <select id="posiklan" name="posiklan" id="posiklan" class="posiklan">
            <?php }?>
                <option value="-1"> pilih posisi iklan</option>
                <?php if($kuota_slider == 5) { ?>
                    <option value="slider" disabled>di slide</option>
                <?php } else { ?>
                    <option value="slider">di slide</option>
                <?php } ?>
                <?php if($kuota_kanan == 5) { ?>
                    <option value="kanan" disabled>kanan</option>
                <?php } else { ?>
                    <option value="kanan">kanan</option>
                <?php } ?>
                <?php if($kuota_kiri == 5) { ?>
                    <option value="kiri" disabled>kiri</option>
                <?php } else { ?>
                    <option value="kiri">kiri</option>
                <?php } ?>

            </select>
            <span id="ukuran-gambar"></span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="kategori">Kategori </label>
        <div class="controls">
            <select id="kategori" name="kategori" id="kategori">
                <option value="-1"> pilih kategori</option>
                <?php foreach($kategori->result() as $kat) {
                    echo "<option value='".$kat->id."'>".$kat->nama_kategori."</option>";
                }
                ?>
            </select>
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
    <div class="control-group">
        <label class="control-label" for="alamatweb">Alamat website</label>
        <div class="controls">
            <div class="input-prepend">
                <span class="add-on">http://</span>
                <input type="text" name="alamatweb" id="alamatweb" class="input-xxlarge">
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="deskripsi">Deskripsi</label>
        <div class="controls">
            <textarea name="deskripsi" id="deskripsi" cols="30" rows="3" maxlength="100"></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="keywords">Keywords</label>
        <div class="controls">
            <input type="text" name="keywords" id="keywords" data-role="tagsinput">
        </div>
    </div>
    <p class="text-right">
        <input type="submit" value="simpan" class="btn btn-primary"/>
    </p>
</form>

</div>
<script src="<?php echo base_url(); ?>js/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.isloading.min.js"></script>
<script type="text/javascript">
    $('.jmlproduk').hide();
//    $('#isload').click(function(){
//        $.isLoading({
//            text: "Loading"
//        });
//        setTimeout( function(){
//            $.isLoading( "hide" );
//        }, 3000 );
//
//    })

    $(document).ready( function () {

        var maxLength = $("textarea#deskripsi").attr("maxlength");
        $("textarea#deskripsi").after("<span id='remainingLengthTempId'>"
            + maxLength + "</span> remaining");

        $("textarea#deskripsi").bind("keyup change", function(){checkMaxLength(this.id,  maxLength); } )

    });

    function checkMaxLength(textareaID, maxLength){

        var currentLengthInTextarea = $("#"+textareaID).val().length;
        $('#remainingLengthTempId').text(parseInt(maxLength) - parseInt(currentLengthInTextarea));

        if (currentLengthInTextarea > (maxLength)) {

            // Trim the field current length over the maxlength.
            $("textarea#deskripsi").val($("textarea#deskripsi").val().slice(0, maxLength));
            $('#remainingLengthTempId').text(0);

        }
    }


    $('#ukuran-gambar').html('ukuran foto 175px x 150px');
    $('.posiklan').change(function(){
        var pos = $(".posiklan option:selected").val();
        if(pos == 'kanan' || pos == 'kiri') {
            var ukuran = '160px x 600px';
            $('#ukuran-gambar').html('ukuran foto yang dibutuhkan '+ukuran);
        } else if(pos == '-1') {
            $('#ukuran-gambar').html('ukuran foto 175px x 150px');
        } else if(pos == 'slider') {
            var ukuran = '600px x 400px';
            $('#ukuran-gambar').html('ukuran foto yang dibutuhkan '+ukuran);
        }
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

    $('#form-iklan').submit(function() {
        if(validasi_image() == true) {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo base_url();?>member/simpan_iklan",
                type: 'POST',
                data: formData,
                async: false,
                success: function (res) {
                    //alert(res);

                    if(res == 'saved') {
                        bootbox.alert("data iklan tersimpan !<br> iklan akan ditampilkan setelah diaktifkan admin", function() {});
                        $('.fileupload').fileupload('reset');
                        $('#namaiklan').val("");
                        $('#deskripsi').val("");
                        //$('#keywords').val("");
                        $('#keywords').tagsinput('removeAll');
                        $('#alamatweb').val("");
                        document.getElementById("posiklan").selectedIndex = 0;
                        document.getElementById("kategori").selectedIndex = 0;
                    }

                    if(res == 'updated') {
                        bootbox.alert("data iklan yang baru tersimpan !<br> iklan akan ditampilkan setelah diaktifkan admin", function() {});
                        $('.fileupload').fileupload('reset');
                        $('#namaiklan').val("");
                        $('#deskripsi').val("");
                        //$('#keywords').val("");
                        $('#keywords').tagsinput('removeAll');
                        $('#alamatweb').val("");
                        document.getElementById("posiklan").selectedIndex = 0;
                        document.getElementById("kategori").selectedIndex = 0;
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