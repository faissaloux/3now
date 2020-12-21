@extends('website.app')
@section('content')
<div class="signin_page">
   <div class="container">
      <div class="row">
         <div class="col-md-6" style="margin-top: 35px;">
            <h4>Anmeldung</h4>
            <form role="form" method="POST" action="{{ url('/login') }}" style="margin-bottom:10px;">
               {{ csrf_field() }}  
               <label>Email</label>
               <input id="email" name="email" class="form-control" type="text" placeholder="Email" value="{{ old('email') }}" required > 
               @if ($errors->has('email'))
               <span class="help-block">
               <strong>{{ $errors->first('email') }}</strong>
               </span>
               @endif
               <label>Passwort</label> 
               <input id="password" name="password" class="form-control" type="password" placeholder="Passwort" required>
               @if ($errors->has('password'))
               <span class="help-block">
               <strong>{{ $errors->first('password') }}</strong>
               </span>
               @endif
               <div class="facebook_btn" style="margin-top: 10px">
                     <button value="submit" class="btnsend1">Nächster </button>
               </div>
               <p>Sie haben noch keinen Account? <a href="{{ url('/register') }}">Anmelden</a></p>
               <p class="helper"><a href="{{ url('/password/reset') }}">Passwort vergessen?</a></p>
			   	
        
         </form>
		<!--  @if(Setting::get('social_login', 0) == 1)
			<div class="">
				<a href="{{ url('/auth/facebook') }}"><button type="submit" class="btn btn-default" style="background-color:#3b61ad;">LOGIN WITH FACEBOOK</button></a>
			</div>  
			<div class="">
				<a href="{{ url('/auth/google') }}"><button type="submit" class="btn btn-default" style="background-color:#f37151">LOGIN WITH GOOGLE+</button></a>
			</div>
		@endif -->
		 </div>
         <div class="col-md-8">
         </div>
		 

      </div>
   </div>
</div>
@endsection