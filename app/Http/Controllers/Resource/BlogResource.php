<?php

namespace App\Http\Controllers\Resource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Setting;
use Exception;
use App\Helpers\Helper;

use App\ServiceType;
use App\Blog;

class BlogResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blog = Blog::all();
        if($request->ajax()) {
            return $blog;
        } else {
            return view('cms.blog.index', compact('blog'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.blog.create');
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
            'image' => 'mimes:ico,png,jpeg,jpg'
        ]);

        try {
            $service = $request->all();

            if($request->hasFile('image')) {
                //$service['image'] = Helper::upload_picture($request->image);
                $service['image'] = \URL::to('/storage/app/public/').'/'.$request->image->store('uploads');
            }

            $service = Blog::create($service);

            return back()->with('flash_success','New Blog post created Successfully');
        } catch (Exception $e) {
            dd("Exception", $e);
            return back()->with('flash_error', 'Blog  Not Found');
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
            return Blog::findOrFail($id);
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
            $service = Blog::findOrFail($id);
            return view('cms.blog.edit',compact('service'));
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

            $service = Blog::findOrFail($id);

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

            return redirect()->route('cms.blog.index')->with('flash_success', 'Blog Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Blog Not Found');
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
            Blog::find($id)->delete();
            return back()->with('message', 'Blog deleted successfully');
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Blog Not Found');
        } catch (Exception $e) {
            return back()->with('flash_error', 'Blog Not Found');
        }
    }
}