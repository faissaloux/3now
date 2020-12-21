@extends('admin.layout.base')

@section('title', 'Update Fleet ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
    	    <!-- <a href="{{ route('admin.fleet.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a> -->
            <h5 style="margin-bottom: 2em;"><span class="s-icon"><i class="ti-rocket"></i></span>&nbsp; Anbieter verwalten</h5><hr>
            <hr/>
            <form class="form-horizontal" action="{{route('admin.fleet.update', $fleet->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				<div class="form-group row">
					<label for="name" class="col-xs-2 col-form-label">Der Name des Managers</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ $fleet->name }}" name="name" required id="name" placeholder="Manager Name">
					</div>
				</div>
				<div class="form-group row">
					<label for="company" class="col-xs-2 col-form-label">Herstellername</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ $fleet->company }}" name="company" required id="company" placeholder="Vendor Name">
					</div>
				</div>
				<div class="form-group row">
					<label for="logo" class="col-xs-2 col-form-label">Hersteller-Logo</label>
					<div class="col-xs-12">
					@if(isset($fleet->logo))
                    	<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{img($fleet->logo)}}">
                    @endif
						<input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group row">
					<label for="mobile" class="col-xs-2 col-form-label">Handy, Mobiltelefon</label>
					<div class="col-xs-12">
						<input class="form-control" type="number" value="{{ $fleet->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary">Anbieter aktualisieren</button>
						<a href="{{route('admin.fleet.index')}}" class="btn btn-default">Stornieren</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
