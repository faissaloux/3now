<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Setting;
use Exception;
use App\Helpers\Helper;

use App\ServiceType;
use App\Page;

class PageResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = Page::all();
        if($request->ajax()) {
            return $page;
        } else {
            return view('cms.page.index', compact('page'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.page.create');
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
            'title' => 'required',
            'description' => 'required',
            'image' => 'mimes:ico,png,jpeg,jpg',
            'slug' => 'required | unique:pages'
        ]);

        try {
			
            $service = $request->all(); 
			
            if($request->hasFile('image')) {
                //$service['image'] = Helper::upload_picture($request->image);
                $service['image'] = \URL::to('/storage/app/public/').'/'.$request->image->store('uploads');
            }

            $service = Page::create($service);

            return back()->with('flash_success','New Page created Successfully');
        } catch (Exception $e) {
            dd("Exception", $e);
            return back()->with('flash_error', 'Page  Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Page::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Service Type Not Found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $service = Page::findOrFail($id);
            return view('cms.page.edit',compact('service'));
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Service Type Not Found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            
			'image' => 'mimes:ico,png,jpeg,jpg'
			
        ]);

        try {

            $service = page::findOrFail($id);

            if($request->hasFile('image')) {
                if($service->image) {
                    //Helper::delete_picture($service->image);
					\Storage::delete($service->image);
                }
                //$service->image = Helper::upload_picture($request->image);
				$service->image = \URL::to('/storage/app/public/').'/'.$request->image->store('uploads');
            }

            $service->title = $request->title;
            $service->description = $request->description;
           
           
            $service->save();

            return redirect()->route('cms.page.index')->with('flash_success', 'Page Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Page Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceType  $serviceType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         
        
        try {
            Page::find($id)->delete();
            return back()->with('message', 'Page deleted successfully');
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Page Not Found');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Page Not Found');
        }
    }
}