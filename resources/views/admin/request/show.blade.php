
@extends('admin.layout.base')

@section('title', 'Ride details ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 style="margin-bottom: 2em;"><span class="s-icon"><i class="ti-pie-chart"></i></span> Fahrdetails</h5>
            <hr>
            <div class="row">
                <div class="col-md-7">
                    <div id="map"></div>
                </div>
                <div class="col-md-5">
                    <dl class="row">



                        <dt class="col-sm-4">paid :</dt>
                        <dd class="col-sm-8">
                        	
                        	@if($request['paid'] == '1')

                        	<span style="color:green;"><i class="fa fa-check"></i> paid </span>
                        	
                        	
                        	@else
                        	<span style="color:red;"><i class="fa fa-times"></i> not paid </span>
                        	

                        	@endif	

                        </dd>
                        <dt><hr></dt>

                        


                        @if(!empty($request['vorname']))
                        <dt class="col-sm-4">Name :</dt>
                        <dd class="col-sm-8">{{ @$request->vorname }} {{ @$request->nachname }}</dd>
                        <dt><hr></dt>
                        @else
                        <dt class="col-sm-4">Name :</dt>
                        <dd class="col-sm-8">{{ @$request->user->first_name }}</dd>
                        <dt><hr></dt>
                        @endif

                        @if(!empty($request['vorname']))
                        <dt class="col-sm-4">Email :</dt>
                        <dd class="col-sm-8">{{ @$request->emailadress }} </dd>
                        <dt><hr></dt>
                        @endif

                        <dt class="col-sm-4">Treiber :</dt>
                        @if($request->provider)
                        <dd class="col-sm-8">{{ @$request['provider']['first_name'] }}</dd>
                        @else
                        <dd class="col-sm-8">Anbieter noch nicht zugeordnet!</dd>
                        @endif
                        <dt><hr></dt>
                        @if($request['status'] == 'SCHEDULED')
                        <dt class="col-sm-4">Geplante Zeit fahren :</dt>
                        <dd class="col-sm-8">
                            @if($request['schedule_at'] != "0000-00-00 00:00:00")
                                {{ date('jS \of F Y h:i:s A', strtotime($request->schedule_at)) }} 
                            @else
                                - 
                            @endif
                        </dd>
                        <dt><hr></dt>
                        @else
                        <dt class="col-sm-4">Startzeit der Fahrt :</dt>
                        <dd class="col-sm-8">
                            @if($request['started_at'] != NULL)
                                {{ date('jS \of F Y h:i:s A', strtotime($request->created_at)) }} 
                            @else
                                - 
                            @endif
                         </dd>
                         <dt><hr></dt>
                        <dt class="col-sm-4">Fahrtendzeit :</dt>
                        <dd class="col-sm-8">
                            @if($request['finished_at'] != NULL) 
                                {{ date('jS \of F Y h:i:s A', strtotime($request->finished_at)) }}
                            @else
                                - 
                            @endif
                        </dd>
                        <dt><hr></dt>
                        @endif

                        <dt class="col-sm-4">Abholadresse :</dt>
                        <dd class="col-sm-8">{{ $request['s_address'] ? $request->s_address : '-' }}</dd>
                        <dt><hr></dt>
                        <dt class="col-sm-4">Adresse löschen :</dt>
                        <dd class="col-sm-8">{{ $request['d_address'] ? $request->d_address : '-' }}</dd>
                        <dt><hr></dt>


                        @if(!empty($request['schedule_at']))

                           <dt class="col-sm-4">Schedule at :</dt>
                        <dd class="col-sm-8">{{ $request['schedule_at'] }}</dd>
                        <dt><hr></dt>
                       
                        @else
                        <dt class="col-sm-4">Hin :</dt>
                        <dd class="col-sm-8">{{ $request['going_at'] }}</dd>
                        <dt><hr></dt>
                        @if(!empty($request['return_at']))   
   
                        <dt class="col-sm-4">Zurück :</dt>
                        <dd class="col-sm-8">{{ $request['return_at']  }}</dd>
                        <dt><hr></dt>
                         @endif

                        @endif





                        <dt class="col-sm-4">Gesamtstrecke :</dt>
                        <dd class="col-sm-8">{{ @$request['distance'] ? round($request->distance) : '-' }} KM</dd>
                        <dt><hr></dt>


                     


                        @if($request->payment)
                    
                        <dt class="col-sm-4">Gesamtmenge :</dt>
                        <dd class="col-sm-8">{{ currency($request['payment']['total']) }}</dd>                        
                        <dt><hr></dt>
                        @endif


                    
                    
                        <dt class="col-sm-4">Fahrpreis :</dt>
                        <dd class="col-sm-8">{{ $request->pries() }} €</dd>                        
                        <dt><hr></dt>
                       


                        @if(!empty($request['vorname']))
                        <dt class="col-sm-4">Handynummer eingeben  :</dt>
                        <dd class="col-sm-8">{{ $request->handynummer  }}</dd>
                        <dt><hr></dt>
                        @else
                        <dt class="col-sm-4">Handynummer eingeben  :</dt>
                        <dd class="col-sm-8">{{ $request->user->mobile  }}</dd>
                        <dt><hr></dt>
                        @endif





                        <dt class="col-sm-4">Fahrstatus:  </dt>
                        <dd class="col-sm-8">
                            {{ $request['status'] }}
                        </dd>

                        <dt><hr></dt>


                        <dt class="col-sm-4">Kiderzits:  </dt>
                        <dd class="col-sm-8">
                            {{ $request['kindersitz'] }}
                        </dd>
                        <dt><hr></dt>



                        <dt class="col-sm-4">Babyschale:  </dt>
                        <dd class="col-sm-8">
                            {{ $request['babyschale'] }}
                        </dd>
                        <dt><hr></dt>



                        <dt class="col-sm-4">nameschield:  </dt>
                        <dd class="col-sm-8">

                            @if($request['nameschield'] == 'true')
                         
                                
                                <span style="color:green;"><i class="fa fa-check"></i> Ja </span>
                            @else
                               <span style="color:red;"><i class="fa fa-times"></i> Ohne </span>
     
                            @endif
                        </dd>
                     <dt><hr></dt>





                    @if($request['nameschield'] == 'true')    
                        <dt class="col-sm-4">nameschield name:  </dt>
                        <dd class="col-sm-8">
                            {{ $request['nameshield_name'] }}
                        </dd>
                     <dt><hr></dt>
                      @endif   



                        <dt class="col-sm-4">Notiz:  </dt>
                        <dd class="col-sm-8">
                            {{ $request['note'] }}
                        </dd>

                        <dt><hr></dt>	


                        <dt class="col-sm-4">assign to provider:  </dt>
                        <dd class="col-sm-8">
                            <select class='form-control' id="assign_to_provider" data-request='{{ $request['id'] }}'>
                            	@foreach($providers as $provider)
                            		<option value="{{ $provider['id'] }}">{{ $provider['first_name'] }} {{ $provider['last_name'] }}</option>
                            	@endforeach
                            </select>
                        </dd>
                       <dt><hr></dt>




       					<dt class="col-sm-4"> send email:  </dt>
                        <dd class="col-sm-8">
                        	<a href="javascript:;" class='btn btn-success' data-request='{{ $request['id'] }}' id="emailToClient"> email to client</a>

                            <a href="javascript:;" class='btn btn-warning' data-request='{{ $request['id'] }}' id="changeProvider"> Anderen Fahrer </a>

                            
                        </dd>
                       <dt><hr></dt>


                    </dl>
                </div>
                



                        <input type="hidden" id='defaultDriver' value="{{ $request['provider_id'] }}">







            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style type="text/css">
    #map {
        height: 550px;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript">
    var map;
    var zoomLevel = 11;

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'));

        var marker = new google.maps.Marker({
            map: map,
            icon: '/asset/img/marker-start.png',
            anchorPoint: new google.maps.Point(0, -29)
        });

         var markerSecond = new google.maps.Marker({
            map: map,
            icon: '/asset/img/marker-end.png',
            anchorPoint: new google.maps.Point(0, -29)
        });

        var bounds = new google.maps.LatLngBounds();

        source = new google.maps.LatLng({{ $request->s_latitude }}, {{ $request->s_longitude }});
        destination = new google.maps.LatLng({{ $request->d_latitude }}, {{ $request->d_longitude }});

        marker.setPosition(source);
        markerSecond.setPosition(destination);

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
        directionsDisplay.setMap(map);

        directionsService.route({
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                console.log(result);
                directionsDisplay.setDirections(result);

                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);
            }
        });

        @if($request->provider && $request->status != 'COMPLETED')
        var markerProvider = new google.maps.Marker({
            map: map,
            icon: "/asset/img/marker-car.png",
            anchorPoint: new google.maps.Point(0, -29)
        });

        provider = new google.maps.LatLng({{ $request->provider->latitude }}, {{ $request->provider->longitude }});
        markerProvider.setVisible(true);
        markerProvider.setPosition(provider);
        console.log('Provider Bounds', markerProvider.getPosition());
        bounds.extend(markerProvider.getPosition());
        @endif

        bounds.extend(marker.getPosition());
        bounds.extend(markerSecond.getPosition());
        map.fitBounds(bounds);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap" async defer></script>
@endsection