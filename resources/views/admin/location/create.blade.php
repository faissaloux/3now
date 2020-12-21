@extends('admin.layout.base')

@section('title', 'Add Location ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white" id="zoneModel">
            <!-- <a href="{{ route('admin.location.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> -->
			
			<h5 style="margin-bottom: 2em;"><i class="ti-map"></i>&nbsp;Ort hinzufügen</h5><hr>

		
            <form class="form-horizontal" action="{{route('admin.location.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label">Ländername</label>
					<div class="col-xs-8">	
						<select class='form-control' v-model='country' @change='getStates()' id="country_name">
							<option value='0'>Land auswählen</option>
							<option v-for='data in countries' :value='data.id'>@{{ data.name }}</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-8 text-center">
						--OR--
					</div>
			    </div>
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-8">
						<input class="form-control" type="text" name="country_name"  id="country_name_input" placeholder="Country Name" required="required"/>
					</div>
				</div>
				<hr/>
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label">Statusname</label>
					<div class="col-xs-8">
						<select class='form-control' v-model='state' @change='getCities()' id="state_name">
					    	<option value='0' >Select State</option>
							<option v-for='data in states' :value='data.id'>@{{ data.name }}</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-8 text-center">
						--OR--
					</div>
			    </div>
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-8">
						<input class="form-control" type="text" name="state_name"  id="state_name_input" placeholder="State Name" required="required">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label">Stadtname</label>
					<div class="col-xs-8">
						<input class="form-control" type="text" name="city_name"  id="city_name" placeholder="City Name" required="required" value="{{old('city_name')}}">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Hinzufügen</button>
						<a href="{{url('admin/country')}}" class="btn btn-default">Stornieren</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
