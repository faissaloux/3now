@extends('admin.layout.base')

@section('title', 'Update Service Type ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
           <h5 style="margin-bottom: 2em;"><i class="ti-car"></i>&nbsp;Fahrzeug aktualisieren</h5><hr>

            <form class="form-horizontal" action="{{url('admin/service_update',$service->id)}}" method="POST" enctype="multipart/form-data" role="form" file="true">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="name" class="col-xs-12 col-form-label">Fahrzeugname</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->name }}" name="name" required id="name" placeholder="Cab Name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="picture" class="col-xs-12 col-form-label">Fahrzeugikone</label>
                    <div class="col-xs-10">
                        @if($service->image) 
                                <img src="{{   url('/'. $service->image ) }}" style="height: 50px" >
                            @else
                                N/A
                            @endif
                        <input type="file" accept="image/*" name="image" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="fixed" class="col-xs-12 col-form-label">Grundpreis ({{ currency() }})</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->fixed }}" name="fixed" required id="fixed" placeholder="Base Price">
                    </div>
                </div>
                <div class="form-group row" >
                    <label for="distance" class="col-xs-12 col-form-label">Basisabstand (KM)</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ $service->distance }}" name="distance" required id="distance" placeholder="Base Distance">
                    </div>
                </div>
                <span style="display:none">
                <div class="form-group row">
                    <label for="minute" class="col-xs-12 col-form-label">Zeiteinheitspreis ({{ currency() }})</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="hidden" value="{{ $service->minute }}" name="minute" required id="minute" placeholder="Unit Time Pricing">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-xs-12 col-form-label">Einheitsentfernungspreis (KM)</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="hidden" value="{{ $service->price }}" name="price" required id="price" placeholder="Unit Distance Price">
                    </div>
                </div>
                 </span>
                <div class="form-group row">
                    <label for="capacity" class="col-xs-12 col-form-label">Sitzplatzkapazität</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="number" value="{{ $service->capacity }}" name="capacity" required id="capacity" placeholder="Capacity">
                    </div>
                </div>

                <input class="form-control" type="hidden" value="MIN" name="calculator" >
                
                <div class="form-group row">
                    <label for="description" class="col-xs-12 col-form-label">Beschreibung</label>
                    <div class="col-xs-10">
                        <textarea class="form-control" type="text" name="description" required id="description" placeholder="Description" rows="4">{{ $service->description }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-xs-10">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-3">
                                <a href="{{ route('admin.service.index') }}" class="btn btn-danger btn-block">Stornieren</a>
                            </div>
                            <div class="col-xs-12 col-sm-6 offset-md-6 col-md-3">
                                <button type="submit" class="btn btn-primary btn-block">Aktualisieren</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
