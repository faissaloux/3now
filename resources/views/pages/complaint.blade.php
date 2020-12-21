@extends('website.app')

@section('title', 'Complaint Form')
@section('content')
<style type="text/css">
    .form-control{
        background-color: #ffff !important;
    }
</style>
<div id="contact-page" class="page">    
    <section class="page-content">
        <div class="container">
            <div class="row">                   
                <div class="col-sm-12">
                    <h3>Beschwerde</h3>
                </div>
            </div>
            <div class="row">                   
                <div class="col-sm-6">
                    <h3>Nehmen wir Kontakt auf!</h3>
                    <p>Wir würden gerne von Ihnen hören. Erzählen Sie uns ein wenig über sich und Ihre Art von Frage.</p>
                    <div id="contact-form1">
                        <div class="panel-body">
                            <form class="form-horizontal" id="complaint" method="POST" action="{{route('complaint')}}">
                                    {{ csrf_field() }}
                                
                               @if(session('success'))
    <h1>{{session('success')}}</h1>
@endif
                                <div class="form-group">
                                    <label for="your_name">Dein Name*</label>
                                    <input type="text"  name="name" id="input-name" required  @if( Auth::check() ) value="{{  Auth::user()->first_name }}"  @endif class="form-control" placeholder="Dein Name*" />                           
                                </div>
                                <div class="form-group">
                                    <label for="your_email">Deine E-Mail*</label>
                                    <input type="email"  name="email" required @if( Auth::check() ) value="{{  Auth::user()->email }}"  @endif  id="input-email" class="form-control" placeholder="Deine E-Mail*" />                                                
                                </div>
                                <!-- <div class="form-group">
                                    <label for="your_phone">Your Phone*</label>
                                    <input type="text"  name="phone"  required  @if( Auth::check() ) value="{{  Auth::user()->mobile }}"  @endif   id="input-phone" class="form-control" placeholder="e.g( 96-9876543212 )" />                                                       
                                </div> -->

                                
                                @if( $data['message_cats'] )
                                <div class="form-group">
                                <label for="subject">Abteilung*</label>
                                <select class="form-control" name="transfer" id="transfer" required>
                                <option value=""> Bitte auswählen </option>
                                <option value="1">Kundenbeziehung</option>
                                <option value="2" >Dispatcher-Abteilung</option>
                                <option value="3" >Buchhaltung</option>
                            </select>                         
                                </div>
                                @endif
                                
                                <div class="form-group">
                                    <label for="your_message">Beschreibung*</label>
                                    <textarea class="form-control" required name="message" id="input-message" rows="8" placeholder="Geben Sie Ihre Beschreibung ein*"></textarea>                                                      
                                </div>
                                
                                <!-- <div class="form-group">
                                    <label for="your_attachment">Attachment</label>
                                    <input type="file" name="attachment"  accept="" id="input-attachment" class="form-control" placeholder="Your Attachment *" />                                                       
                                </div>
                                 -->
                                <div class="buttons">
                                    <input  type="submit" id="btn-complaint"  value="NACHRICHT SENDEN" data-loading-text="Sending..."  class="btn btn-info btn-block">
                                </div>
                            </form>                    
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-sm-offset-1">
                    <div class="contact-info">
                        <h3>Kontaktinformation</h3>                        
                        <ul class="ul">
                            
                            <li>
                                <p><i class="fa fa-phone"></i> Rufen Sie uns an</p>
                                <p>+49 211 69587089 </p>
                            </li>
                            <li>
                                <p><i class="fa fa-comments-o"></i> Plaudern</p>
                                <p>support</p>
                            </li>
                            <li>
                                <p><i class="fa fa-envelope"></i> Email</p>
                                <p>Info@3now.de</p>
                            </li>
                            
                        </ul>
                    </div>
                </div> 
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script type="text/javascript">var route='{{route("complaint")}}';</script>
<script type="text/javascript" src="{{ url('/asset/front/js/contact.js') }}"></script>
@endsection