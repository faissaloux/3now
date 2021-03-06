<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\SendPushNotification;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeInvalidRequestError;
use Auth;
use Setting;
use Exception;
use App\Models\ {
    BankAccount, Card, User, UserRequests, UserRequestPayment
};
//paypal
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;

class PaymentController extends Controller {
    /**
     * payment for user.
     *
     * @return \Illuminate\Http\Response
     */
    private $_api_context;
    public function __construct() {
        /*PayPal api context */
        $paypal_conf = \Config::get('paypal');
        $PAYPAL_CLIENT_ID = Setting::get('PAYPAL_CLIENT_ID');
        $PAYPAL_SECRET = Setting::get('PAYPAL_SECRET');
        $PAYPAL_MODE = Setting::get('PAYPAL_MODE');
        $paypal_conf['settings']['mode'] = $PAYPAL_MODE;
        $this->_api_context = new ApiContext(new OAuthTokenCredential($PAYPAL_CLIENT_ID, $PAYPAL_SECRET));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function Paypalpayment(Request $request) {
        if ($request->ajax()) {
            $request_id = $request->request_id;
            $payment_id = $request->payment_id;
            $UserRequest = UserRequests::find($request_id);
            $RequestPayment = UserRequestPayment::where('request_id', $request_id)->first();
            $RequestPayment->payment_id = $payment_id;
            $RequestPayment->payment_mode = 'PAYPAL';
            $RequestPayment->save();
            $UserRequest->paid = 1;
            $UserRequest->status = 'COMPLETED';
            $UserRequest->save();
            return response()->json(['message' => trans('api.paid') ]);
        }
    }
    public function payment(Request $request) {
        $this->validate($request, ['request_id' => 'required|exists:user_request_payments,request_id|exists:user_requests,id,user_id,' . Auth::user()->id, ]);
        $UserRequest = UserRequests::find($request->request_id);
        $UserRequest = UserRequests::find($request->request_id);
        if ($UserRequest->paid == 1) {
            return response()->json(['error' => 'Request already Paid !']);
        }
        if ($UserRequest->payment_mode == 'CARD') {
            $RequestPayment = UserRequestPayment::where('request_id', $request->request_id)->first();
            try {
                $RequestPayment->payment_id = $request->m_id;
                $RequestPayment->payment_mode = 'CARD';
                $RequestPayment->save();
                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();
                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.paid') ]);
                } else {
                    return redirect('dashboard')->with('flash_success', 'Paid');
                }
            }
            catch(StripeInvalidRequestError $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
            catch(Exception $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
        }
        if ($UserRequest->payment_mode == 'PAYPAL') {
            Session::put('request_id', $request->request_id);
            $RequestPayment = UserRequestPayment::where('request_id', $request->request_id)->first();
            $total_amount = $RequestPayment->total;
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $item_1 = new Item();
            $item_1->setName('Item 1')
            /** item name **/->setCurrency('EUR')->setQuantity(1)->setPrice($total_amount);
            /** unit price **/
            $item_list = new ItemList();
            $item_list->setItems(array($item_1));
            $amount = new Amount();
            $amount->setCurrency('EUR')->setTotal($total_amount);
            $transaction = new Transaction();
            $transaction->setAmount($amount)->setItemList($item_list)->setDescription('Your transaction description');
            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(URL::route('papal.payment.status'))
            /** Specify return URL **/->setCancelUrl(URL::route('papal.payment.status'));
            $payment = new Payment();
            $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));
            try {
                $payment->create($this->_api_context);
            }
            catch(\PayPal\Exception\PPConnectionException $ex) {
                if (\Config::get('app.debug')) {
                    \Session::put('error', 'Connection timeout');
                    return Redirect::route('user.dashboard');
                } else {
                    \Session::put('error', 'Some error occur, sorry for inconvenient');
                    return Redirect::route('user.dashboard');
                }
            }
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());
            if ($request->ajax()) {
                Session::put('paypal_payment_type', 'ajax');
            } else {
                Session::put('paypal_payment_type', 'web');
            }
            if (isset($redirect_url)) {
                /** redirect to paypal **/
                return Redirect::away($redirect_url);
            }
            \Session::put('error', 'Unknown error occurred');
            return Redirect::route('user.dashboard');
        }
        if ($request->ajax()) {
            $request_id = $request->request_id;
            $payment_id = $request->payment_id;
            $UserRequest = UserRequests::find($request_id);
            $RequestPayment = UserRequestPayment::where('request_id', $request_id)->first();
            $RequestPayment->payment_id = $payment_id;
            $RequestPayment->payment_mode = 'PAYPAL';
            $RequestPayment->save();
            $UserRequest->paid = 1;
            $UserRequest->status = 'COMPLETED';
            $UserRequest->save();
            return response()->json(['message' => trans('api.paid') ]);
        }
    }
    public function paymentStripeNew(Request $request) {
        $this->validate($request, ['request_id' => 'required|exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,' . Auth::user()->id]);
        $UserRequest = UserRequests::find($request->request_id);
        if ($UserRequest->paid == 1) {
            return response()->json(['error' => 'Request already Paid !']);
        }
        if ($UserRequest->payment_mode == 'CARD') {
            $RequestPayment = UserRequestPayment::where('request_id', $request->request_id)->first();
            $total = $RequestPayment->total;
            if (isset($UserRequest->tips)) {
                $total = $total + $UserRequest->tips;
            }
            $StripeCharge = $total * 100;
            try {
                $Card = Card::where('user_id', Auth::user()->id)->where('is_default', 1)->first();
                Stripe::setApiKey(Setting::get('stripe_secret_key'));
                $Charge = Charge::create(array("amount" => $StripeCharge, "currency" => "EUR", "customer" => Auth::user()->stripe_cust_id, "card" => $Card->card_id, "description" => " Payment Charge for 3now :" . Auth::user()->email, "receipt_email" => Auth::user()->email));
                $RequestPayment->payment_id = $Charge["id"];
                $RequestPayment->payment_mode = 'CARD';
                $RequestPayment->save();
                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();
                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.paid') ]);
                } else {
                    return redirect('dashboard')->with('flash_success', 'Paid');
                }
            }
            catch(StripeInvalidRequestError $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
            catch(Exception $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
        }
    }
    public function paymentStripe(Request $request) {
        if (!empty($request->request_id) and !empty($request->payment_id)
        ) {
            return response()->json(['message' => trans('api.paid') ]);
        }
        $this->validate($request, ['request_id' => 'required|exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,' . Auth::user()->id]);
        $UserRequest = UserRequests::find($request->request_id);
        if ($UserRequest->payment_mode == 'CARD') {
            $RequestPayment = UserRequestPayment::where('request_id', $request->request_id)->first();
            $StripeCharge = $RequestPayment->total * 100;
            try {
                $Card = Card::where('user_id', Auth::user()->id)->where('is_default', 1)->first();
                Stripe::setApiKey(Setting::get('stripe_secret_key'));
                $Charge = Charge::create(array("amount" => $StripeCharge, "currency" => "EUR", "customer" => Auth::user()->stripe_cust_id, "card" => $Card->card_id, "description" => "Payment Charge for " . Auth::user()->email, "receipt_email" => Auth::user()->email));
                $RequestPayment->payment_id = $Charge["id"];
                $RequestPayment->payment_mode = 'CARD';
                $RequestPayment->save();
                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();
                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.paid') ]);
                } else {
                    return redirect('dashboard')->with('flash_success', 'Paid');
                }
            }
            catch(StripeInvalidRequestError $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
            catch(Exception $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
        }
        if ($UserRequest->payment_mode == 'PAYPAL') {
            $RequestPayment = UserRequestPayment::where('request_id', $request->request_id)->first();
            $StripeCharge = $RequestPayment->total * 100;
            try {
                $RequestPayment->payment_id = $request->payment_id;
                $RequestPayment->payment_mode = 'PAYPAL';
                $RequestPayment->save();
                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();
                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.paid') ]);
                } else {
                    return redirect('dashboard')->with('flash_success', 'Paid');
                }
            }
            catch(StripeInvalidRequestError $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
            catch(Exception $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
        }
    }
    public function paymentPaypal(Request $request) {
        $this->validate($request, ['request_id' => 'required|exists:user_request_payments,request_id|exists:user_requests,id,paid,0,user_id,' . Auth::user()->id, 'payment_id' => 'required']);
        $UserRequest = UserRequests::find($request->request_id);
        if ($UserRequest->paid == 1) {
            return response()->json(['error' => 'Request already Paid !']);
        }
        if ($UserRequest->payment_mode == 'PAYPAL') {
            $RequestPayment = UserRequestPayment::where('request_id', $request->request_id)->first();
            $StripeCharge = $RequestPayment->total * 100;
            try {
                $RequestPayment->payment_id = $request->payment_id;
                $RequestPayment->payment_mode = 'PAYPAL';
                $RequestPayment->save();
                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();
                if ($request->ajax()) {
                    return response()->json(['message' => trans('api.paid') ]);
                } else {
                    return redirect('dashboard')->with('flash_success', 'Paid');
                }
            }
            catch(StripeInvalidRequestError $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
            catch(Exception $e) {
                if ($request->ajax()) {
                    return response()->json(['error' => $e->getMessage() ], 500);
                } else {
                    return back()->with('flash_error', $e->getMessage());
                }
            }
        }
        if ($request->ajax()) {
            $request_id = $request->request_id;
            $payment_id = $request->payment_id;
            $UserRequest = UserRequests::find($request_id);
            $RequestPayment = UserRequestPayment::where('request_id', $request_id)->first();
            $RequestPayment->payment_id = $payment_id;
            $RequestPayment->payment_mode = 'PAYPAL';
            $RequestPayment->save();
            $UserRequest->paid = 1;
            $UserRequest->status = 'COMPLETED';
            $UserRequest->save();
            return response()->json(['message' => trans('api.paid') ]);
        }
    }
    /**
     * add wallet money for user.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_money(Request $request) {
        $this->validate($request, ['amount' => 'required|integer', 'card_id' => 'required|exists:cards,card_id,user_id,' . Auth::user()->id]);
        try {
            $StripeWalletCharge = $request->amount * 100;
            Stripe::setApiKey(Setting::get('stripe_secret_key'));
            $Charge = Charge::create(array("amount" => $StripeWalletCharge, "currency" => "EUR", "customer" => Auth::user()->stripe_cust_id, "card" => $request->card_id, "description" => "Adding Money for " . Auth::user()->email, "receipt_email" => Auth::user()->email));
            $update_user = User::find(Auth::user()->id);
            $update_user->wallet_balance+= $request->amount;
            $update_user->save();
            Card::where('user_id', Auth::user()->id)->update(['is_default' => 0]);
            Card::where('card_id', $request->card_id)->update(['is_default' => 1]);
            //sending push on adding wallet money
            (new SendPushNotification)->WalletMoney(Auth::user()->id, currency($request->amount));
            if ($request->ajax()) {
                return response()->json(['message' => currency($request->amount) . trans('api.added_to_your_wallet'), 'user' => $update_user]);
            } else {
                return redirect('wallet')->with('flash_success', currency($request->amount) . ' added to your wallet');
            }
        }
        catch(StripeInvalidRequestError $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage() ], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
        catch(Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => $e->getMessage() ], 500);
            } else {
                return back()->with('flash_error', $e->getMessage());
            }
        }
    }
    public function addBankAccount(Request $request) {
        $this->validate($request, [
        'type' => 'required',
        ]);
        $find = BankAccount::where('provider_id', Auth::user()->id)->count();
        if ($find == 0) {
            $r = BankAccount::Create($request->all());
            $r->provider_id = Auth::user()->id;
            $r->save();
            $status = 1;
        } else {
            $status = 0;
            $r = 0;
        }
        return response()->json(['status' => $status, 'data' => $r]);
    }
    public function BankList(Request $request) {
        $find = BankAccount::where('provider_id', Auth::user()->id)->count();
        if ($find != 0) {
            $r = BankAccount::where('provider_id', Auth::user()->id)->get();
            $status = 1;
        } else {
            $status = 0;
            $r = 0;
        }
        return response()->json(['status' => $status, 'data' => $r]);
    }
    public function payment_before_request(Request $request) {
        $this->validate($request, ['total_amount' => 'required', 'req_id' => 'required|numeric', ]);
        try {
            if (Auth::user()->status == 0) {
                $User = Auth::user();
                $User->status = 1;
                $User->save();
                $msg = 'You have succefully paid money for this request';
                $status = 1;
            } else {
                $msg = 'You have already paid money for this request';
                $status = 0;
            }
            if ($request->has('req_id') && $request->req_id > 0) {
                $UserRequest = UserRequests::where('id', $request->req_id)->first();
                if ($UserRequest->status == 'AWAITING') {
                    $UserRequest->status = 'STARTED';
                    $UserRequest->save();
                    (new SendPushNotification)->RideConfirmedToProvider($UserRequest);
                }
            }
            return response()->json(['status' => $status, 'message' => $msg]);
        }
        catch(Exception $e) {
            return response()->json(['error' => $e->getMessage() ], 500);
        }
    }
}