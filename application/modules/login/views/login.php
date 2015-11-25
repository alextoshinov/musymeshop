    <div class="col-lg-6">
        <div class="page-header">
            <h1 class="page-title"><?php echo lang('login');?></h1>
        </div>
        <?php echo form_open('login/'.$redirect, 'id="loginForm" class="form-horizontal" role="form"'); ?>

            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="email"><?php echo lang('email');?></label>
                <div class="col-sm-7">
                    <input type="text" name="email" class="form-control" placeholder="<?php echo lang('email');?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="password"><?php echo lang('password');?></label>
                <div class="col-sm-7">
                    <input class="form-control" type="password" name="password" placeholder="<?php echo lang('password');?>"/>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">                    
                    <input name="remember" value="true" type="checkbox" /> 
                    <label class="text-orange"><?php echo lang('keep_me_logged_in');?></label>
                </div>
            </div> 
            <button type="submit" class="btn btn-primary btn-lg round pull-right">
                <?php echo lang('form_login');?>                                
            </button>
        </form>

        <div style="text-align:center;">
            <a href="<?php echo site_url('forgot-password'); ?>"><?php echo lang('forgot_password')?></a>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="page-header">
            <h1 class="page-title"><?php echo lang('form_register');?></h1>
        </div>
        
        <?php echo form_open('register', 'id="registration_form" class="form-horizontal" role="form"'); ?>
            <input type="hidden" name="submitted" value="submitted" />
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />

            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_firstname"><?php echo lang('account_firstname');?></label>
                <div class="col-sm-7">
                    <?php echo form_input(['class'=>'form-control','name'=>'firstname', 'value'=> assign_value('firstname')]);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_lastname"><?php echo lang('account_lastname');?></label>
                <div class="col-sm-7">    
                    <?php echo form_input(['class'=>'form-control','name'=>'lastname', 'value'=> assign_value('lastname')]);?>
                </div>     
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_email"><?php echo lang('account_email');?></label>
                <div class="col-sm-7">    
                    <?php echo form_input(['class'=>'form-control','name'=>'email', 'value'=>assign_value('email')]);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_phone"><?php echo lang('account_phone');?></label>
                <div class="col-sm-7">  
                    <?php echo form_input(['class'=>'form-control','name'=>'phone', 'value'=> assign_value('phone')]);?>
                </div>
            </div>

            <label class="checklist">
                <input type="checkbox" name="email_subscribe" value="1" <?php echo set_radio('email_subscribe', '1', TRUE); ?>/> <span class="text-orange"><?php echo lang('account_newsletter_subscribe');?></span>
            </label>

            <div class="form-group">
                    <label class="col-sm-5 control-label text-orange" for="account_password"><?php echo lang('account_password');?></label>
                    <div class="col-sm-7"> 
                    <input type="password" name="password" autocomplete="off" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label text-orange" for="account_confirm"><?php echo lang('account_confirm');?></label>
                <div class="col-sm-7">     
                    <input type="password" name="confirm" class="form-control" autocomplete="off" />
                </div>
            </div>
            
            <input type="submit" value="<?php echo lang('form_register');?>" class="btn btn-primary btn-lg round pull-right" />
        </form>
    </div>

    <script>
    <?php if(isset($registrationErrors)):?>

        var formErrors = <?php echo json_encode($registrationErrors);?>
        
        for (var key in formErrors) {
            if (formErrors.hasOwnProperty(key)) {
                $('#registration_form').find('[name="'+key+'"]').parent().append('<div class="form-error text-red">'+formErrors[key]+'</div>');
            }
        }
    <?php endif;?>

    <?php if(isset($loginErrors)):?>

        var formErrors = <?php echo json_encode($loginErrors);?>
        
        for (var key in formErrors) {
            if (formErrors.hasOwnProperty(key)) {
                $('#loginForm').find('[name="'+key+'"]').parent().append('<div class="form-error text-red">'+formErrors[key]+'</div>');
            }
        }
    <?php endif;?>
    </script>
