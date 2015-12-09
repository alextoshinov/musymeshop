<div class="page-header">
    <h2><?php echo lang('charge_with_ogone');?></h2>
</div>

<?php echo form_open_multipart('admin/ogone/form'); ?>
<div class="row">
<div class="col-md-6">
<div class="form-group">
    <label for="enabled"><?php echo lang('enabled');?> </label>
    <?php echo form_dropdown('enabled', array('0' => lang('disabled'), '1' => lang('enabled')), assign_value('enabled',$enabled), 'class="form-control"'); ?>    
</div>
<div class="form-group">
    <label for="pspid"><?php echo lang('your_seller_id');?> </label>
    <?php echo form_input(['name'=>'pspid', 'value'=>assign_value('pspid', $pspid), 'class' => 'form-control' ]); ?>
</div>  
<div class="form-group">
    <label for="shain"><?php echo lang('SHA-1-IN');?> </label>
    <?php echo form_input(['name'=>'shain', 'value'=>assign_value('shain', $shain), 'class' => 'form-control' ]); ?>
</div> 
<div class="form-group">
    <label for="shaout"><?php echo lang('SHA-1-OUT');?> </label>
    <?php echo form_input(['name'=>'shaout', 'value'=>assign_value('shaout', $shaout), 'class' => 'form-control' ]); ?>
</div>    
<div class="form-actions">
    <button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
</div>
</div>    
</div>    
</form>

<script type="text/javascript">
$('form').submit(function() {
    $('.btn .btn-primary').attr('disabled', true).addClass('disabled');
});
</script>