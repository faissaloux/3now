@extends('admin.layout.base')

@section('title', 'Site Settings ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
			<h5 style="margin-bottom: 2em;"><span class="s-icon"><i class="ti-settings"></i></span> Geschäftseinstellungen</h5>
            <hr/>
            <form class="form-horizontal" action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}

				<div class="form-group row">
					<label for="site_title" class="col-xs-2 col-form-label">Firmenname</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ Setting::get('site_title', 'iLyft') }}" name="site_title" required id="site_title" placeholder="Business Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="site_logo" class="col-xs-2 col-form-label">Geschäftslogo</label>
					<div class="col-xs-12">
						@if(Setting::get('site_logo')!='')
	                    <img style="height: 90px; margin-bottom: 15px;" src="{{ url(Setting::get('site_logo', asset('logo-black.png'))) }}">
	                    @endif
						<input type="file" accept="image/*" name="site_logo" class="dropify form-control-file" id="site_logo" aria-describedby="fileHelp">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="site_icon" class="col-xs-2 col-form-label">Geschäftsikone</label>
					<div class="col-xs-12">
						@if(Setting::get('site_icon')!='')
	                    <img style="height: 90px; margin-bottom: 15px;" src="{{url (Setting::get('site_icon',asset('icon.png'))) }}">
	                    @endif
						<input type="file" accept="image/*" name="site_icon" class="dropify form-control-file" id="site_icon" aria-describedby="fileHelp">
					</div>
				</div>

                <div class="form-group row">
                    <label for="tax_percentage" class="col-xs-2 col-form-label">Copyright-Inhalt</label>
                    <div class="col-xs-12">
                        <input class="form-control" type="text" value="{{ Setting::get('site_copyright', '&copy; '.date('Y').' Appoets') }}" name="site_copyright" id="site_copyright" placeholder="Site Copyright">
                    </div>
                </div>

				<div class="form-group row">
					<label for="store_link_android" class="col-xs-2 col-form-label">Playstore-Link</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ Setting::get('store_link_android', '') }}" name="store_link_android"  id="store_link_android" placeholder="Playstore link">
					</div>
				</div>

				<div class="form-group row">
					<label for="store_link_ios" class="col-xs-2 col-form-label">Appstore Link</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ Setting::get('store_link_ios', '') }}" name="store_link_ios"  id="store_link_ios" placeholder="Appstore link">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="store_link_ios" class="col-xs-2 col-form-label">Entfernungseinheit</label>
					<div class="col-xs-12">
					    
				<select class="form-control" id="sel1" name="unit">
				 <option value="none">---- Entfernungseinheit auswählen----</option>
                 <option value="KM" <?php if(Setting::get('unit') == 'KM' ) echo 'selected' ; ?> >KM</option>
                 <option value="MILES" <?php if(Setting::get('unit') == 'MILES' ) echo 'selected' ; ?>>MEILEN</option>
                
                </select>
              	</div>
				</div>
				
				<div class="form-group row">
					<label for="provider_select_timeout" class="col-xs-4 col-form-label">Zeitüberschreitung bei der Fahrerakzeptanz</label>
					<div class="col-xs-12">
						<input class="form-control" type="number" value="{{ Setting::get('provider_select_timeout', '60') }}" name="provider_select_timeout" required id="provider_select_timeout" placeholder="Provider Timout">
					</div>
				</div>
				
					<div class="form-group row">
					<label for="contact_email" class="col-xs-2 col-form-label">Wartezeit</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ Setting::get('waiting_time_out', '') }}" name="waiting_time_out" required id="waiting_time_out" placeholder="Schedule Request Time">
					</div>
				</div>

				<div class="form-group row">
					<label for="provider_search_radius" class="col-xs-2 col-form-label">Anbietersuchradius</label>
					<div class="col-xs-12">
						<input class="form-control" type="number" value="{{ Setting::get('provider_search_radius', '100') }}" name="provider_search_radius" required id="provider_search_radius" placeholder="Provider Search Radius">
					</div>
				</div>

				<div class="form-group row">
					<label for="sos_number" class="col-xs-2 col-form-label">Notrufnummer</label>
					<div class="col-xs-12">
						<input class="form-control" type="number" value="{{ Setting::get('sos_number', '911') }}" name="sos_number" required id="sos_number" placeholder="SOS Number">
					</div>
				</div>

				<div class="form-group row">
					<label for="contact_number" class="col-xs-2 col-form-label">Kontakt Nummer</label>
					<div class="col-xs-12">
						<input class="form-control" type="number" value="{{ Setting::get('contact_number', '911') }}" name="contact_number" required id="contact_number" placeholder="Contact Number">
					</div>
				</div>

				<div class="form-group row">
					<label for="contact_email" class="col-xs-2 col-form-label"> Email</label>
					<div class="col-xs-12">
						<input class="form-control" type="email" value="{{ Setting::get('contact_email', '') }}" name="contact_email" required id="contact_email" placeholder="Contact Email">
					</div>
				</div>
				<div class="form-group row">
					<label for="contact_email" class="col-xs-4 col-form-label">Auslösezeit einplanen</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ Setting::get('schedule_req_time', '') }}" name="schedule_req_time" required id="schedule_req_time" placeholder="Schedule Request Time">
					</div>
				</div>
				
			   <div class="form-group row">
			   <label for="store_link_ios" class="col-xs-4 col-form-label">Überprüfung des Fahrertelefons</label>
				<div class="col-xs-12">
				<select class="form-control" id="driver_phone" name="driver_phone">
				 <option value="none">---- Entfernungseinheit auswählen----</option>
                 <option value="Y" <?php if(Setting::get('driver_phone') == 'Y' ) echo 'selected' ; ?> >Y</option>
                 <option value="N" <?php if(Setting::get('driver_phone') == 'N' ) echo 'selected' ; ?>>N</option>
                </select>
              	</div>
				</div>
				<div class="form-group row">
			   <label for="store_link_ios" class="col-xs-4 col-form-label">Überprüfung der Treiber-E-Mail</label>
				<div class="col-xs-12">
				<select class="form-control" id="driver_email" name="driver_email">
				 <option value="none">---- Entfernungseinheit auswählen----</option>
                 <option value="Y" <?php if(Setting::get('driver_email') == 'Y' ) echo 'selected' ; ?> >Y</option>
                 <option value="N" <?php if(Setting::get('driver_email') == 'N' ) echo 'selected' ; ?>>N</option>
                </select>
              	</div>
				</div>
				<div class="form-group row">
			   <label for="store_link_ios" class="col-xs-4 col-form-label">Benutzertelefonüberprüfung</label>
				<div class="col-xs-12">
				<select class="form-control" id="user_phone" name="user_phone">
				 <option value="none">---- Entfernungseinheit auswählen----</option>
                 <option value="Y" <?php if(Setting::get('user_phone') == 'Y' ) echo 'selected' ; ?> >Y</option>
                 <option value="N" <?php if(Setting::get('user_phone') == 'N' ) echo 'selected' ; ?>>N</option>
                </select>
              	</div>
				</div>
				<div class="form-group row">
			   <label for="store_link_ios" class="col-xs-4 col-form-label">Benutzer-E-Mail-Validierung</label>
				<div class="col-xs-12">
				<select class="form-control" id="user_email" name="user_email">
				 <option value="none">---- Entfernungseinheit auswählen----</option>
                 <option value="Y" <?php if(Setting::get('user_email') == 'Y' ) echo 'selected' ; ?> >Y</option>
                 <option value="N" <?php if(Setting::get('user_email') == 'N' ) echo 'selected' ; ?>>N</option>
                </select>
              	</div>
				</div>

				<div class="form-group row">
					<label for="contact_email" class="col-xs-4 col-form-label">Fahrtstornierungsminute (Sekunde)</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ Setting::get('ride_cancal_min', '') }}" name="ride_cancal_min" required id="ride_cancal_min" placeholder="In Second">
					</div>
				</div>

				<div class="form-group row">
					<label for="contact_email" class="col-xs-4 col-form-label">Fahrtstornierungsgebühren ($)</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ Setting::get('ride_cancal_chage', '') }}" name="ride_cancal_chage" required id="ride_cancal_chage" placeholder="In $">
					</div>
				</div>
                <div class="form-group row">
					<label for="contact_email" class="col-xs-4 col-form-label">Planmäßige Zeit</label>
					<div class="col-xs-12">
						<input class="form-control" type="text" value="{{ Setting::get('schedule_time','') }}" name="schedule_time" required id="schedule_time" placeholder="Schedule Time">
					</div>
				</div>
				<div class="form-group row">
					<label for="additional_price" class="col-xs-4 col-form-label">Zusätzlicher Preis (Prozent)</label>
					<div class="col-xs-12">
						<input class="form-control"  type="number" min='0' max='100' value="{{ Setting::get('additional_price','') }}" name="additional_price"  id="additional_price" placeholder="Additional price">
					</div>
				</div>
				<div class="form-group row">
					<label for="social_login" class="col-xs-2 col-form-label">Plaudern</label>
					<div class="col-xs-12">
						<select class="form-control" id="chat" name="chat">
							<option value="1" @if(Setting::get('chat', 0) == 1) selected @endif>Aktivieren</option>
							<option value="0" @if(Setting::get('chat', 0) == 0) selected @endif>Deaktivieren</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="social_login" class="col-xs-2 col-form-label">Social Login</label>
					<div class="col-xs-12">
						<select class="form-control" id="social_login" name="social_login">
							<option value="1" @if(Setting::get('social_login', 0) == 1) selected @endif>Aktivieren</option>
							<option value="0" @if(Setting::get('social_login', 0) == 0) selected @endif>Deaktivieren</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-12">
						<button type="submit" class="btn btn-primary btn-success">Aktualisieren</button>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>
@endsection
