<p class="m-judul">Upgrade to Premium</p>
<div class="m-content">
    <p><span id="" class="label label-info">#<?php echo $ticket; ?></span></p>
    <p>Halaman ini akan jika anda sudah menjadi premium member
    dengan biaya administrasi sebesar :    </p>
    <ul>
        <li>1 bulan Rp 500.000,-</li>
        <li>6 bulan Rp 2.500.000,-</li>
        <li>setahun Rp 4.500.000,-</li>
    </ul>

    <p>Silahkan transfer ke salah satu rekening kami
        <br> BNI : 0299778801
        <br> BCA : 008781739093737
        <br> a.n Aji Sulistyono
    </p>
    <input type="hidden" id="ticket_member" value="<?php echo $ticket; ?>"/>
    <?php if($is_agree_premium) { ?>
<!--    <button class="btn btn-inverse">KONFIRMASI DISINI</button>-->
    <p class="text-right c-setuju"><button class="btn btn-success btn-large disabled" id="sudah_setuju">Setuju</button></p>
    <?php } else { ?>
        <p class="text-right c-setuju"><button class="btn btn-success btn-large" id="setuju">Setuju</button></p>
    <?php } ?>

</div>

<script type="text/javascript">
    $('.jmlproduk').hide();
    $('#setuju').click(function(){
        bootbox.confirm("No ticket anda <strong>#<?php echo $ticket; ?></strong><br>"+
            "silahkan anda cantumkan no ticket pada saat anda transfer ke salah satu no rekening kami."+
            "<br>upload bukti transfer anda pada kolom upload yang sudah disediakan.",
            function(result) {
                if(result == true) {
                    var ticket_member = $('#ticket_member').val();
                    //console.log(ticket_member);
                    //save ticket
                    $.ajax({
                        url: "<?php echo base_url();?>member/simpan_premium",
                        type: "POST",
                        data: {
                            ticket : ticket_member
                        },

                        success: function(res) {
                            if(res == "true") {
                                $.get('<?php echo base_url(); ?>member/gen_ticket',function(data) {
                                    $(".ajaxcontent").html(data);
                                });
                                //$(".c-setuju").html("<button class='btn btn-success btn-large disabled' id='setujufalse'>Setuju</button>");
                            }
                        }

                    });
                }
            });

       return false;
    });



</script>