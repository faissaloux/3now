<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\{ServiceType,Provider,ProviderDocument,PushNotification,Page,ContactUs,Complaint,Blog,LostItem,User};

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SendPushNotification;
use \Carbon\Carbon;
use DateTime;
class CommonController extends Controller
{
    

   public function termsconditions()
    { 
        return view('website.terms');
        
    }
    public function aboutpage()
    { 
        return view('website.about');
        
    }
    public function contactpage()
    { 
        return view('website.contact');
        
    }
    
    public function index(Request $request) {
    	    
		$data['services'] 	=	ServiceType::all();   
		//$details 				=	$this->getIpDetails();
		//$data['services'] 		=	$details['services'];
		//$data['ip_details']		=	$details['ip_details'];
		$data['testimonials']	=	Testimonial::orderBy('id', 'desc')->take(8)->get();
	
		return view('index', ['data' => $data ]);
	}
    public function reset(){
        return view('user.auth.reset');
    }
    public function complaint(){
        $data['message_cats'] = ['test1','test2','test3'];
        return view('pages.complaint', compact('data'));
    }
    public function contact_us(){
        $data['message_cats'] = ['test1','test2','test3'];
        return view('pages.contact_us', compact('data'));
    }
    public function lost_item(){
        return view('pages.lost_item');
    }
 /**
     * update password.
     *
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request){
     
        $this->validate($request,[
            'email'     => 'required|email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
            ]);
        try {
            User::where('email',$request->email)->update(['password' => bcrypt($request->password)]);
             return redirect('PassengerSignin');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    public function provider_password_update(Request $request){
        $this->validate($request,[
            'email'     => 'required|email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
            ]);
        try {
            Provider::where('email',$request->email)->update(['password' => bcrypt($request->password)]);
             return redirect('provider/login');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        } 
    }

    public function contact(Request $request) {

        $json = array();
        
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'message'   => 'required',
            
            ]);
            
        try{
            
            $message = new ContactUs();
            $message->name          =   $request->name;
            $message->email         =   $request->email;
            $message->message       =   $request->message;
                                    
            $message->save();
            
            
            $json['success'] = ( $message->id ) ? true : false;
        
        
        return response()->json( $json );
                
        } catch(Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        
        }
        
    
    }

       public function complaint_form(Request $request) {

        $json = array();
        //$data = str_replace(url('/'), '', url()->previous());
        //dd($data);
        //$u = explode('?', $data);
        //$url = explode('=', $u[1]);
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'transfer'   => 'required',
            'message'   => 'required',
            // 'phone'     => 'required',
            
            ]);
            
        try{
            
            $message = new Complaint();
            $message->name          =   $request->name;
            $message->email         =   $request->email;        
            // $message->subject       =   $request->subject;
            $message->transfer       =   $request->transfer;
            $message->message       =   $request->message;
            //$message->type         =    $url[1];
            
            // if ($request->hasFile('attachment')) {
            //     $file = $request->file('attachment');
            //     $name = time().'.'.$file->getClientOriginalExtension();
            //     $destinationPath = public_path('/uploads');
            //     $file->move($destinationPath, $name);
            //     $message->attachment    =   $name;
            // }
            
            $message->save();
         
            
            $json['success'] = ( $message->id ) ? true : false;
        
        
        return response()->json( $json );
                
        } catch(Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        
        }
        
    
    }

     public function sendMessage(Request $request) {
        $json = array();
        
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'subject'   => 'required',
            'message'   => 'required',
            'phone'     => 'required',
            
            ]);
            
        try{
            
            $message = new ContactUs();
            $message->name          =   $request->name;
            $message->email         =   $request->email;        
            $message->subject       =   $request->subject;
            $message->message       =   $request->message;
            $message->phone         =   $request->phone;
            
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $name = time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path('/uploads');
                $file->move($destinationPath, $name);
                $message->attachment    =   $name;
            }
            
            $message->save();
            
            
            $json['success'] = ( $message->id ) ? true : false;
        
        
        return response()->json( $json );
                
        } catch(Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        
        }
        
    
    }

    public function lostItemForm(Request $request) {
        $json = array();
        
        $this->validate($request,[
            'name'      => 'required',
            'email'     => 'required|email',
            'lost_item'   => 'required',
            'phone'     => 'required',
            ]);
            
        try{
            $message = new LostItem();
            $message->name          =   $request->name;
            $message->email         =   $request->email;        
            $message->lost_item       =   $request->lost_item;
            $message->phone       =   $request->phone;
            $message->save();
            $json['success'] = ( $message->id ) ? true : false;
        
        return response()->json( $json );
                
        } catch(Exception $e) {
            
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        
        }
    
    }
     public function blogs(Request $request){
          $blogs =Blog::orderBy('id','desc')->get();
                    
          return view('pages.blog',compact('blogs'));    
        }

        public function blog_detail($id){
        $blog_detail = Blog::where('id',$id)->first();
          
            return view('pages.blogdetail',compact('blog_detail'));
    }
        public function fare_estimate()
    {
        $services   = ServiceType::all(); 
        $sessiondata = session()->all();
        return view('pages.fare_estimate', compact(['services', 'sessiondata']));

    }
	
    public function ride_overview(){
        return view('pages.ride_overview');
    }
    public function ride_safety(){
        return view('pages.ride_safety');
    }
    public function airports(){
        return view('pages.airports');
    }
    public function drive_overview(){
        return view('pages.drive_overview');
    }
    public function requirements(){
        return view('pages.requirements');
    }
    public function driver_app(){
        return view('pages.driver_app');
    }
    public function vehicle_solutions(){
        return view('pages.vehicle_solutions');
    }
    public function drive_safety(){
        return view('pages.drive_safety');
    }
    public function local(){
        return view('pages.local');
    }
    public function myliftx(){
        return view('pages.myliftx');
    }

    public function myliftxl(){
        return view('pages.myliftxl');
    }

    public function myliftxxl(){
        return view('pages.myliftxxl');
    }
    public function helpPage()
    {
        $data =Page::where('title','faq')->get();

        return view('pages.help',compact('data'));

    }
    public function refund()
    { 
        return view('pages.refund');
        
    }
    public function user()
    {
        return view('pages.user');

    }

    public function driver()
    {
        return view('pages.driver');

    }

    public function cities()
    {
        return view('pages.cities');

    }

    public function how_it_works()
    {   
        $data =Page::where('title','how it work')->get();

        return view('pages.how_it_works',compact('data'));

    }

    public function stories()
    {   

        return view('pages.story');

    }
    
    public function about_us() {
      return  $this->commonpage('about-us');
    }
    public function privacy() {
       return $this->commonpage('privacy-policy');
    }
     public function refund_policy() {
       return $this->commonpage('refund-policy');
    }
    //  public function fee_estimation() {
    //    return $this->commonpage('fee-estimate');
    // }
     public function help() {
      return  $this->commonpage('help');
    }
     public function terms_condition() {
       return $this->commonpage('terms-conditions');
    }
    public function why_us() {
        // return view('user.layout.why_us');
       return $this->commonpage('why-us');
    }
    public function commonpage($val) {
        $data = Page::select('title','description')->where('slug',$val)->first();
        return view('static',compact('data'));
    }
    
    
    public function download_page()
    {
        return view('downloadpage');
    }
	
	 

    // public function help()
    // {
    //     return view('user.layout.help');		
    // }
    
    public function driver_story () {

        $providers = DB::table('providers')
            ->join('provider_profiles', 'providers.id', '=', 'provider_profiles.provider_id')
            ->select('providers.*', 'provider_profiles.description')
           ->where('providers.status', 'approved')
            ->whereNotNull('provider_profiles.description')
            ->paginate(4);


        return view('user.layout.driver_story', compact('providers') );			
    
    }


    public function locale(Request $request ) {

              
        if( $request->has('locale') ) {

            Session::put('locale', $request->input('locale', 'en')  );
            Session::save();
        }

        return redirect()->back();

    }


    public function calculate_price(Request $request ) {

        
        $services 	= ServiceType::all();    
        $ip 	=   \Request::getClientIp(true);
        $ip_details = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$ip}"));

        return view('user.layout.calculate_price', compact('services', 'ip_details' ) );	
    }

    public function searchingajax()
    {
        $allrequests  = DB::table('user_requests')->select('id','status','created_at')->where('status', 'SEARCHING')->get();



        
        foreach($allrequests as $request)
        {
            $time = new \DateTime($request->created_at);
            $diff = $time->diff(new DateTime());
            $minutes = ($diff->days * 24 * 60) +
                       ($diff->h * 60) + $diff->i;
            if($minutes > 2)
            {
                DB::table('user_requests')
                    ->where('status', 'SEARCHING')
                    ->update(['status' => "CANCELLED"]);
                //return 1;
            }
        }
    }
    
    public function ajaxforofflineprovider(Request $request)
    {
                      //  \Log::info('just testing');
                    
       /* $allrequests  = DB::table('providers')->select('updated_at','id')->where('status','!=', 'riding')->get();
        
        foreach($allrequests as $request)
        {
            $time = new \DateTime($request->updated_at);
            $diff = $time->diff(new DateTime());
            $minutes = ($diff->days * 24 * 60) +
                       ($diff->h * 60) + $diff->i;

                       echo $request->id.':'.$minutes. ' , <br/>';

            if($minutes > 1)
            {

               $data = ProviderService::where('provider_id',$request->id)->update(['status' =>'offline']);
            }
        }*/
        
 //echo "ajaxforofflineprovider";
        //return $expected;
    }
    
    public function providerDocumentExpiryNotification(){
        $docs = ProviderDocument::with('provider','document')->where('expires_at','>=', Carbon::now()->toDateString())->get();
        foreach($docs as $doc){
           if(!empty($doc->provider) && !empty($doc->document)){
               $days = Carbon::parse($doc->expires_at)->diffInDays(Carbon::parse(Carbon::now()->toDateString()));
              
               if($days<=$doc->document->expire){
                   $msg="Your document ".$doc->document->name." will expire in ".$days." days. Please update your document";
                   $title="Document Expiry Notification";
                    $notification = new PushNotification;
                    $notification->type = 2;
                    $notification->title = $title;
                    $notification->zone = 0;
                    $notification->notification_text = $msg;
                    $notification->from_user = 1;
                    $notification->to_user = $doc->provider->id;
                    $notification->expiration_date = Carbon::parse($doc->expires_at);
                    $notification->save();
                   (new SendPushNotification)->notifyProvider($doc->provider->id,$title,$msg,'admin','');
                   
               }
                  
           }
        }
        
    }

}