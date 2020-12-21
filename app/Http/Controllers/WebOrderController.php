<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Chatroom;
use DB;
use Log;
use Auth;
use Hash;
use Storage;
use Setting;
use Exception;
use Notification;
use Mail; 
use App\Chat;
use Carbon\Carbon;
use App\Http\Controllers\SendPushNotification;
use App\Notifications\ResetPasswordOTP;
use App\Helpers\Helper;
use App\PushNotification;
use App\Card;
use App\Zones;
use App\User;
use App\Provider;
use App\Settings;
use App\Promocode;
use App\ServiceType;
use App\UserRequests;
use App\RequestFilter;
use App\PromocodeUsage;
use App\ProviderService;
use App\UserRequestRating;
use App\Http\Controllers\ProviderResources\TripController;
use App\UserLocationType;
use App\UserComplaint;
use App\FareSetting;
use App\PeakAndNight;
use App\UserRequestPayment;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeInvalidRequestError;
use App\WebRequests;


//paypal 
use PayPal\Api\Amount;
use PayPal\Api\Details;
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



/*
* *  1 ) email function , send email to user & admin ( copy paste in 3 minutes )
* *  2 ) save the request in database ( copy pase in  3 min )
* *  3 ) make the Stripe payement
* *  4 ) get all the info from order
* *  5 ) save every thing in the form to resend it again
* *
* 
 */





class WebOrderController extends Controller {

    private $user_id ;
    private $method ;
    private $total ;
    private $distance ;
    private $_api_context;


