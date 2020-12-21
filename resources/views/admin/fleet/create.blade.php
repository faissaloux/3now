@extends('admin.layout.base')

@section('title', 'Add Fleet Owner ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
            <!-- <a href="{{ route('admin.fleet.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> -->
			<h5 style="margin-bottom: 2em;"><span class="s-icon"><i class="ti-rocket"></i></span>&nbsp; Anbieter hinzufügen</h5>
			<hr/>
            <form class="form-horizontal" action="{{route('admin.fleet.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group row">
					<label for="name" class="col-xs-12 col-form-label">Der Name des Managers</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Manager Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="company" class="col-xs-12 col-form-label">Herstellername</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ old('company') }}" name="company" required id="company" placeholder="Vendor Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-xs-12 col-form-label">Email</label>
					<div class="col-xs-12">
						<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
					</div>
				</div>

				<div class="form-group row">
					<label for="password" class="col-xs-12 col-form-label">Passwort</label>
					<div class="col-xs-12">
						<input class="form-control" type="password" name="password" id="password" placeholder="Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="password_confirmation" class="col-xs-12 col-form-label">Passwort Bestätigung</label>
					<div class="col-xs-12">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
					</div>
				</div>

				<div class="form-group row">
					<label for="logo" class="col-xs-12 col-form-label">Hersteller-Logo</label>
					<div class="col-xs-12">
						<input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-12 col-form-label">Handy, Mobiltelefon</label>
					<div class="col-xs-12">
						<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-12 col-form-label"></label>
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary">Anbieter hinzufügen</button>
						<a href="{{route('admin.fleet.index')}}" class="btn btn-default">Stornieren</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
