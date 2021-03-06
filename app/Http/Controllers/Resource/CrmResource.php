<?php

namespace App\Http\Controllers\Resource;

use App\CrmUser;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Exception;
use Setting;

class CrmResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crms = CrmUser::orderBy('created_at' , 'desc')->get();
        return view('admin.crm.index', compact('crms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.crm.create');
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
            'name' => 'required|max:255',
            'mobile' => 'digits_between:6,13',
            'email' => 'required|unique:crm_users,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try{

            $crm = $request->all();
            $crm['password'] = bcrypt($request->password);

            $crm = CrmUser::create($crm);

            return back()->with('flash_success','CrmUser Details Saved Successfully');

        } 

        catch (Exception $e) {
            return back()->with('flash_error', 'CrmUser Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CrmUser  $crm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CrmUser  $crm
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $crm= CrmUser::findOrFail($id);
            return view('admin.crm.edit',compact('crm'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CrmUser  $crm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        

        $this->validate($request, [
            'name' => 'required|max:255',
            'mobile' => 'digits_between:6,13',
        ]);

        try {

            $crm = CrmUser::findOrFail($id);
            $crm->name = $request->name;
            $crm->mobile = $request->mobile;
            $crm->save();

            return redirect()->route('admin.crm-manager.index')->with('flash_success', 'CrmUser Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'CrmUser Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CrmUser  $crm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        

        try {
            CrmUser::find($id)->delete();
            return back()->with('message', 'CrmUser deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'CrmUser Not Found');
        }
    }

}