    public function __construct() {
        
        $paypal_conf                     = \Config::get('paypal');  
        $PAYPAL_CLIENT_ID                = Setting::get('PAYPAL_CLIENT_ID');
        $PAYPAL_SECRET                   = Setting::get('PAYPAL_SECRET');
        $PAYPAL_MODE                     = Setting::get('PAYPAL_MODE');
        $paypal_conf['settings']['mode'] = $PAYPAL_MODE;
       
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $PAYPAL_CLIENT_ID,
            $PAYPAL_SECRET)
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }


    public function stripePost(Request $request){
            
            
           Stripe::setApiKey(env('STRIPE_SECRET')); 

          

           try {
                $charge = \Stripe\Charge::create ([
                        "amount" => $UserRequests->total * 100 ,
                        "currency" => "EUR",
                        "source" => $_POST['my_stripeToken'],
                        "description" => "payment from 3now.de " 
                ]);
                $success = 1;
                $paymentProcessor="Credit card (www.stripe.com)";
            } catch(Stripe_CardError $e) {
              $error = $e->getMessage();
            } catch (Stripe_InvalidRequestError $e) {
              // Invalid parameters were supplied to Stripe's API
              $error = $e->getMessage();
            } catch (Stripe_AuthenticationError $e) {
              // Authentication with Stripe's API failed
              $error = $e->getMessage();
            } catch (Stripe_ApiConnectionError $e) {
              // Network communication with Stripe failed
              $error = $e->getMessage();
            } catch (Stripe_Error $e) {
              // Display a very generic error to the user, and maybe send
              // yourself an email
              $error = $e->getMessage();
            } catch (Exception $e) {
              // Something else happened, completely unrelated to Stripe
              $error = $e->getMessage();
            }

            if($error){
                die($error);
                exit;
                
            }else {
                 $request_id    = Session::get('request_web_id');
           $UserRequests  = UserRequests::find($request_id);
           $UserRequests->payment_mode = 'CARD';
           $UserRequests->paid = 1;
           $UserRequests->save();
                die('Payment successful');
                exit;
            }
    
            
    }


    public function assignRequestToProvider(Request $request){
        $provider = $_POST['provider'];
        $request = $_POST['request'];
        $order = UserRequests::find($request);
        $order->provider_id = $provider;
        $order->current_provider_id = $provider;
        $order->save(); 
    }



    public function SendEmail(Request $request){

        $UserRequest = \App\UserRequests::with('user','payment','provider','service_type')->findOrFail($_POST['request']);

        $user = [ 
                        'email'     =>  $UserRequest->emailadress,
                        'name'      =>  $UserRequest->user->first_name,
                        'total_fee' =>  $UserRequest->payment->fixed,
                        'invoice_id'=>  $UserRequest->booking_id,
                        's_address' =>  $UserRequest->s_address,
                        'd_address' =>  $UserRequest->d_address,
                        'date'      =>  date('d-m-Y'),
                        'car'      =>   $UserRequest->service_type->name,
                        's_address'      =>   $UserRequest->s_address,
                        'd_address'      =>   $UserRequest->d_address,
        ];



        $url = 'https://api.elasticemail.com/v2/email/send';
        try{
                $post = array('from' => 'contact@3now.de',
                'fromName' => '3now',
                'apikey' => '9ECAE3B0E7E28B94621D30D634B0238ACC12BE45DA5CC17DEC385C99EE08C9212403CDE46FE482701696293D221895D8',
                'subject' => 'Buchungsbestätigung',
                'to' => $user['email'],
                'bodyHtml' => view("emails.invoice_scheudle_website", ['user' => $user,'full_order' => $UserRequest]),
                'isTransactional' => false);

                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $post,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER => false,
                    CURLOPT_SSL_VERIFYPEER => false
                ));

                $result=curl_exec ($ch);
                curl_close ($ch);

                print_r($result);

        }
        catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

  

 


    public function save_order(Request $request){

        $total = $request->total;

        $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=AIzaSyAaCcYWO2ClnRd-ZSlDnW17Jh2jnBatCmg";

        $json = curl($details);
        $details = json_decode($json, TRUE);
        $route_key  = $details['routes'][0]['overview_polyline']['points'];
        $booking_id = Helper::generate_booking_id();

        $UserRequest                      = new UserRequests;
        $UserRequest->booking_id          = $booking_id;
        $UserRequest->user_id             = 463;
        $UserRequest->provider_id         = 136;
        $UserRequest->current_provider_id = 136;
        $UserRequest->service_type_id     = 19;
        $UserRequest->payment_mode        = 'CASH';
        $UserRequest->promo_code          =  $request->promo_code;
        $UserRequest->status              = 'SCHEDULED';
        $UserRequest->s_address           = $request->s_address ? : "";
        $UserRequest->d_address           = $request->d_address ? : "";
        $UserRequest->going_at            = $request->from ? : "";
        $UserRequest->return_at           = $request->to ? : "";
        $UserRequest->nameshield_name     = $request->namensschield_desc ? : "";
        $UserRequest->nameschield         = $request->namensschield_active ? : "";
        $UserRequest->s_latitude          = $request->s_latitude;
        $UserRequest->s_longitude         = $request->s_longitude;
        $UserRequest->d_latitude          = $request->d_latitude;
        $UserRequest->d_longitude         = $request->d_longitude;
        $UserRequest->distance            = $request->distance;
        $UserRequest->kindersitz          = $request->kindersitz;
        $UserRequest->babyschale          = $request->babyschale;
        $UserRequest->note                = $request->bemerkungen;
        $UserRequest->assigned_at         = Carbon::now();
        $UserRequest->route_key           = $route_key;
        $UserRequest->total               = $total;
        $UserRequest->surge               = 0;

        $UserRequest->vorname             = $request->vorname;
        $UserRequest->nachname            = $request->nachname;
        $UserRequest->handynummer         = $request->eingeben;
        $UserRequest->emailadress         = $request->emailadress;


  
        $UserRequest->save();
    
        Session::set('request_web_id', $UserRequest->id);

        // save the payement
        $Payment               = new UserRequestPayment;
        $Payment->request_id   = $UserRequest->id;
        $Payment->fixed        = $request->total;
        $Payment->distance     = $request->distance;
        $Payment->payment_mode = NULL;
        $Payment->total        = $request->total;
        $Payment->save();

    }



    public function thankyou(Request $request) {
       return view('thankyou');
    }



    public function success(Request $request) {

            $payment_id = Session::get('paypal_payment_id');

            Session::forget('paypal_payment_id');

            if (empty($_GET['PayerID']) || empty($_GET['token'])) {
                \Session::put('error', 'Payment failed');
                return Redirect::route('/');
            }

            
            $execution = new PaymentExecution();
            $execution->setPayerId($_GET['PayerID']);
            $payment = Payment::get($payment_id, $this->_api_context);
            $result = $payment->execute($execution, $this->_api_context);


            if ($result->getState() == 'approved') {



                $request_id    = Session::get('request_web_id');
                $UserRequests  = UserRequests::find($request_id);
                $UserRequests->payment_mode = 'PAYPAL';
                $UserRequests->paid = 1;
                $UserRequests->payment_id = $payment_id;
                $UserRequests->save();
                return Redirect::route('paypal.thankyou');

            }else {

                \Session::put('error', 'Payment failed');
                return Redirect::route('/');
            }
    }









         
    


    public function faild(Request $request) {
        redirect('/');
    }


    public function iospaypalSuccess(Request $request) {


            $payment_id = Session::get('paypal_payment_id');

            Session::forget('paypal_payment_id');

            if (empty($_GET['PayerID']) || empty($_GET['token'])) {
                 return response()->json(['paypal'=> 'failed']);
            }
            
            $execution = new PaymentExecution();
            $execution->setPayerId($_GET['PayerID']);
            $payment = Payment::get($payment_id, $this->_api_context);
            $result = $payment->execute($execution, $this->_api_context);


            if ($result->getState() == 'approved') {
                $request_id    = Session::get('request_ios_id');
                $UserRequests  = UserRequests::find($request_id);
                $UserRequests->payment_mode = 'PAYPAL';
                $UserRequests->status = 'COMPLETED';
                $UserRequests->paid = 1;
                $UserRequests->save();


                $user_payment  = UserRequestPayment::where('request_id',$request_id)->first();


                if($user_payment->count() > 0 ){
                    $user_payment->payment_mode = 'PAYPAL';
                    $user_payment->fixed = $UserRequests->total;
                    $user_payment->payment_id = $payment_id;
                    $user_payment->save();
                }else {
                    $UserRequestPayment = new UserRequestPayment();
                    $UserRequestPayment->payment_mode = 'PAYPAL';
                    $UserRequestPayment->fixed = $UserRequests->total;
                    $UserRequestPayment->payment_id = $payment_id;
                    $UserRequestPayment->request_id = $request_id;
                    $UserRequestPayment->save();
                }

        
                return response()->json(['paypal'=> 'succces']);
            }

           return response()->json(['paypal'=> 'failed']);    
          
    }


    
    public function iospaypalFailed(Request $request) {
       return response()->json(['paypal'=> 'failed']);
    }
    


    public function iospaypal(){

        $UserRequests  = UserRequests::find($_GET['request']);

        $tips = $UserRequests->tips ?? 0;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
 
        $total = $UserRequests->total + $tips;
        
        $item_1 = new Item();
 
        $item_1->setName('Item 1') 
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($total); 
 
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
 
        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal($total);
    

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');
 
        $redirect_urls = new RedirectUrls();



        $redirect_urls->setReturnUrl(URL::route('ios.paypal.success')) 
            ->setCancelUrl(URL::route('ios.paypal.faild'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));

        try {

            $payment->create($this->_api_context);

        } 
        catch (\PayPal\Exception\PPConnectionException $ex) {
            echo $ex->getMessage();
        }
                    

        \Session::put('request_ios_id',$_GET['request']);

        $approvalUrl = $payment->getApprovalLink();
        $payment->getId();

        Session::put('paypal_payment_id', $payment->getId());

        return Redirect::away($approvalUrl);
    }











    public function payment(Request $request) {

        $request_id    = Session::get('request_web_id');
        $UserRequests  = UserRequests::find($request_id);

        if($request->method == 'paypal') {

                    $payer = new Payer();
                    $payer->setPaymentMethod('paypal');
             
                    $item_1 = new Item();
             
                    $item_1->setName('Item 1') 
                        ->setCurrency('EUR')
                        ->setQuantity(1)
                        ->setPrice($UserRequests->total); 
             
                    $item_list = new ItemList();
                    $item_list->setItems(array($item_1));
             
                    $amount = new Amount();
                    $amount->setCurrency('EUR')
                        ->setTotal($UserRequests->total);
             
                    $transaction = new Transaction();
                    $transaction->setAmount($amount)
                        ->setItemList($item_list)
                        ->setDescription('Your transaction description');
             
                    $redirect_urls = new RedirectUrls();
                    $redirect_urls->setReturnUrl(URL::route('paypal.success')) 
                        ->setCancelUrl(URL::route('paypal.faild'));

             
                    $payment = new Payment();
                    $payment->setIntent('Sale')
                        ->setPayer($payer)
                        ->setRedirectUrls($redirect_urls)
                        ->setTransactions(array($transaction));

                    try {

                        $payment->create($this->_api_context);

                    } 
                    catch (\PayPal\Exception\PPConnectionException $ex) {
             
                        if (\Config::get('app.debug')) {
             
                            \Session::put('error', 'Connection timeout');
                            return Redirect::route('user.dashboard');
             
                        } else {

                            \Session::put('error', 'Some error occur, sorry for inconvenient');
                            return Redirect::route('user.dashboard');
                        }
             
                    }
                    
                    Session::put('paypal_payment_id', $payment->getId());
                    $approvalUrl = $payment->getApprovalLink();
                    return Redirect::away($approvalUrl);

        }

    }


    public function getOrder(Request $request){
        $UserRequest = UserRequests::findOrFail($request->id);
        return response()->json($UserRequest);
    }



    public function getPricesBasedOnKilomters($kilometer){
          $prices = [
                'distance'  => $kilometer, 
                'c-klasse' => round((($kilometer * 1.25) + 15), 2) , 
                'e-klasse' => round((($kilometer * 1.35) + 20), 2) , 
                'vito'     => round((($kilometer * 1.40) + 25), 2) , 
                'v-klasse'  => round((($kilometer * 1.50) + 30), 2) 
          ];
          return $prices;
    }


    public function getPricesBasedOnKilomtersWithBack($kilometer){
          $prices = [
                'distance'  => $kilometer, 
                'c-klasse' => round(((($kilometer * 1.25) + 15) *  2 ), 2) , 
                'e-klasse' => round(((($kilometer * 1.35) + 20) *  2 ), 2) , 
                'vito'     => round(((($kilometer * 1.40) + 25) *  2 ), 2) , 
                'v-klasse'  => round(((($kilometer * 1.50) + 30) *  2 ), 2) 
          ];
          return $prices;
    }


    public function user_check_email(Request $request) {

        $this->validate($request,[
                'email' => 'required|email',
        ]);

        if(!empty($request->email)){

            $email = $request->email;
            $user = User::where('email',$request->email)->first();

           // DB::table('testing_table')->insert(['ip' => \Request::ip()]);

            if($user) {
                return response()->json([ 'error' => 'false' , 'id' => $user->id , 'phone' => $user->mobile ]);
            }else {
                return response()->json([ 'error' => 'true']);
            }
        }
        
        return response()->json([ 'error' => 'true']);
    
    }


    public function provider_check_email(Request $request) {

        $this->validate($request,[
                'email' => 'required|email',
        ]);

        if(!empty($request->email)){

            $email = $request->email;
            $user = Provider::where('email',$request->email)->first();

          

            if($user) {
                return response()->json([ 'error' => 'false' , 'id' => $user->id , 'phone' => $user->mobile ]);
            }else {
                return response()->json([ 'error' => 'true']);
            }
        }
        
        return response()->json([ 'error' => 'true']);

    }


    public function user_update_password(Request $request) {

        $this->validate($request, [
                'password' => 'required|min:6',
                'id' => 'required|numeric|exists:users,id'
        ]);

        try{

            $User = User::findOrFail($request->id);
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => 'Password Updated']);
            }

        }catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }
    
    }



    public function provider_update_password(Request $request) {


        $this->validate($request, [
                'password' => 'required|min:6',
                'id' => 'required|numeric|exists:users,id'
            ]);

        try{

            $User = Provider::findOrFail($request->id);
            $User->password = bcrypt($request->password);
            $User->save();

            if($request->ajax()) {
                return response()->json(['message' => 'Password Updated']);
            }

        }catch (Exception $e) {
            if($request->ajax()) {
                return response()->json(['error' => trans('api.something_went_wrong')]);
            }
        }      
    }


    public function getPrices(Request $request) {

        $this->validate($request,[
                's_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
        ]);

        try{

            $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->s_latitude.",".$request->s_longitude."&destinations=".$request->d_latitude.",".$request->d_longitude."&mode=driving&sensor=false&key=AIzaSyAaCcYWO2ClnRd-ZSlDnW17Jh2jnBatCmg";

            $json = curl($details);

            $details = json_decode($json, TRUE);

            $meter = $details['rows'][0]['elements'][0]['distance']['value'];
            $time = $details['rows'][0]['elements'][0]['duration']['text'];
            $seconds = $details['rows'][0]['elements'][0]['duration']['value'];

            $kilometer = round($meter/1000);
            $minutes = round($seconds/60);

            if(empty($request->to)){
                    $prices = $this->getPricesBasedOnKilomters($kilometer);
            }else {
                $prices = $this->getPricesBasedOnKilomtersWithBack($kilometer);
            }

            return response()->json($prices);

        
        } catch(Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    public function saveOrder($request) {


        $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=AIzaSyAaCcYWO2ClnRd-ZSlDnW17Jh2jnBatCmg";

        $json = curl($details);
        $details = json_decode($json, TRUE);
        $route_key  = $details['routes'][0]['overview_polyline']['points'];
        $booking_id = Helper::generate_booking_id();


        $UserRequest = new UserRequests;
        $UserRequest->booking_id = $booking_id;
        $UserRequest->user_id = $this->user_id;
        $UserRequest->provider_id = 136;
        $UserRequest->current_provider_id = 136;
        $UserRequest->service_type_id = 19;
        $UserRequest->payment_mode = $this->method;
        $UserRequest->promo_code =  $request->promo_code;

        $UserRequest->status = 'SCHEDULED';

        $UserRequest->s_address = $request->s_address ? : "";
        $UserRequest->d_address = $request->d_address ? : "";

        $UserRequest->s_latitude = $request->s_latitude;
        $UserRequest->s_longitude = $request->s_longitude;

        $UserRequest->d_latitude = $request->d_latitude;
        $UserRequest->d_longitude = $request->d_longitude;
        $UserRequest->distance = $request->distance;

        $UserRequest->kindersitz  = $request->kindersitz;
        $UserRequest->babyschale  = $request->babyschale;
        $UserRequest->nameschield = $request->nameschield;
        $UserRequest->note        = $request->bemerkungen;


        $UserRequest->assigned_at = Carbon::now();
        $UserRequest->route_key = $route_key;
        $UserRequest->total = $request->total;
        $UserRequest->surge = 0;
        
    
        $UserRequest->save();
        
        Session::set('request_web_id', $UserRequest->id);

        return $UserRequest;

    }


    public function savePayement($UserRequest) {
        $Payment               = new UserRequestPayment;
        $Payment->request_id   = $UserRequest->id;
        $Payment->fixed        = $this->total;
        $Payment->distance     = $UserRequest->distance;
        $Payment->payment_mode = $this->method;
        $Payment->total        = $this->total;
        $Payment->save();
    }













    public function contactme(){
        return response()->json(['messgae' => 'success']);
    }



    public function paied() {
        return response()->json(['messgae' => 'paied']);
    }
    
    

    public function getRequest(Request $request){
       $request = UserRequests::find($request->request_id);
       return response()->json(['request' => $request]);
    }

    
    
    
    

    public function calculatePrice(Request $request) {

        

           $kilometer = $request->distance;

           if($request->service_type == '19'){
              $khla = ($kilometer * 1.25) + 25;
              $khla = round($khla, 2);
            }

            if($request->service_type == '27'){
                $khla = ($kilometer * 1.35) + 35;
                $khla = round($khla, 2);
            }

            if($request->service_type == '32'){
                $khla = ($kilometer * 1.40) + 40;
                $khla = round($khla, 2);
            }


            if($request->kindersitz > 1 ){
                $khla  += (($request->kindersitz * 5 ) - 5);
            }


            if($request->babyschale > 1 ){
                $khla  += (($request->babyschale * 10 ) - 10 );
            }
            

            if ($request->nameschield == 'true' ) {
                $khla  += 15;
            }

            return response()->json([ 'price' => $khla ]);

    }




        public function send_schedule_payment(Request $request){
                
                $Payment               = new UserRequestPayment;
                $Payment->request_id   = $request->request_id;
                $Payment->fixed        = $request->total_payment;
                $Payment->distance     = $request->distance;
                $Payment->payment_mode = $request->method;
                $Payment->total        = $request->total_payment;

                if($request->has('payment_id')){
                $Payment->payment_id = $request->payment_id;
                }

                $Payment->save();


                $UserRequest = UserRequests::with('user','payment','provider','service_type')->findOrFail($request->request_id);


                $user = [ 
                            'email'     =>  $UserRequest->user->email,
                            'name'      =>  $UserRequest->user->first_name,
                            'total_fee' =>  $UserRequest->payment->fixed,
                            'invoice_id'=>  $UserRequest->booking_id,
                            's_address' =>  $UserRequest->s_address,
                            'd_address' =>  $UserRequest->d_address,
                            'date'      =>  date('d-m-Y'),
                            'car'      =>   $UserRequest->service_type->name,
                            's_address'      =>   $UserRequest->s_address,
                            'd_address'      =>   $UserRequest->d_address,
                ];


                Mail::send('emails.invoice_scheudle', ['user' => $user,'full_order' => $UserRequest], function ($m) use ($user) {
                    $m->from('contact@3now.de');
                    $m->to($user['email'], $user['name'])->subject('Buchungsbestätigung');
                });

                return response()->json(['success' => 'paied']);

        }


    






}
