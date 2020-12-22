<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Setting;
use App\Models\ {
    UserRequests, UserRequestPayment
};
//paypal
use PayPal\Api\Amount;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;

class IosController extends Controller {
    private $user_id;
    private $method;
    private $total;
    private $distance;
    private $_api_context;
    public function __construct() {
        $paypal_conf = \Config::get('paypal');
        $PAYPAL_CLIENT_ID = Setting::get('PAYPAL_CLIENT_ID');
        $PAYPAL_SECRET = Setting::get('PAYPAL_SECRET');
        $PAYPAL_MODE = Setting::get('PAYPAL_MODE');
        $paypal_conf['settings']['mode'] = $PAYPAL_MODE;
        $this->_api_context = new ApiContext(new OAuthTokenCredential($PAYPAL_CLIENT_ID, $PAYPAL_SECRET));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function iospaypalSuccess(Request $request) {
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        if (empty($_GET['PayerID']) || empty($_GET['token'])) {
            return response()->json(['paypal' => 'failed']);
        }
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        $payment = Payment::get($payment_id, $this->_api_context);
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            $request_id = Session::get('request_ios_id');
            $UserRequests = UserRequests::find($request_id);
            $UserRequests->payment_mode = 'PAYPAL';
            $UserRequests->paid = 1;
            $UserRequests->save();
            $UserRequestPayment = new UserRequestPayment();
            $UserRequestPayment->payment_mode = 'PAYPAL';
            $UserRequestPayment->fixed = $UserRequests->total;
            $UserRequestPayment->payment_id = $payment_id;
            $UserRequestPayment->save();
            return response()->json(['paypal' => 'succces']);
        }
        return response()->json(['paypal' => 'failed']);
    }
    public function iospaypalFailed(Request $request) {
        return response()->json(['paypal' => 'failed']);
    }
    public function iospaypal() {
        $UserRequests = UserRequests::find($_GET['request']);
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1')->setCurrency('EUR')->setQuantity(1)->setPrice($UserRequests->total);
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('EUR')->setTotal($UserRequests->total);
        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($item_list)->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('ios.paypal.success'))->setCancelUrl(URL::route('ios.paypal.faild'));
        $payment = new Payment();
        $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);
        }
        catch(\PayPal\Exception\PPConnectionException $ex) {
            echo $ex->getMessage();
        }
        \Session::put('request_ios_id', $_GET['request']);
        $approvalUrl = $payment->getApprovalLink();
        $payment->getId();
        Session::put('paypal_payment_id', $payment->getId());
        return Redirect::away($approvalUrl);
    }
}