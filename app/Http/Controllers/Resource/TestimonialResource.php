<?php

namespace App\Http\Controllers\Resource;

use App\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Storage;

class TestimonialResource extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('created_at' , 'desc')->paginate(4);

    
        return view('admin.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial.create');
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
            'name'          => 'required',
            'type'          => 'required',
            'description'   => 'required|max:1000',
            'image'         => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try{

            $testimonial = $request->all();

            if($request->hasFile('image')) {
                $testimonial['image'] = $request->image->store('testimonial');

            }


            Testimonial::create( $testimonial );
            return back()->with('flash_success','Testimonial Saved Successfully');

        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Testimonial Not Found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Testimonial  $promocode
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Testimonial::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
      * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     
    public function edit($id)
    {
        try {

            $testimonial = Testimonial::findOrFail($id);
            return view('admin.testimonial.edit',compact('testimonial'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
      * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name'          => 'required',
            'type'          => 'required',
            'description'   => 'required|max:1000',
        ]);

        try {

           $testimonial = Testimonial::findOrFail($id);
            if( $testimonial ) {

                $testimonial->name          	=   $request->name;
                $testimonial->type          	=   $request->type;
                $testimonial->description   	=   $request->description;
				 $testimonial->name1          	=   ($request->name1) ?  $request->name1 : '';
                $testimonial->type1          	=   ($request->type1) ? $request->type1 : '';
                $testimonial->description1   	=   ($request->description1) ? $request->description1 : '';
				
				

                if($request->hasFile('image') ) {
                    Storage::delete($request->image);
                    $testimonial->image = $request->image->store('testimonial');
                }

            }
            

            $testimonial->save();

            return redirect()->route('admin.testimonial.index')->with('flash_success', 'Testimonial Updated Successfully');    
        } 

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Testimonial Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
      * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $testimonial = Testimonial::findOrFail($id);
            if( $testimonial ) {
                Storage::delete($testimonial->image);
                $testimonial->delete();
                return back()->with('message', 'Testimonial deleted successfully');
            }

        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Promocode Not Found');
        }
    }
}
