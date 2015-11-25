<div class="col-lg-12 page-header">
    <h2 class="page-title"><?php echo str_replace('{name}', $customer['firstname'].' '.$customer['lastname'], lang('my_account_page_title'));?></h2>
</div>

<div class="col-lg-6">
        <?php echo form_open('my-account', 'id="accountForm" class="form-horizontal" role="form"'); ?>
            <div class="page-header">
                <h1 class="page-title"><?php echo lang('account_information');?></h1>
            </div>


            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_firstname"><?php echo lang('account_firstname');?></label>
                <div class="col-sm-7">
                    <?php echo form_input(['class'=>'form-control','name'=>'firstname', 'value'=> assign_value('firstname', $customer['firstname'])]);?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_lastname"><?php echo lang('account_lastname');?></label>
                <div class="col-sm-7">
                    <?php echo form_input(['class'=>'form-control','name'=>'lastname', 'value'=> assign_value('lastname', $customer['lastname'])]);?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_email"><?php echo lang('account_email');?></label>
                <div class="col-sm-7">
                    <?php echo form_input(['class'=>'form-control','name'=>'email', 'value'=> assign_value('email', $customer['email'])]);?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_phone"><?php echo lang('account_phone');?></label>
                <div class="col-sm-7">
                    <?php echo form_input(['class'=>'form-control','name'=>'phone', 'value'=> assign_value('phone', $customer['phone'])]);?>
                </div>
            </div>
 
            <div class="form-group">
                <label class="checklist">
                    <input type="checkbox" name="email_subscribe" value="1" <?php if((bool)$customer['email_subscribe']) { ?> checked="checked" <?php } ?>/> <span class="text-orange"><?php echo lang('account_newsletter_subscribe');?></span>
                </label>
            </div>
            <div style="margin:30px 0px 10px; text-align:center;">
                <strong><?php echo lang('account_password_instructions');?></strong>
            </div>
        
            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_password"><?php echo lang('account_password');?></label>
                <div class="col-sm-7">
                    <?php echo form_password(['class'=>'form-control','name'=>'password']);?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_confirm"><?php echo lang('account_confirm');?></label>
                <div class="col-sm-7">
                    <?php echo form_password(['class'=>'form-control','name'=>'confirm']);?>
                </div>
            </div>

        
            <input type="submit" value="<?php echo lang('form_submit');?>" class="btn btn-primary btn-lg round pull-right" />
        </form>
    </div>
<div class="col-lg-6">
        <div class="page-header">
            <h1 class="page-title"><?php echo lang('order_history');?></h1>
        </div>
        <?php if($orders):
            echo $orders_pagination;
        ?>
        <table class="table bordered zebra">
            <thead>
                <tr>
                    <th><?php echo lang('order_date');?></th>
                    <th><?php echo lang('order_number');?></th>
                    <th><?php echo lang('order_status');?></th>
                </tr>
            </thead>

            <tbody>
            <?php
            foreach($orders as $order): ?>
                <tr>
                    <td>
                        <?php $d = format_date($order->ordered_on); 
                
                        $d = explode(' ', $d);
                        echo $d[0].' '.$d[1].', '.$d[3];
                
                        ?>
                    </td>
                    <td><a href="<?php echo site_url('order-complete/'.$order->order_number); ?>"><?php echo $order->order_number; ?></a></td>
                    <td><?php echo $order->status;?></td>
                </tr>
        
            <?php endforeach;?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="alert yellow"><i class="close"></i><?php echo lang('no_order_history');?></div>
        <?php endif;?>

</div>

<script>
$(document).ready(function(){
    loadAddresses();
});

function closeAddressForm()
{
    $.gumboTray.close();
    loadAddresses();
}

function loadAddresses()
{
    $('#addresses').spin();
    $('#addresses').load('<?php echo base_url('addresses');?>');
}
</script>