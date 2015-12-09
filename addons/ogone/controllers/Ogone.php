<?php 
namespace GoCart\Controller;
use Ogone\Passphrase;
use Ogone\Ecommerce\EcommercePaymentRequest;
use Ogone\ShaComposer\AllParametersShaComposer;
use Ogone\FormGenerator\SimpleFormGenerator;
use Ogone\ParameterFilter\ShaInParameterFilter;
//
use Ogone\Ecommerce\EcommercePaymentResponse;
use Ogone\ParameterFilter\ShaOutParameterFilter;


class Ogone extends Front {
    
    private $settings;
    private $customer;
    private $amount;
    public function __construct()
    {
        parent::__construct();
        \CI::lang()->load('ogone');
        $this->settings = \CI::Settings()->get_settings('ogone');
        $this->customer = \GC::getCustomer();
        $this->amount = \GC::getGrandTotal();
    }
    //back end installation functions
    public function checkoutForm()
    {
        
        $passphrase = new Passphrase($this->settings['shain']);
        $shaComposer = new AllParametersShaComposer($passphrase);
        $shaComposer->addParameterFilter(new ShaInParameterFilter); //optional

        $ecommercePaymentRequest = new EcommercePaymentRequest($shaComposer);

        // Optionally set Ogone uri, defaults to TEST account
        //$ecommercePaymentRequest->setOgoneUri(EcommercePaymentRequest::PRODUCTION);

        // Set various params:
        $ecommercePaymentRequest->setPspid($this->settings['pspid']);
        $ecommercePaymentRequest->setOrderid(\GC::submitOrder());
//        $ecommercePaymentRequest->setOrderDescription('@@@@@@@');
        $ecommercePaymentRequest->setEmail($this->customer->email);
        $amount = $this->amount * 100;
        $ecommercePaymentRequest->setAmount(intval($amount)); // in cents
        $ecommercePaymentRequest->setCurrency('EUR');

        // ...

        $ecommercePaymentRequest->validate();

        $formGenerator = new SimpleFormGenerator;
        $data['form'] = $formGenerator->render($ecommercePaymentRequest);
        $this->partial('ogoneCheckoutForm', $data);    
    }
    
    public function Accept()
    {

        $ecommercePaymentResponse = new EcommercePaymentResponse($_REQUEST);

        $passphrase = new Passphrase($this->settings['shaout']);
        $shaComposer = new AllParametersShaComposer($passphrase);
        $shaComposer->addParameterFilter(new ShaOutParameterFilter); //optional

        if($ecommercePaymentResponse->isValid($shaComposer) && $ecommercePaymentResponse->isSuccessful()) {
            $payment = [
                'order_id' => \GC::getAttribute('id'),
                'amount' => $_REQUEST['amount'],
                'status' => 'processed',
                'payment_module' => 'Ogone',
                'description' => lang('charge_with_ogone'),
     
            ];

            \CI::Orders()->savePaymentInfo($payment);

            $orderId = \GC::submitOrder();
            redirect('order-complete/'.$orderId);
            
        }
        else {
            // perform logic when the validation fails
            echo json_encode(['errors'=>$_REQUEST]);
            return false;
        } 
    }

    public function isEnabled()
    {
        $settings = \CI::Settings()->get_settings('ogone');
        return (isset($settings['enabled']) && (bool)$settings['enabled'])?true:false;
    }

    function processPayment()
    {
        $errors = \GC::checkOrder();
        if(count($errors) > 0)
        {
            echo json_encode(['errors'=>$errors]);
            return false;
        }
        else
        {
            $payment = [
                'order_id' => \GC::getAttribute('id'),
                'amount' => \GC::getGrandTotal(),
                'status' => 'processed',
                'payment_module' => 'Ogone',
                'description' => lang('charge_with_ogone')
            ];

            \CI::Orders()->savePaymentInfo($payment);

            $orderId = \GC::submitOrder();

            //send the order ID
            echo json_encode(['orderId'=>$orderId]);
            return false;
        }
    }

    public function getName()
    {
        echo lang('charge_with_ogone');
    }
}
