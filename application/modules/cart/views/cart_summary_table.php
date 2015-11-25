<table class="table table-bordered">
				<thead>
					<tr>
						<th>
							<?php echo lang('product_image');?>
						</th>
						<th>
							<?php echo lang('product');?>
						</th>							
						<th>
							<?php echo lang('quantity');?>
						</th>
						<th>
							<?php echo lang('price');?>
						</th>
						<th>
							<?php echo lang('totals');?>
						</th>
						<th>
							<?php echo lang('product_action');?>
						</th>
					</tr>
				</thead>
				<tbody>                                    
                                        
				
<?php
    $cartItems = GC::getCartItems();
    $options = CI::Orders()->getItemOptions(GC::getCart()->id);
    $charges = [];

    $charges['giftCards'] = [];
    $charges['coupons'] = [];
    $charges['tax'] = [];
    $charges['shipping'] = [];
    $charges['products'] = [];
    $charges['items'] = [];
    //
    foreach($options as $option)
    {
        $charges['items'] = $option;
    }
    
    //
    foreach ($cartItems as $item)
    {
        if($item->type == 'gift card')
        {
            $charges['giftCards'][] = $item;
            continue;
        }
        elseif($item->type == 'coupon')
        {
            $charges['coupons'][] = $item;
            continue;
        }
        elseif($item->type == 'tax')
        {
            $charges['tax'][] = $item;
            continue;
        }
        elseif($item->type == 'shipping')
        {
            $charges['shipping'][] = $item;
            continue;
        }
        elseif($item->type == 'product')
        {
            $charges['products'][] = $item;
        }
    }

    if(count($charges['products']) == 0)
    {
        echo '<script>location.reload();</script>';
    }

    foreach($charges['products'] as $product):

        $photo = theme_img('no_picture.png', lang('no_image_available'));
        $product->images = array_values(json_decode($product->images, true));

        if(!empty($product->images[0]))
        {
            foreach($product->images as $photo)
            {
                if(isset($photo['primary']))
                {
                    $primary = $photo;
                }
            }
            if(!isset($primary))
            {
                $tmp = $product->images; //duplicate the array so we don't lose it.
                $primary = array_shift($tmp);
            }

            $photo = '<img src="'.base_url('uploads/images/full/'.$primary['filename']).'"/>';
        }

        ?>
        <tr>
            <th>
                    <a href="<?php echo site_url('/product/'.$product->slug); ?>">
                            <img src="<?php echo base_url('uploads/images/full/'.$primary['filename']);?>" alt="<?php echo $product->name; ?>" title="<?php echo $product->name; ?>" class="img-thumbnail" width="137" height="183"/>
                    </a>
            </td>
            <td class="">
                    <a href="<?php echo site_url('/product/'.$product->slug); ?>"><?php echo $product->name; ?></a> 
                    <br />
                    <?php 
                    foreach($charges['items'] as $o):?>
                    <span class=""><?php echo $o->option_name?>:<?php echo $o->name?></span><br />
                    <?php endforeach;?>
            </td>							
            <th>
                <div class="input-group btn-block">
                    <?php if(CI::uri()->segment(1) == 'cart' && !$product->fixed_quantity): ?>
                        <input class="form-control"  <?php echo($product->fixed_quantity)?'disabled':''?> data-product-id="<?php echo $product->id;?>" data-orig-val="<?php echo $product->quantity ?>" id="qtyInput<?php echo $product->id;?>" value="<?php echo $product->quantity ?>" type="text">
                    <?php else: ?>
                        &times; <?php echo $product->quantity; ?>
                    <?php endif;?>
                </div>        
            </td>
            <th>
                    <?php echo $product->quantity.' &times; '.format_currency($product->total_price)?>
            </td>
            <th>
                    <?php echo format_currency($product->total_price * $product->quantity); ?>
            </td>
            <th>
<!--                    <button type="submit" title="Update" class="btn btn-default tool-tip">
                            <i class="fa fa-refresh"></i>
                    </button>-->
                    <button type="button" onclick="updateItem(<?php echo $product->id;?>, 0);" title="<?php echo lang('remove');?>" class="btn btn-default tool-tip">
                           <i class="fa fa-times"></i>
                    </button>
            </td>
        </tr>
        
    <?php endforeach;?>
        
