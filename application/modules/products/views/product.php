
<br /> 
<div class="col-lg-6 col-md-6 col-sm-6 images-block">
        <div class="images-container">
            <?php
            $photo = theme_img('no_picture.png', lang('no_image_available'));

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

                $photo = '<img class="img-responsive product-image" src="'.base_url('uploads/images/full/'.$primary['filename']).'" alt="'.$product->seo_title.'" data-caption="'.htmlentities(nl2br($primary['caption'])).'"/>';
            }
            ?>
        <a href="<?php echo base_url('uploads/images/full/'.$primary['filename']);?>">
            <?php echo $photo;?>
        </a>    
        </div>
        <?php if(!empty($primary['caption'])):?>
        <div class="productCaption">
            <?php echo $primary['caption'];?>
        </div>
        <?php endif;?>

        <?php if(count($product->images) > 1):?>
            <div class="small-images-container">
                <div class="images-arrow-right"><a class="next"><i class="fa fa-arrow-circle-right fa-sm"></i></a></div>
                    <ul class="product-images owl-carousel" id="owl-product">
                    <?php foreach($product->images as $image):?>
                    <li>
                        <a href="<?php echo base_url('uploads/images/full/'.$image['filename']);?>">
                            <img class="img-responsive product-image-sm" src="<?php echo base_url('uploads/images/full/'.$image['filename']);?>" data-caption="<?php echo htmlentities(nl2br($image['caption']));?>"/>
                        </a>
                    </li>
                    <?php endforeach;?>
                    </ul>
                <div class="images-arrow-left"><a class="prev"><i class="fa fa-arrow-circle-left fa-sm"></i></a></div>
            </div>
        <?php endif;?>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <div id="productAlerts" class="row"></div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 marginTop10">
            <!-- Portfolio Item Heading -->
                <h3 class="categoryItemDetails">
                    <?php echo $product->name;?> 
                </h3>
            </div>
            
        
        <?php if(!$product->is_giftcard):?>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 marginTop10">
            <?php if($product->saleprice > 0):?>
                <small class="sale"><?php echo lang('on_sale');?></small>
                <div class="price text-right">
                    <div class="price-text">
                        <?php echo $product->saleprice;?>                        
                    </div><span class="currency">&nbsp;EUR</span>
                </div>                
            <?php else:?>
                <div class="price text-right">
                    <div class="price-text">
                <?php echo $product->price;?>
                        <span class="currency">EUR</span>
                    </div>
                </div>    
            <?php endif;?>
            </div>
        <?php endif;?>
        <div class="col-lg-12 col-xs-12">
            <p class="product-description">
                <?php echo (new content_filter($product->excerpt))->display();?>
            </p>
            <p class="product-description">
                <?php echo (new content_filter($product->description))->display();?>
            </p>
        </div>
    

            <?php echo form_open('cart/add-to-cart', 'id="add-to-cart" class="form-inline"');?>
            <input type="hidden" name="cartkey" value="<?php echo CI::session()->flashdata('cartkey');?>" />
            <input type="hidden" name="id" value="<?php echo $product->id?>"/>

            <?php if(count($options) > 0): ?>
                <?php foreach($options as $option):
                    $required = '';
                    if($option->required)
                    {
                        $required = ' class="required"';
                    }
                    ?>
                        <div class="col-nest">
                            <div class="col" data-cols="1/3">
                                <label<?php echo $required;?>><?php echo ($product->is_giftcard) ? lang('gift_card_'.$option->name) : $option->name;?></label>
                            </div>
                            <div class="col" data-cols="2/3">
                        <?php
                        if($option->type == 'checklist')
                        {
                            $value  = [];
                            if($posted_options && isset($posted_options[$option->id]))
                            {
                                $value  = $posted_options[$option->id];
                            }
                        }
                        else
                        {
                            if(isset($option->values[0]))
                            {
                                $value  = $option->values[0]->value;
                                if($posted_options && isset($posted_options[$option->id]))
                                {
                                    $value  = $posted_options[$option->id];
                                }
                            }
                            else
                            {
                                $value = false;
                            }
                        }

                        if($option->type == 'textfield'):?>
                            <input class="form-control" type="text" name="option[<?php echo $option->id;?>]" value="<?php echo $value;?>"/>
                        <?php elseif($option->type == 'textarea'):?>
                            <textarea class="form-control" name="option[<?php echo $option->id;?>]"><?php echo $value;?></textarea>
                        <?php elseif($option->type == 'droplist'):?>
                            <select class="form-control" name="option[<?php echo $option->id;?>]">
                                <option value=""><?php echo lang('choose_option');?></option>

                            <?php foreach ($option->values as $values):
                                $selected   = '';
                                if($value == $values->id)
                                {
                                    $selected   = ' selected="selected"';
                                }?>

                                <option<?php echo $selected;?> value="<?php echo $values->id;?>">
                                    <?php if($product->is_giftcard):?>
                                        <?php echo($values->price != 0)?' (+'.format_currency($values->price).') ':''; echo lang($values->name);?>
                                    <?php else:?>
                                        <?php echo($values->price != 0)?' (+'.format_currency($values->price).') ':''; echo $values->name;?>
                                    <?php endif;?>
                                    
                                </option>

                            <?php endforeach;?>
                            </select>
                        <?php elseif($option->type == 'radiolist'):?>
                            <label class="radiolist">
                            <?php foreach ($option->values as $values):

                                $checked = '';
                                if($value == $values->id)
                                {
                                    $checked = ' checked="checked"';
                                }?>
                                <div>
                                    <input<?php echo $checked;?> type="radio" name="option[<?php echo $option->id;?>]" value="<?php echo $values->id;?>" class="form-control"/>
                                    <?php echo($values->price != 0)?'(+'.format_currency($values->price).') ':''; echo $values->name;?>
                                </div>
                            <?php endforeach;?>
                            </label>
                        <?php elseif($option->type == 'checklist'):?>
                            <label class="checklist"<?php echo $required;?>>
                            <?php foreach ($option->values as $values):

                                $checked = '';
                                if(in_array($values->id, $value))
                                {
                                    $checked = ' checked="checked"';
                                }?>
                                <div><input<?php echo $checked;?> type="checkbox" name="option[<?php echo $option->id;?>][]" value="<?php echo $values->id;?>" class="form-control"/>
                                <?php echo($values->price != 0 && $option->name != 'Buy a Sample')?'('.format_currency($values->price).') ':''; echo $values->name;?></div>
                            <?php endforeach; ?>
                            </label>
                        <?php endif;?>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>

            <div class="col-lg-12 col-xs-12 text-center">
            <?php if(!config_item('inventory_enabled') || config_item('allow_os_purchase') || !(bool)$product->track_stock || $product->quantity > 0) : ?>

                <?php if(!$product->fixed_quantity) : ?>
                <div class="form-group">
                        <label class="text-orange"><?php echo lang('label_quantity');?></label>
                        <input type="text" name="quantity" value="1" style="width:50px; display:inline" class="form-control" />
                </div>       
                        <button class="btn btn-primary btn-lg round" type="button" value="submit" onclick="addToCart($(this));"><i class="fa fa-shopping-cart fa-sm"></i> <?php echo lang('form_add_to_cart');?></button>
                        
                <?php else: ?>
                        <button class="btn btn-primary btn-lg round" type="button" value="submit" onclick="addToCart($(this));"><i class="fa fa-shopping-cart fa-sm"></i> <?php echo lang('form_add_to_cart');?></button>
                <?php endif;?>

            <?php endif;?>
                </div>
            </form>
        </div>
    </div>



