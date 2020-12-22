<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Setting;
use Auth;
use Exception;
use Carbon\Carbon;
use App\Models\ {
    User, CrmUser, Provider, UserRequests, ServiceType, ContactUs, Complaint, LostItem, UserRequestPayment
};

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
class CrmController extends Controller {
    /**
     * Dispatcher Panel.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    protected $UserAPI;
    protected $ip_details = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserApiController $UserAPI) {
        $this->UserAPI = $UserAPI;
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private static function last7DaysTrip() {
        $days_arr = array();
        $last7days_rides = UserRequests::whereDate('created_at', '>=', Carbon::now()->subDays(7))->groupBy('created_at')->select('created_at', DB::raw('count(*) as total'))->get();
        if (!$last7days_rides->isEmpty()) {
            foreach ($last7days_rides as $key => $value) {
                $day = Carbon::now()->format('F');
                $day_name = Carbon::parse($value->created_at)->format('D');
                $days_arr[$day_name] = array($day_name, (float)$value->total);
            }
        }
        $timestamp = strtotime('next Sunday');
        $days = array();
        for ($i = 0;$i < 7;$i++) {
            $day_v = strftime('%a', $timestamp);
            if (isset($days_arr[$day_v]) && in_array($day_v, $days_arr[$day_v])) {
                $arr = array();
                $arr = $days_arr[$day_v];
                $arr[] = 'silver';
                $days[] = $arr;
            } else {
                $days[] = array($day_v, 0, 'silver');
            }
            $timestamp = strtotime('+1 day', $timestamp);
        }
        return $days;
    }
    private static function last7DaysTripRe() {
        $days_arr = array();
        $last7days_rides = UserRequests::whereDate('created_at', '>=', Carbon::now()->subDays(7))->groupBy('created_at', 'id')->select('created_at', 'id', DB::raw('count(*) as total'))->where('status', 'COMPLETED')->get();
        if (!$last7days_rides->isEmpty()) {
            foreach ($last7days_rides as $key => $value) {
                $day = Carbon::now()->format('F');
                $day_name = Carbon::parse($value->created_at)->format('D');
                $rdata = UserRequestPayment::where('request_id', $value->id)->first();
                if (!empty($rdata)) {
                    $total = (float)$rdata->total;
                } else {
                    $total = 0;
                }
                $days_arr[$day_name] = array($day_name, $total);
            }
        }
        $timestamp = strtotime('next Sunday');
        $days = array();
        for ($i = 0;$i < 7;$i++) {
            $day_v = strftime('%a', $timestamp);
            if (isset($days_arr[$day_v]) && in_array($day_v, $days_arr[$day_v])) {
                $arr = array();
                $arr = $days_arr[$day_v];
                $arr[] = 'silver';
                $days[] = $arr;
            } else {
                $days[] = array($day_v, 0, 'silver');
            }
            $timestamp = strtotime('+1 day', $timestamp);
        }
        return $days;
    }
    public function dashboard() {
        try {
            $rides = UserRequests::with('user', 'provider')->orderBy('id', 'desc')->get();
            $cancel_rides = UserRequests::where('status', 'CANCELLED')->get();
            $scheduled_rides = UserRequests::where('status', 'SCHEDULED')->count();
            $user_cancelled = $cancel_rides->where('cancelled_by', 'USER')->count();
            $provider_cancelled = $cancel_rides->where('cancelled_by', 'PROVIDER')->count();
            $cancel_rides = $cancel_rides->count();
            $service = ServiceType::count();
            $fleet = UserRequests::where('paid', 1)->where('payment_mode', 'CARD')->count();
            $cash = UserRequests::where('paid', 1)->where('payment_mode', 'CASH')->count();
            $paypal = UserRequests::where('paid', 1)->where('payment_mode', 'PAYPAL')->count();
            $revenue = UserRequestPayment::sum('total');
            $providers = Provider::take(10)->orderBy('rating', 'desc')->get();
            $last7days_rides = self::last7DaysTrip();
            $last7days_rides_r = self::last7DaysTripRe();
            $completed_rides = UserRequests::where('status', 'COMPLETED')->count();
            $ongoing_rides = Provider::with('service')->whereHas('service', function ($query) {
                $query->where('provider_services.status', 'active')->orWhere('provider_services.status', 'riding');
            })->where('latitude', '!=', 0)->where('longitude', '!=', 0)->where('providers.status', 'approved')->count();
            return view('crm.dashboard', compact('providers', 'fleet', 'cash', 'scheduled_rides', 'service', 'rides', 'user_cancelled', 'provider_cancelled', 'cancel_rides', 'revenue', 'last7days_rides', 'last7days_rides_r', 'completed_rides', 'ongoing_rides', 'paypal'));
        }
        catch(Exception $e) {
            dd($e->getMessage());
            return redirect()->route('crm.user.index')->with('flash_error', 'Something Went Wrong with Dashboard!');
        }
    }
    public function dashboard2() {
        $services = ServiceType::all();
        $companies = DB::table('fleets')->get();
        $totaluser = User::count();
        $totaldriver = Provider::count();
        $totaltrips = UserRequests::count();
        $totalcomtrips = UserRequests::where('status', 'COMPLETED')->count();
        $ip_details = $this->ip_details;
        if (Auth::guard('admin')->user()) {
            $data = "";
            return view('admin.crm', compact('data'));
        } elseif (Auth::guard('crm')->user()) {
            return view('crm.dashboard', compact(['services', 'ip_details', 'companies', 'totaluser', 'totaldriver', 'totaltrips', 'totalcomtrips']));
        }
    }
    public function contact() {
        $data = ContactUs::all();
        return view('crm.users.contact', compact('data'));
    }
    public function live() {
        return view('crm.map.live');
    }
    public function destroy($id) {
        try {
            ContactUs::find($id)->delete();
            return back()->with('message', 'User deleted successfully');
        }
        catch(Exception $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        return view('crm.account.profile');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request) {
        $this->validate($request, ['name' => 'required|max:255', 'mobile' => 'required|digits_between:6,13', ]);
        try {
            $account = Auth::guard('crm')->user();
            $account->name = $request->name;
            $account->mobile = $request->mobile;
            $account->save();
            return redirect()->back()->with('flash_success', 'Profile Updated');
        }
        catch(Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password() {
        return view('crm.account.change-password');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request) {
        $this->validate($request, ['old_password' => 'required', 'password' => 'required|min:6|confirmed', ]);
        try {
            $Account = crmUser::find(Auth::guard('crm')->user()->id);
            if (password_verify($request->old_password, $Account->password)) {
                $Account->password = bcrypt($request->password);
                $Account->save();
                return redirect()->back()->with('flash_success', 'Password Updated');
            }
        }
        catch(Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function complaint() {
        $data = Complaint::where('transfer', 1)->get();
        return view('crm.complaint', compact('data'));
    }
    public function complaintDetails($id) {
        $data = Complaint::where('id', $id)->first();
        return view('crm.complaint_details', compact('data'));
    }
    public function lost_management() {
        $data = LostItem::get();
        return view('crm.lost_management', compact('data'));
    }
    public function lost_destroy($id) {
        try {
            LostItem::find($id)->delete();
            return back()->with('message', 'User deleted successfully');
        }
        catch(Exception $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }
}