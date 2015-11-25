<div class="page-header">
    <h1 class="page-title"><?php echo lang('cart');?></h1>
</div>
<!--Process cart begin-->
<section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                                <i class="fa fa-shopping-cart fa-lg"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="fa fa-map-marker fa-lg"></i>

                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="fa fa-credit-card fa-lg"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form role="form">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <h5>Step 1</h5>
                        <p class="text-yellow">This is your cart</p>
                        <div id="orderSummary" class="table-responsive shopping-cart-table"></div>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-primary next-step btn-lg round">Next step</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h5>Step 2</h5>
                        <p class="text-yellow">Your address</p>
                        <div class="checkoutAddress">
                        <?php if(!empty($addresses))
                        {
                            $this->show('checkout/address_list', ['addresses'=>$addresses]);
                        }
                        else
                        {
                            ?>
                            <script>
                                $('.checkoutAddress').load('<?php echo site_url('addresses/form');?>');
                            </script>
                            <?php //(new GoCart\Controller\Addresses)->form();
                        }
                        ?>
                        </div>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step btn-lg round">Previous step</button></li>
                            <li><button type="button" class="btn btn-primary next-step btn-lg round">Next step</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h5>Step 3</h5>
                        <p class="text-yellow">Shipping and Payment method</p>
                        <div id="shippingMethod"></div>
                        <div id="paymentMethod"></div>
                        <ul class="list-inline pull-right">
                            <li>
                                <button type="button" class="btn btn-default prev-step btn-lg round">Previous step</button>
                            </li>
                           
                            <li><button type="button" class="btn btn-primary btn-info-full next-step btn-lg round">Next step</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h5>Complete</h5>
                        <p class="text-yellow">You have successfully completed all steps.</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
<!--Process cart end-->



<script>
    var grandTotalTest = <?php echo (GC::getGrandTotal() > 0)?1:0;?>;

    function closeAddressForm(){
        $('.checkoutAddress').load('<?php echo site_url('checkout/address-list');?>');
    }

    function processErrors(errors)
    {
        //scroll to the top
        $('body').scrollTop(0);

        $.each(errors, function(key,val) {

            if(key == 'inventory')
            {
                setInventoryErrors(val);
                $('#summaryErrors').text('<?php echo lang('some_items_are_out_of_stock');?>').show();
            }
            else if(key == 'shipping')
            {
                showShippingError(val);
            }
            else if(key == 'shippingAddress')
            {
                $('#addressError').text('<?php echo lang('error_shipping_address')?>').show();
            }
            else if(key == 'billingAddress')
            {
                $('#addressError').text('<?php echo lang('error_billing_address')?>').show();
            }
        });
    }

    $(document).ready(function(){
        //getBillingAddressForm();
        //getShippingAddressForm();
        //getShippingMethods();
        getCartSummary();
        getPaymentMethods();
    });

    function getCartSummary(callback)
    {
        //update shipping too
        getShippingMethods();

        $('#orderSummary').spin();
        $.post('<?php echo site_url('cart/summary');?>', function(data) {
            $('#orderSummary').html(data);
            if(callback != undefined)
            {
                callback();
            }
        });
    }

    function getShippingMethods()
    {
        $('#shippingMethod').load('<?php echo site_url('checkout/shipping-methods');?>');
    }

    function getPaymentMethods()
    {
        $('#paymentMethod').load('<?php echo site_url('checkout/payment-methods');?>');
    }
</script>
