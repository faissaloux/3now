<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserRequests;
use App\Provider;
use Auth;
use Setting;

class TripInCrmResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $requests = UserRequests::RequestHistory()->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('crm.request.ongoingTrip', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount']));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    public function onGoingTrip()
    {
        try {
            $requests = UserRequests::whereNotIn('status',['CANCELLED','SCHEDULED','PENDING','COMPLETED'])->RequestHistory()->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('crm.request.index', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount']));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    public function cancelTrip()
    {
        try {
            $requests = UserRequests::whereIn('status',['CANCELLED'])->RequestHistory()->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('crm.request.cancelTrip', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount']));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    public function scheduledTrip()
    {
        try {
            $requests = UserRequests::whereIn('status',['SCHEDULED'])->RequestHistory()->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('crm.request.scheduledTrip', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount']));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
    
    public function completedTrip()
    {
        try {
            $requests = UserRequests::whereIn('status',['COMPLETED'])->RequestHistory()->get();
            $totalrequest = UserRequests::count();
            $totalcanceltrip = UserRequests::where('status', 'CANCELLED')->count();
            $totalpaidamount = UserRequests::join('user_request_payments', 'user_requests.id', '=', 'user_request_payments.request_id')->sum('user_request_payments.total');
            return view('crm.request.completedTrip', compact(['requests','totalrequest','totalcanceltrip','totalpaidamount']));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetindex()
    {
        try {
            $requests = UserRequests::RequestHistory()
                        ->whereHas('provider', function($query) {
                            $query->where('fleet', Auth::user()->id );
                        })->get();
            return view('fleet.request.index', compact('requests'));
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scheduled()
    {
        try{
            $requests = UserRequests::where('status' , 'SCHEDULED')
                        ->RequestHistory()
                        ->get();

            return view('crm.request.scheduled', compact('requests'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Fleetscheduled()
    {
        try{
            $requests = UserRequests::where('status' , 'SCHEDULED')
                         ->whereHas('provider', function($query) {
                            $query->where('fleet', Auth::user()->id );
                        })
                        ->get();

            return view('fleet.request.scheduled', compact('requests'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
                's_latitude' => 'required|numeric',
                'd_latitude' => 'required|numeric',
                's_longitude' => 'required|numeric',
                'd_longitude' => 'required|numeric',
                'service_type' => 'required|numeric|exists:service_types,id',
                'promo_code' => 'exists:promocodes,promo_code',
                'distance' => 'required|numeric',
                'use_wallet' => 'numeric',
                'payment_mode' => 'required|in:CASH,CARD,PAYPAL',
            ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            $providers = Provider::all('first_name','last_name','id')->toArray();
            return view('crm.request.show', compact('request','providers'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetshow($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            return view('fleet.request.show', compact('request'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Accountshow($id)
    {
        try {
            $request = UserRequests::findOrFail($id);
            return view('account.request.show', compact('request'));
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        
        try {
            $Request = UserRequests::findOrFail($id);
            $Request->delete();
            return back()->with('flash_success','Request Deleted!');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }

    public function Fleetdestroy($id)
    {
        try {
            $Request = UserRequests::findOrFail($id);
            $Request->delete();
            return back()->with('flash_success','Request Deleted!');
        } catch (Exception $e) {
            return back()->with('flash_error','Something Went Wrong!');
        }
    }
}
