@extends('admin.layout.base')

@section('title', 'Add Provider ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
            <!-- <a href="{{ route('admin.provider.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> -->
			<h5 style="margin-bottom: 2em;"><span class="s-icon"><i class="ti-infinite"></i></span>&nbsp;Treiber hinzufügen<hr></h5>

			@if( $services->count() )
            <form class="form-horizontal" action="{{route('admin.provider.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group row">
					<label for="first_name" class="col-xs-2 col-form-label">Name</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="Name">
					</div>
				</div>

				<!--<div class="form-group row">-->
				<!--	<label for="last_name" class="col-xs-2 col-form-label">Last Name</label>-->
				<!--	<div class="col-xs-10">-->
				<!--		<input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name" required id="last_name" placeholder="Last Name">-->
				<!--	</div>-->
				<!--</div>-->

				<div class="form-group row">
					<label for="email" class="col-xs-2 col-form-label">Email</label>
					<div class="col-xs-10">
						<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
					</div>
				</div>

				<div class="form-group row">
					<label for="password" class="col-xs-2 col-form-label">Passwort</label>
					<div class="col-xs-10">
						<input class="form-control" type="password" name="password" id="password" placeholder="Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="password_confirmation" class="col-xs-2 col-form-label">Passwort Bestätigung</label>
					<div class="col-xs-10">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="picture" class="col-xs-2 col-form-label">Bild</label>
					<div class="col-xs-10">
						<input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-2 col-form-label">Handy, Mobiltelefon</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="service_type" class="col-xs-2 col-form-label">Servicetyp</label>
					<div class="col-xs-10">
						<select name="service_type" class="form-control" id="service_type"  required>
							@foreach($services as $service) 
								<option value="{{ $service->id }}" <?php echo ( old('service_type') == $service->id ) ? 'selected' : ''; ?> >{{ $service->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="service_number" class="col-xs-2 col-form-label">Kabinennummer</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('service_number') }}" name="service_number" required id="service_number" placeholder="Cab Number">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="service_model" class="col-xs-2 col-form-label">Kabinenmodell</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('service_model') }}" name="service_model" required id="service_model" placeholder="Cab Model">
					</div>
				</div>
				
				<!--div class="form-group row">
					<label for="document" class="col-xs-12 col-form-label">Cab Number</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ old('service_number') }}" name="service_number" required id="service_number" placeholder="Cab Number">
					</div>
				</div-->
				
				
				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Treiber hinzufügen</button>
						<a href="{{route('admin.provider.index')}}" class="btn btn-default">Stornieren</a>
					</div>
				</div>
			</form>
			@else 
				<div>Bitte fügen Sie zuerst einen Servicetyp hinzu, um einen neuen Treiber hinzuzufügen!</div>
			@endif
		</div>
    </div>
</div>

@endsection
