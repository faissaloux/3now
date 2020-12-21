@extends('user.layout.base')

@section('title', 'Ride Confirmation ')

@section('styles')
<style type="text/css">
    .surge-block {
        background-color: black;
        width: 50px;
        height: 50px;
        border-radius: 25px;
        margin: 0 auto;
        padding: 10px;
        padding-top: 15px;
    }
    .surge-text{
        top: 11px;
        font-weight: bold;
        color: white;
    }		.pomoc_wrap {		position: relative;		font-size: 0;	}			.form-group.promoc_wrap * {		display: inline-block;		vertical-align: top;	}
    select.form-control:not([size]):not([multiple]){
    	height: 33px !important;
    }
</style>
@endsection
 
@section('content')
<div class="col-md-12" style="margin-bottom: 20px;">
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title"><span class="s-icon"><i class="ti-car user-sidebaricon" style="color: rgb(0, 0, 0);"></i></span>&nbsp;@lang('user.ride.ride_now')</h4><hr>
            </div>
        </div>
        @include('common.notify')
        <div class="row no-margin">
            <div class="col-md-6">
                <form action="{{url('create/ride')}}" method="POST" id="create_ride">
                {{ csrf_field() }}

                    <dl class="dl-horizontal left-right">
                        <dt>@lang('user.type')</dt>
                        <dd>{{$service->name}}</dd>
                        <dt>@lang('user.total_distance')</dt>
                        <dd>{{  $fare->distance }} {{ ( $fare->distance > 1 ) ? 'KMS' :  'KM' }}</dd>
                        <dt>@lang('user.eta')</dt>
                        <dd>{{$fare->time}}</dd>
						<dt class="discnt-txt">@lang('user.discount')</dt>
						<dd class="discnt-val"> {{ $fare->discount == 0 ? '0.00' :  currency($fare->discount) }}</dd>
                        <dt class="est_fare">@lang('user.estimated_fare')</dt>
                        <dd class="est_val">{{currency($fare->estimated_fare)}}</dd>
                        <hr>		

						
                        @if(Auth::user()->wallet_balance > 0)
						<!--
                        <input type="checkbox" name="use_wallet" value="1"><span style="padding-left: 15px;">@lang('user.use_wallet_balance')</span>
                        <br>
                        <br>
						<dt>@lang('user.available_wallet_balance')</dt>
						<dd>{{currency(Auth::user()->wallet_balance)}}</dd>
						-->
                        @endif
						
						
                    </dl>
					
					
                    <input type="hidden" name="s_address"  value="{{Request::get('s_address')}}">
                    <input type="hidden" name="d_address" value="{{Request::get('d_address')}}">
                    <input type="hidden" name="s_latitude" id="origin_latitude"  value="{{Request::get('s_latitude')}}">
                    <input type="hidden" name="s_longitude"  id="origin_longitude" value="{{Request::get('s_longitude')}}">
                    <input type="hidden" name="d_latitude"  id="destination_latitude" value="{{Request::get('d_latitude')}}">
                    <input type="hidden" name="d_longitude" id="destination_longitude"  value="{{Request::get('d_longitude')}}">
                    <input type="hidden" name="service_type" value="{{Request::get('service_type')}}">
                    <input type="hidden" name="distance" value="{{$fare->distance}}">										
                    <p>@lang('user.payment_method')</p>
                    <select class="form-control" name="payment_mode" id="payment_mode" onchange="card(this.value);">
                      <option value="CASH">CASH</option>
                      @if(Setting::get('CARD') == 1)
						  @if($cards->count() > 0)
							<option value="CARD">CARD</option>
						  @endif
                      @endif
                    </select>
                    <br>
                    @if(Setting::get('CARD') == 1)
                        @if($cards->count() > 0)
                        <select class="form-control" name="card_id" style="display: none;" id="card_id">
                          <option value="">Select Card</option>
                          @foreach($cards as $card)
                            <option value="{{$card->card_id}}">{{$card->brand}} **** **** **** {{$card->last_four}}</option>
                          @endforeach
                        </select>
                        @endif
                    @endif
                    @if(@$fare->surge == 1)
                        <span><em>Note : Due to High Demand the fare may vary!</em></span>
                        <div class="surge-block"><span class="surge-text">{{$fare->surge_value}}</span>
                        </div>
                    @endif
                    <p>Add Coupon Code</p>									
                    <div class="form-group promoc_wrap">    						
                        <input type="text" style="width: 68%;" class="form-control" name="promo_code" id="promo_code_input">						
                        <button  data-loading-text="Applying..."  style="width:30%; height: 34px!important" class="btn btn-success shadow-box" id="promo_code_btn" type="button">Apply</button>					
                    </div>
                    <button type="submit" class="half-primary-btn btn-success shadow-box fare-btn">@lang('user.ride.order_now')</button>
                    <button type="button" class="half-secondary-btn fare-btn shadow-box" data-toggle="modal" data-target="#schedule_modal">@lang('user.ride.schedule_order')</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="user-request-map">
                    <div class="map-responsive">
						<div id="map" style="width: 100%; height: 450px;"></div>
						<div class="from-to row no-margin">
							<div class="from">
								<h5>Abholadresse</h5>
								<p>{{$request->s_address}}</p>
							</div>
							<div class="to">
								<h5>Ziel</h5>
								<p>{{$request->d_address}}</p>
							</div>
						</div>
					</div>
                </div> 
            </div>
        </div>
    </div>
