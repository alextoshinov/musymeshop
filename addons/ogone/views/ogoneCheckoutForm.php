<div class="page-header">
    <h1 class="page-title"><?php echo lang('charge_with_ogone');?></h1>
</div>

<button class="btn btn-danger btn-lg round" id="btn_cod" onclick="OgoneSubmitOrder()"><?php echo lang('submit_order');?></button>

<script>
function OgoneSubmitOrder()
{
    $('#btn_ogone').attr('disabled', true).addClass('disabled');

    $.post('<?php echo base_url('/ogone/process-payment');?>', function(data){
        if(data.errors !== undefined)
        {
            var error = '<div class="alert alert-danger" role="alert">';
            $.each(data.errors, function(index, value)
            {
                error += '<p>'+value+'</p>';
            });
            error += '</div>';

            $.gumboTray(error);
            $('#btn_ogone').attr('disabled', false).addClass('disabled');
        }
        else
        {
            if(data.orderId !== undefined)
            {
                window.location = '<?php echo site_url('order-complete/');?>/'+data.orderId;
            }
        }
    }, 'json');

}
</script>
