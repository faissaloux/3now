@extends('admin.layout.base')

@section('title', 'Promocodes ')

@section('content')


          <style>
          .form-group {overflow: hidden;margin-bottom: 15px;}
          </style>




                <!-- Content area -->
                <div class="content">

                <!-- Page header -->
                <div class="page-header page-header-transparent">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h1> <span class="text-semibold">create new coupon  </span></h1>
                        </div>
                    </div>
                </div>
                <!-- /page header -->
            
                    

<form action="{{ route('admin.coupons.store') }}" method="post" class="form-horizontal">


<div class="col-md-12">

    <div class="panel panel-default">

        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-3 control-label">Activate the coupon  </label>
                <div class="col-sm-9">

                    <label class="adminswitch">
    <input name="statue" type="checkbox"  value="active"  />
    <span class="slider round"></span>
    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Coupon code</label>
                <div class="col-sm-9">
                    <input type="text" name="code" value="" placeholder="Coupon code" class="form-control rf">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Type</label>
                <div class="col-sm-9">
                    <select name="discount_type" id="input-type" class="form-control">
                        <option value="percent">Percent reduction</option>
                        <option value="fixed">Third memorization</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Reducing value </label>
                <div class="col-sm-9">
                    <input type="text" name="discount" value="" placeholder="Reducing value" class="form-control rf">
                </div>
            </div>
            

          




            <div class="form-group">
                <label class="col-sm-3 control-label">description </label>
                <div class="col-sm-9">
                    <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>


                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Start date  </label>
                <div class="col-sm-9">
                    <div class="input-group date">
  <input type="date" name="valid_from" placeholder="The expiration date " id="input-date-start" class="form-control rf" value="">
                        <span class="input-group-btn">
<button type="button" class="btn btn-default"><i class="icon-calendar3"></i></button>
</span></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Expiration date </label>
                <div class="col-sm-9">
                    <div class="input-group date">
                        <input type="date" name="valid_to" placeholder="Expiration date" class="form-control rf" value="">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-default"><i class="icon-calendar3"></i></button>
                        </span></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"> max usage  </label>
                <div class="col-sm-9">
                    <input type="number" name="maxUsage" placeholder="The number of times a coupon is used " class="form-control rf">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"> max discount  </label>
                <div class="col-sm-9">
                    <input type="number" name="maxDiscount" placeholder="" class="form-control rf">
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label"> usage type </label>
                <div class="col-sm-9">
                    <select name="usage_type" class='form-control' >
                        <option value="single">single</option>
                        <option value="multiple">multiple</option>
                    </select>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-3 control-label"> user </label>
                <div class="col-sm-9">
                
                    <select name="user" class='form-control' >
                    @foreach($users as $user)
                        <option value="{{ $user['id'] }}">{{ $user['first_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-block btn-primary">publish coupon  <i class="icon-arrow-left13 position-right"></i></button>
        </div>
    </div>
</div>
 
 <div class="col-md-4" >




         
        </div>

            
        
            
            


<br>

 </div>
 </form>
 
</div>
<!-- /content area -->

    
    
@endsection