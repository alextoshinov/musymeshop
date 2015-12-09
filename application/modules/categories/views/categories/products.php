<?php if(count($products) == 0):?>

    <h2 style="margin:50px 0px; text-align:center; line-height:30px;">
        <?php echo lang('no_products');?>
    </h2>

<?php else:?>

   
    <?php foreach($products as $product):?>
        <div class="col-lg-4 col-md-4 col-sm-6">
            <?php
            $photo  = theme_img('no_picture.png');

            if(!empty($product->images[0]))
            {
                $primary    = $product->images[0];
                foreach($product->images as $photo)
                {
                    if(isset($photo['primary']))
                    {
                        $primary    = $photo;
                    }
                }

                $photo  = base_url('uploads/images/medium/'.$primary['filename']);
            }
            ?>
            <div onclick="window.location = '<?php echo site_url('/product/'.$product->slug); ?>'" class="categoryItem" >
                               
                <div class="previewImg"><img src="<?php echo $photo;?>" width="300" height="257"></div>
                <div class="row">
                    <div class="col-lg-7">
                        <h5 class="categoryItemDetails"><?php echo $product->name;?></h5>
                        <span class="descItem">Gift Bundle</span>
                        <h3 class="badge label-success">
                            <?php if((bool)$product->track_stock && $product->quantity < 1 && config_item('inventory_enabled')):?>
                                <?php echo lang('out_of_stock');?>
                            <?php elseif($product->saleprice > 0):?>
                                <?php echo lang('on_sale');?>
                            <?php endif;?> 
                        </h3>
                    </div>
                    <div class="col-lg-5">
                        <?php if(!$product->is_giftcard): //do not display this if the product is a giftcard?>
                        <div class="price">
                            <div class="price-text"><?php echo ( $product->saleprice > 0 ? $product->saleprice:$product->price);?></div>
                            <span class="currency">&nbsp;EUR</span>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="col-lg-12">
                        <br />
                        <button type="button" class="btn btn-primary btn-lg round">
                            <i class="fa fa-shopping-cart fa-lg"></i>
                            <?php echo lang('form_add_to_cart');?>
                        </button>
                    </div>                    
                </div>
            </div>
        </div>
    <?php endforeach;?>
    

<?php endif;?>