</tbody>
        <tfoot>
            <?php if(count($charges['products']) > 0):?>    
                <tr>
                  <td colspan="4" class="text-right">
                      <span class="cartSummaryTotalsKey"><strong><?php echo lang('subtotal');?> :</strong></span>
                  </td>
                  <td colspan="2" class="text-left">
                      <span class="cartSummaryTotalsValue"><?php echo format_currency(GC::getSubtotal());?></span>
                  </td>
                </tr>
                <?php if(count($charges['shipping']) > 0 || count($charges['tax']) > 0 ):?>
                    <?php foreach($charges['shipping'] as $shipping):?>
                    <tr>
                        <td colspan="4" class="text-right">
                            <span class="cartSummaryTotalsKey"><?php echo lang('shipping');?>: <?php echo $shipping->name; ?></span>
                        </td>
                        <td colspan="2" class="text-left">
                            <span class="cartSummaryTotalsValue"><?php echo format_currency($shipping->total_price); ?></span>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    <?php foreach($charges['tax'] as $tax):?>
                     <tr>
                        <td colspan="4" class="text-right">
                            <span class="cartSummaryTotalsKey"><?php echo lang('taxes');?>: <?php echo $tax->name; ?></span>
                        </td>
                        <td colspan="2" class="text-left">
                            <span class="cartSummaryTotalsValue"><?php echo format_currency($tax->total_price); ?></span>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php endif;?>
                <?php if(count($charges['giftCards']) > 0):?>
                    <?php foreach($charges['giftCards'] as $giftCard):?>
                    <tr>
                        <td colspan="4" class="text-right">
                            <div class="cartItemName"><?php echo $giftCard->name; ?></div>
                            <small><?php echo $giftCard->description; ?><br>
                            <?php echo $giftCard->excerpt; ?></small>
                        </td>
                        <td colspan="2" class="text-left">
                            <div class="cartItemRemove">
                                <a class="text-red" onclick="updateItem(<?php echo $giftCard->id;?>, 0);" style="cursor:pointer"><?php echo lang('remove');?></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php endif;?>
                    <tr>
                        <td colspan="4" class="text-right">
                            <span class="cartSummaryTotalsKey"><?php echo lang('grand_total');?>:</span>
                        </td>
                        <td colspan="2" class="text-left">
                            <span class="cartSummaryTotalsValue"><?php echo format_currency(GC::getGrandTotal());?></span>
                        </td>
                    </tr>
            <?php endif;?>  
            <?php foreach($charges['coupons'] as $coupon):?>
<!--                    <tr class="cartItem">
                        <td colspan="4" class="text-right">
                            <span class="cartSummaryTotalsKey"><?php echo lang('coupon');?>: <?php echo $coupon->description; ?></span>
                        </td>
                        <td colspan="2" class="text-left">
                            <span class="cartItemRemove">
                                <a class="text-red" onclick="updateItem(<?php echo $coupon->id;?>, 0);" style="cursor:pointer"><?php echo lang('remove');?></a>
                            </span>
                        </td>
                    </tr>-->
            <?php endforeach;?>
<!--            <tr class="cartPromotions">
                        <td colspan="4" class="text-right">
                            <div class="couponMessage"></div>
                            <form class="form-inline">
                            <div class="priority form-group">
                                <input type="text" id="coupon" class="form-control" placeholder="<?php echo lang('coupon_label');?>">
                            </div>
                            <a class="btn btn-primary btn-lg round" type="button" onclick="submitCoupon()"><i class="fa fa-plus"></i>
</i></a>
                            </form>
                        </td>
                        <td colspan="2" class="text-left">
                            <div class="giftCardMessage"></div>
                            <form class="form-inline">
                            <div class="priority form-group">
                                <input type="text" id="giftCard" class="form-control" placeholder="<?php echo lang('gift_card_label');?>">
                            </div>
                            <a class="btn btn-primary btn-lg round" type="button" onclick="submitGiftCard()"><i class="fa fa-plus"></i>
