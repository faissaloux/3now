<?php

namespace App\Http\Controllers\Resource;

use App\AdminHelps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HelpController extends Controller
{

    protected function create(Request $request)
    {
        $this->validate($request, [
                'description' => 'required',
            ]);

        $description = $request->description;
       
        $AdminHelps = new AdminHelps;

        $AdminHelps->description = $request->description;

        $AdminHelps->save();

        return redirect('admin/help');
    }

    public function helpsget()
    {
        try{
            $AdminHelps = AdminHelps::HelpsList()->get();
            return $AdminHelps;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        } 
    }

    public function helpsget_detail(Request $request)
    {
        $this->validate($request, [
                'request_id' => 'required|integer|exists:user_requests,id',
           ]);
        
        try{
            $AdminHelps = AdminHelps::HelpsList($request->request_id)->get();
            return $AdminHelps;
        }

        catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        } 
    }

    public function helps()
    {
        $helps = $this->helpsget();
        
        //$faqs_dtl = $this->faqsget_detail($request);
        return view('admin.help',compact('helps'));
    }

    public function showFAQForm()
    {
        return view('admin.help');
    }
}