</div>
<!-- Schedule Modal -->
<div id="schedule_modal" class="modal fade schedule-modal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Schedule a Order</h4>
      </div>
		<form>
			<div class="modal-body">
				<label>Date</label>
				<input value="{{date('m/d/Y')}}" type="text" id="datepicker" placeholder="Date" name="schedule_date">
				<label>Time</label>
				<input value="{{date('H:i')}}" type="text" id="timepicker" placeholder="Time" name="schedule_time">
			  </div>
			  <div class="modal-footer">
				<button type="button" id="schedule_button" class="half-primary-btn btn-success shadow-box" data-dismiss="modal" style="width: 522px;margin-right: 24px;">Schedule Order</button>
			</div>
		</form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap" async defer></script>
    <script type="text/javascript">
	
	var ip_details = <?php echo json_encode( $ip_details );  ?>;
    var current_latitude = parseFloat(ip_details.geoplugin_latitude);
    var current_longitude = parseFloat(ip_details.geoplugin_longitude);
	var oLatitudev = document.getElementById('origin_latitude').value;
	var oLongitudev = document.getElementById('origin_longitude').value;
	var dLatitudev = document.getElementById('destination_latitude').value;
	var dLongitudev = document.getElementById('destination_longitude').value;
	
	
	function initMap() {
		var map = new google.maps.Map(document.getElementById('map'), {
			mapTypeControl: false,
			zoomControl: true,
			center: {lat: current_latitude, lng: current_longitude},
			zoom: 12,
			styles : [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#e4e8e9"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#7de843"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#9bd0e8"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]
		});
		
		var polylineOptionsActual = new google.maps.Polyline({ strokeColor: '#111', strokeOpacity: 0.8, strokeWeight: 4 });

		var directionsService = new google.maps.DirectionsService;
		// var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
		// var marker = new google.maps.Marker({
		//     position: position,
		//     map: map,
		//     icon: image
		//   });
		var directionsDisplay = new google.maps.DirectionsRenderer({map: map, suppressMarkers: false, polylineOptions: polylineOptionsActual });
		  
		

		if( oLatitudev.length && oLongitudev.length &&  dLatitudev.length && dLongitudev.length ) {
			
			directionsService.route({
				origin: new google.maps.LatLng(Number(oLatitudev), Number(oLongitudev)),
				destination: new google.maps.LatLng(Number(dLatitudev), Number(dLongitudev)),
				avoidTolls: true,
				avoidHighways: false,
				travelMode: google.maps.TravelMode.DRIVING
			}, function (response, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(response);
				} else {
					window.alert('Directions request failed due to ' + status);
				}
			});
			

		}
	}
	
	////////////////////////////////////////////////////////////////
	
            $('#schedule_button').click(function(){
                 //alert("ride script");
                $("#datepicker").clone().attr('type','hidden').appendTo($('#create_ride'));
                $("#timepicker").clone().attr('type','hidden').appendTo($('#create_ride'));
                //alert("ride script before submit");
                document.getElementById('create_ride').submit();
            }); 		


			/////////////////////////////////////////////////
				$('#promo_code_btn').on('click', function (e) {
				
				e.preventDefault();
				var btn = $('#promo_code_btn');
				form = btn.closest('form');
				$.ajax({
					headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
					type		:	'POST',
					url			:	'/apply_promo_code',
					data		: 	form.serialize(),  
					beforeSend	: 	function () {
						btn.button('loading');
					},
					
					success		: function(json) {
						
						btn.button('reset');
						
						var dl = $('.dl-horizontal');
						$('.alert, .help-block, .alert-success, .alert-danger').remove();
						$('.form-group').removeClass('has-error');
					
						var html = '';
						var html1 = '';
						
						if(json.code == 'promocode_applied') {
							html  =  '<div class="alert alert-success">'+json.message+'!<button type="button" class="close" data-dismiss="alert">&times;</button></div>';						
						
							dl.find('.discnt-val').text( json.fare.discount );
							dl.find('.est_val').text(json.fare.estimated_fare);
							
							setTimeout(function() {
								btn.prop('disabled', true ); // Disables the button correctly.
							}, 0);
							
							$('#promo_code_input').attr('readonly', true);
							
							
							
						} else if( json.code == 'request_error' ) {
							
							html += '<div class="alert alert-danger"><ul>';	
							var i = 0;
							$.each(json.errors, function(ind, value ) {	
							
									html += '<li>'+value[i]+'</li>';
									i++;
								}); 
								
							html += '</ul></div>';							
							$('#promo_code_input').val('');
							
							
						} else {
						
							html  =  '<div class="alert alert-danger">'+json.message+'!<button type="button" class="close" data-dismiss="alert">&times;</button></div>';							
							$('#promo_code_input').val('');
						}
						
						$('.dash-content').prepend( html );
					}
				}); 
			});    
	
			
	</script>	
			
			
		<script type="text/javascript">	
        var date = new Date();
        date.setDate(date.getDate()-1);
        $('#datepicker').datepicker({  
            startDate: date
        });	

		
        $('#timepicker').timepicker({showMeridian : false});		
        function card(value){
            if(value == 'CARD'){
                $('#card_id').fadeIn(300);
            }else{
                $('#card_id').fadeOut(300);
            }
        }	
    </script>
@endsection