</a>
                            </form>
                        </td>
            </tr>        -->
        </tfoot>
</table>



    

<script>

var inventoryCheck = <?php echo json_encode($inventoryCheck);?>

function setInventoryErrors(checks)
{
    //remove pre-existing errors
    $('.errorAlert').removeClass('errorAlert');
    $('.summaryStockAlert').remove();

    //reprocess
    $.each(checks, function(key, val) {
        $('#cartItem-'+key).addClass('errorAlert').prepend('<div class="summaryStockAlert">'+val+'</div>');
    });
}

setInventoryErrors(inventoryCheck);

updateItemCount(<?php echo GC::totalItems();?>);
var closeBtn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
var newGrandTotalTest = <?php echo (GC::getGrandTotal() > 0)?1:0;?>;
if(newGrandTotalTest !== grandTotalTest)
{
    getPaymentMethods();
    grandTotalTest = newGrandTotalTest; //reset grand total test.
}

$('.quantityInput').bind('blur keyup', function(e){
    if(e.type === 'blur' || e.which === 13)
    {
        updateItem($(this).attr('data-product-id'), $(this).val(), $(this).attr('data-orig-val'));
    }
}).bind('focus', function(e){
    lastInput = $(this);
    lastValue = lastInput.val();
});
function updateItem(id, newQuantity, oldQuantity)
{
    $('#summaryErrors').html('').hide();

    if(newQuantity !== oldQuantity)
    {
        var active = $(document.activeElement).attr('id');

        if(newQuantity === 0)
        {
            if(!confirm('<?php echo lang('remove_item');?>')){
                return false;
            }
            else
            {
                if(oldQuantity !== undefined) //if the "remove" button is used we don't need to bother with this.
                {
                    $('#qtyInput'+id).val(oldQuantity);
                }
            }
        }
        $('#cartSummary').spin();
        $.post('<?php echo site_url('cart/update-cart');?>', {'product_id':id, 'quantity':newQuantity}, function(data){

            if(data.error !== undefined)
            {
                $('#summaryErrors').text(data.error).show();
                //there was an error. reset it.
                lastInput.val(lastValue).focus();
            }
            else
            {
                var elem = $(document.activeElement).attr('id');
                getCartSummary(function(){
                    $('#'+elem).focus();
                });
            }
            
        }, 'json');
    }
}

$('#coupon').keyup(function(event){
    var code = event.keyCode || event.which;
    if(code === 13) {
        submitCoupon();
    }
});

$('#giftCard').keyup(function(event){
    var code = event.keyCode || event.which;
    if(code === 13) {
        submitGiftCard();
    }
});

function submitGiftCard()
{
    $('#cartSummary').spin();
    $.post('<?php echo site_url('cart/submit-gift-card');?>', {'gift_card':$('#giftCard').val()}, function(data){
        if(data.error !== undefined)
        {
            $('.giftCardMessage').html($('<div class="alert alert-danger" role="alert"></div>').text(data.error).prepend(closeBtn));
            $('#cartSummary').spin(false);
            $('#giftCard')[0].setSelectionRange(0, $('#giftCard').val().length);
        }
        else
        {
            getCartSummary(function(){
                $('.giftCardMessage').html($('<div class="alert alert-success" role="alert"></div>').text(data.message).prepend(closeBtn));
            });
        }

    }, 'json');
}

function submitCoupon()
{
    $('#cartSummary').spin();
    $.post('<?php echo site_url('cart/submit-coupon');?>', {'coupon':$('#coupon').val()}, function(data){
        if(data.error !== undefined)
        {
            $('.couponMessage').html($('<div class="alert alert-danger" role="alert"></div>').text(data.error).prepend(closeBtn));
            $('#cartSummary').spin(false);
            $('#coupon')[0].setSelectionRange(0, $('#coupon').val().length);
        }
        else
        {
            getCartSummary(function(){
                $('.couponMessage').html($('<div class="alert alert-success" role="alert"></div>').text(data.message).prepend(closeBtn));
            });
        }
    }, 'json');
}

</script>

