<?php 
namespace GoCart\Controller;
use Ogone\Passphrase;
use Ogone\Ecommerce\EcommercePaymentRequest;
use Ogone\ShaComposer\AllParametersShaComposer;
use Ogone\FormGenerator\SimpleFormGenerator;

$passphrase = new Passphrase('my-sha-in-passphrase-defined-in-ogone-interface');
    $shaComposer = new AllParametersShaComposer($passphrase);
    $shaComposer->addParameterFilter(new ShaInParameterFilter); //optional

    $ecommercePaymentRequest = new EcommercePaymentRequest($shaComposer);

    // Optionally set Ogone uri, defaults to TEST account
    //$ecommercePaymentRequest->setOgoneUri(EcommercePaymentRequest::PRODUCTION);

    // Set various params:
    $ecommercePaymentRequest->setOrderid('123456');
    $ecommercePaymentRequest->setAmount(150); // in cents
    $ecommercePaymentRequest->setCurrency('EUR');
    // ...

    $ecommercePaymentRequest->validate();

    $formGenerator = new SimpleFormGenerator;
    $html = $formGenerator->render($ecommercePaymentRequest);
    // Or use your own generator. Or pass $ecommercePaymentRequest to a view
class Ogone extends Front {

    public function __construct()
    {
        parent::__construct();
        \CI::lang()->load('ogone');
    }

    //back end installation functions
    public function checkoutForm()
    {
        //set a default blank setting for flatrate shipping
        $this->partial('ogoneCheckoutForm');    
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