<script>

    function addToCart(btn)
    {
        $('.productDetails').spin();
        btn.attr('disabled', true);
        var cart = $('#add-to-cart');
        $.post(cart.attr('action'), cart.serialize(), function(data){
            if(data.message !== undefined)
            {
                $('#productAlerts').html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><p>'+data.message+' <a href="<?php echo site_url('checkout');?>"> <?php echo lang('view_cart');?></a></p> </div>');
                updateItemCount(data.itemCount);
                cart[0].reset();
            }
            else if(data.error !== undefined)
            {
                $('#productAlerts').html('<div class="alert alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><p>'+data.error+'</p> </div>');
            }

            $('.productDetails').spin(false);
            btn.attr('disabled', false);
        }, 'json');
    }

    var banners = false;
    $(document).ready(function(){
        banners = $('#banners').html();
    })

    $('.productImages img').click(function(){
        if(banners)
        {
            $.gumboTray(banners);
            $('.banners').gumboBanner($('.productImages img').index(this));
        }
    });

    $('.tabs').gumboTabs();
</script>

<?php if(count($product->images) > 1):?>
<script id="banners" type="text/template">
    <div class="banners">
        <?php
        foreach($product->images as $image):?>
                <div class="banner" style="text-align:center;">
                    <img src="<?php echo base_url('uploads/images/full/'.$image['filename']);?>" style="max-height:600px; margin:auto;"/>
                    <?php if(!empty($image['caption'])):?>
                        <div class="caption">
                            <?php echo $image['caption'];?>
                        </div>
                    <?php endif; ?>
                </div>
        <?php endforeach;?>
        <a class="controls" data-direction="back"><i class="icon-chevron-left"></i></a>
        <a class="controls" data-direction="forward"><i class="icon-chevron-right"></i></a>
        <div class="banner-timer"></div>
    </div>
</script>
<?php endif;?>


<?php if(!empty($product->related_products)):?>
    <div class="page-header" style="margin-top:30px;">
        <h3><?php echo lang('related_products_title');?></h3>
    </div>
    <?php
    $relatedProducts = [];
    foreach($product->related_products as $related)
    {
        $related->images    = json_decode($related->images, true);
        $relatedProducts[] = $related;
    }
    \GoCart\Libraries\View::getInstance()->show('categories/products', ['products'=>$relatedProducts]); ?>

<?php endif;?>