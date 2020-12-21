@extends('website.app')
@section('content')
<div class="signin_page">
   <div class="container">
      <div class="row">
         <div class="col-md-6">
                  <h4>Anmelden</h4>

            <form role="form" method="POST" action= "{{ url('/provider/register') }}">
               {{ csrf_field() }}  
               <label>Name</label>
                    <input id="name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="Name" autofocus>

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif            


                <!--  <label>Last Name</label>
                <input id="name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">

                @if ($errors->has('last_name'))
                  <span class="help-block">
                      <strong>{{ $errors->first('last_name') }}</strong>
                  </span>
              @endif -->

              <label>Telefonnummer</label>
              
              <input type="text" autofocus id="phone_number" class="form-control" placeholder="Telefonnummer" name="phone_number" value="{{ old('phone_number') }}" />
              
              @if ($errors->has('phone_number'))
                  <span class="help-block">
                      <strong>{{ $errors->first('phone_number') }}</strong>
                  </span>
              @endif

              <label>E-Mail Addresse</label>
              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Addresse">

              @if ($errors->has('email'))
                  <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif

              <label>Passwort</label>
              <input id="password" type="password" class="form-control" name="password" placeholder="Passwort">

              @if ($errors->has('password'))
                  <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif

              <label>Kennwort bestätigen</label>
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Kennwort bestätigen">

              @if ($errors->has('password_confirmation'))
                  <span class="help-block">
                      <strong>{{ $errors->first('password_confirmation') }}</strong>
                  </span>
              @endif

              <label>Fahrzeug auswählen</label>
              <select class="form-control" name="service_type" id="service_type">
                <option value="">Fahrzeug auswählen</option>
                @foreach(get_all_service_types() as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                @endforeach
              </select>

              @if ($errors->has('service_type'))
                  <span class="help-block">
                      <strong>{{ $errors->first('service_type') }}</strong>
                  </span>
              @endif

              <label>Fahrzeugnummer</label>
              <input id="service-number" type="text" class="form-control" name="service_number" value="{{ old('service_number') }}" placeholder="Fahrzeugnummer">

              @if ($errors->has('service_number'))
                  <span class="help-block">
                      <strong>{{ $errors->first('service_number') }}</strong>
                  </span>
              @endif

              <label>Fahrzeugmodell</label>
              <input id="service-model" type="text" class="form-control" name="service_model" value="{{ old('service_model') }}" placeholder="Fahrzeugmodell">

              @if ($errors->has('service_model'))
                  <span class="help-block">
                      <strong>{{ $errors->first('service_model') }}</strong>
                  </span>
              @endif

               <div class="facebook_btn" style="margin-top: 10px">
                     <button value="submit" class="btnsend1">Nächster </button>
               </div>
         <h5>Bereits Konto?<a class="log-blk-btn" href="{{ url('/provider/login') }}"> Klick hier</a></h5>
               <!--<p class="helper"><a href="{{ url('/password/reset') }}">Forgot Your Password?</a></p>-->
                 @if(Setting::get('social_login', 0) == 1)
                    
                    <!--<div class="">
                        <a href="{{ url('/auth/facebook') }}"><button type="submit" class="btn btn-default" style="background-color:#3b61ad;">LOGIN WITH FACEBOOK</button></a>
                    </div>  
                    <div class="">
                        <a href="{{ url('/auth/google') }}"><button type="submit" class="btn btn-default" style="background-color:#f37151">LOGIN WITH GOOGLE+</button></a>
                    </div>-->
                @endif
         </div>

         </form>
    
     
        <div class="col-md-8" style="margin-top:77px;">
         </div>
     

      </div>
   </div>
</div>
@endsection