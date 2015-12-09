<div class="page-header">
    <h1 class="page-title"><?php echo lang('shipping');?></h1>
</div>
<?php if($requiresShipping):?>
    <div class="shippingError"></div>
    <table class="table">
    <?php
    $selectedShippingMethod = \GC::getShippingMethod();
    foreach ($rates as $key => $rate):
        $hash = md5(json_encode(['key'=>$key, 'rate'=>$rate]));?>

        <tr onclick="$(this).find('input').prop('checked', true).trigger('change');">
            <td style="width:20px;">
                <div class="radio">
                    <label>
                        <input type="radio" name="shippingMethod" value="<?php echo $hash;?>" <?php echo (is_object($selectedShippingMethod) && $hash == $selectedShippingMethod->description)?'checked':'';?>>
                    </label>
                </div>
            </td>
            <td><?php echo $key;?></td>
            <td><?php echo format_currency($rate);?>
        </tr>

    <?php endforeach;?>
    </table>

    <script>
        $('[name="shippingMethod"]').change(function(){
            $('.shippingError').html('');
            $('#shippingMethod').spin();

            $.post('<?php echo site_url('checkout/set-shipping-method');?>', {'method':$(this).val()}, function(data){
                if(data.error)
                {
                    $('.shippingError').html('<div class="alert alert-danger" role="alert"><i class="close"></i> '+data.error+'</div>');
                }
                else
                {
                    //successful, refresh the summary
                    getCartSummary();
                    getPaymentMethods();
                }
                $('#shippingMethod').spin(false);
            });
        }).click(function(e) {
            //stop the event from bubbling up to the row and doubling
            e.stopPropagation();
        });
        
        function showShippingError(error)
        {
            $('.shippingError').html('<div class="alert alert-danger" role="alert">'+error+'</div>');
        }
    </script>
<?php else: ?>
    <div class="alert alert-danger">
        <p style="font-size: 14px;"><?php echo lang('no_shipping_needed');?></p>
    </div>
<?php endif;?>