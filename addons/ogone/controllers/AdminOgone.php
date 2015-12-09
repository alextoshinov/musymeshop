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
        \CI::Settings()->save_settings('ogone', array(
            'enabled'=>'1',
            'pspid'=>'mypspID',
            'shain'=>'mySHA1IN',
            'shaout'=>'mySHA1OUT'
            ));

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
        \CI::form_validation()->set_rules('pspid', 'lang:your_seller_id', 'trim');
        \CI::form_validation()->set_rules('shain', 'lang:SHA-1-IN', 'trim');
        \CI::form_validation()->set_rules('shaout', 'lang:SHA-1-OUT', 'trim');
        if (\CI::form_validation()->run() == FALSE)
        {
            $settings = \CI::Settings()->get_settings('ogone');

            $this->view('ogone_form', $settings);
        }
        else
        {
            \CI::Settings()->save_settings('ogone', \CI::input()->post());
            redirect('admin/payments');
        }
    }
}