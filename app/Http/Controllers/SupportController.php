<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Setting;
use Auth;
use Exception;
use Carbon\Carbon;
use App\Models\ {
    ServiceType, Complaint
};

class SupportController extends Controller {
    /**
     * SupportUser Panel.
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
    public function dashboard() {
        $services = ServiceType::all();
        $companies = DB::table('fleets')->get();
        $complaint = Complaint::count();
        $ip_details = $this->ip_details;
        if (Auth::guard('admin')->user()) {
            $data = "";
            return view('admin.support', compact('data'));
        } elseif (Auth::guard('support')->user()) {
            return view('support.dashboard', compact('services', 'ip_details', 'companies', 'complaint'));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile() {
        return view('support.account.profile');
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
            $account = Auth::guard('support')->user();
            $account->name = $request->name;
            $account->mobile = $request->mobile;
            $account->save();
            return redirect()->back()->with('flash_success', 'Profile Updated');
        }
        catch(Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }
    public function openTicket($type) {
        $mytime = Carbon::now();
        if ($type == 'new') {
            $data = Complaint::whereDate('created_at', $mytime->toDateString())->where('transfer', 0)->get();
        }
        if ($type == 'open') {
            $data = Complaint::where('transfer', '!=', 0)->get();
        }
        return view('support.open_ticket', compact('data'));
    }
    public function closeTicket() {
        $data = Complaint::get();
        return view('support.open_ticket', compact('data'));
    }
    public function openTicketDetails($id) {
        $data = Complaint::where('id', $id)->first();
        return view('support.open_ticket_details', compact('data'));
    }
    public function transfer($id, Request $request) {
        $data = Complaint::where('id', $id)->first();
        $data->status = $request->status;
        $data->transfer = $request->transfer;
        $data->reply = $request->reply;
        $data->save();
        return redirect()->back()->with('flash_success', 'Ticket Updated');
    }
}