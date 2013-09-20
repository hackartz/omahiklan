<p class="m-judul">PESAN</p>
<div class="m-content">
<h3></h3>
<div class="row">
    <div class="span5">
        <h4>Inbox</h4><hr>
        <button class="btn btn-inverse sendnew" data-toggle="modal" data-target="#modnewpesan" data-ticket="<?php echo $data_premium->ticket; ?>">send new</button>
        <table class="table table-condensed" >
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <?php if(!empty($data_pesan)) { ?>
                <?php foreach($data_pesan->result() as $data) { ?>
                    <tr>
                        <td>from : support omahiklan</td>
                        <!--        <td>--><?php //echo $data->isi; ?><!--</td>-->
                        <?php if($data->status == 'P') { ?>
                            <td id="sts<?php echo $data->id; ?>"><span class="label label-important">new</span></td>
                        <?php } else {?>
                            <td><span class="label label-info">read</span></td>
                        <?php } ?>
                        <td>
                            <a data-toggle="modal" data-id="<?php echo $data->id; ?>" data-target="#modviewpesan" data-pesan="<?php echo $data->isi; ?>" href="#" class="view-pesan btn btn-info btn-mini">
                                <i class="icon-eye-open"></i> view
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else {
                echo "<h4>Tidak ada pesan</h4>";
            } ?>

        </table>
    </div>

    <div class="span5">
        <h4>Subscriber</h4><hr>
        <?php if(!empty($subscriber)) { ?>
            <table class="table">
            <?php foreach($subscriber->result() as $data) { ?>
                <tr><td><?php echo $data->email;?></td></tr>
            <?php } ?>
        </table>
        <?php } else {?>
            tidak ada subscriber.
        <?php }?>
    </div>

</div>

</div>


<div class="modal hide fade" id="modviewpesan">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div class="modal-body">
        <p class="isipesan"></p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
    </div>
</div>
<!---->

<!---->
<div class="modal hide fade" id="modnewpesan" style="width: 460px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

    </div>
    <div class="modal-body">
        <textarea name="" id="newisipesan" cols="100" rows="4" style="width: 380px;"></textarea>
        <input type="hidden" data-ticket="" id="modticket"/>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-info" id="submitpesan">Send</a>
        <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
    </div>
</div>

<script type="text/javascript">
    $('.jmlproduk').hide();

    $('#modnewpesan').on('hide', function () {
        $('#newisipesan').val("");
    });

    $('#submitpesan').click(function(){
        var tmp_ticket = $('.sendnew').attr('data-ticket');
        //$('#modticket').attr('data-ticket',tmp_ticket);
        var isi = $('#newisipesan').val();
        $.ajax({

            url: '<?php echo base_url();?>member/kirim_pesan',
            type: 'POST',
            data: {
                isi_pesan: isi,
                ticket: tmp_ticket
            },

            success: function(result) {
                if(result == 'ok') {
                    $('#modnewpesan').modal('hide');
                    setTimeout(function(){
                        jSuccess(
                            'Pesan telah terkirim',
                            {
                                autoHide : true, // added in v2.0
                                clickOverlay : false, // added in v2.0
                                MinWidth : 250,
                                TimeShown : 2000,
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
                    },0);
                } else {

                }
            },
            error: function() {

            }

        });
    });


    $('.view-pesan').click(function(){
        var isi = $(this).attr('data-pesan');
        var id = $(this).attr('data-id');
        $('.isipesan').html(isi);
        $.ajax({

        	url: '<?php echo base_url();?>member/pesan_dibaca',
        	type: 'POST',
        	data: {
                id_pesan: id
            },

        	success: function(result) {
        		if(result != '0') {
                    $('#jumlah_pesan').html(result);
                    $('#sts'+id).html('<span class="label label-info">read</span>');
        		} else {

        		}
        	},
        	error: function() {

        	}

        });
    });


</script>