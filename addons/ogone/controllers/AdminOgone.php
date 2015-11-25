<?php namespace GoCart\Controller;


class AdminOgone extends Admin { 

    public function __construct()
    {       
        parent::__construct();
        
        \CI::auth()->check_access('Admin', true);
        \CI::lang()->load('ogone');
    }

    //back end installation functions
    public function install()
    {
        //set a default blank setting for flatrate shipping
        \CI::Settings()->save_settings('payment_modules', array('ogone'=>'1'));
        \CI::Settings()->save_settings('ogone', array('enabled'=>'1'));

        redirect('admin/payments');
    }

    public function uninstall()
    {
        \CI::Settings()->delete_setting('payment_modules', 'ogone');
        \CI::Settings()->delete_settings('ogone');
        redirect('admin/payments');
    }

    //admin end form and check functions
    public function form()
    {
        //this same function processes the form
        \CI::load()->helper('form');
        \CI::load()->library('form_validation');

        \CI::form_validation()->set_rules('enabled', 'lang:enabled', 'trim|numeric');

        if (\CI::form_validation()->run() == FALSE)
        {
            $settings = \CI::Settings()->get_settings('ogone');
            $enabled = $settings['enabled'];

            $this->view('ogone_form', ['enabled'=>$enabled]);
        }
        else
        {
            \CI::Settings()->save_settings('ogone', array('enabled'=>$_POST['enabled']));
            redirect('admin/payments');
        }
    }
}