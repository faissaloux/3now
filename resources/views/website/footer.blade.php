<footer class="footerB">
    <div class="container">
        <div class="footer-topborder">
            <div class="row">
                <div class="col-md-4 footer-uber">
                    <div class="footer-topheading"> <img src="https://i.imgur.com/PsD6WKp.png" width="40%" height="40%" style="position: relative;top: -30px" /> </div>
                </div>
                <div class="col-md-4 footer-signup">
                    <div class="footer-topbtn"> <a href="{{ url('/') }}" class="btn btn-default button-shadow hboynas">REGISTRIEREN SIE SICH</a> </div>
                </div>
                <div class="col-md-4 footer-becomedriver">
                    <div class="footer-topbtn"> <a href="{{ url('/provider/register') }}" class="btn btn-default button-shadow">Fahrer werden</a> </div>
                </div>
            </div>
        </div>
        <div class="bottom-footer" style="padding-bottom: 100px">
            <div class="row">
                <div class="col-md-4">
                    <div class="location-footer hboynas">
                        <h4>Zum Fahren herunterladen</h4>
                        <ul class="app">
                            <li style="display: none;">
                                <a href="{{Setting::get('store_link_ios','#')}}"> <img src="{{asset('asset/front/img/appstore.png')}}" width="30%" height="30%"> </a>
                            </li>
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=de.threenow.fahrer"> <img src="{{asset('asset/front/img/playstore.png')}}" width="30%" height="30%"> </a>
                            </li>
                        </ul>
                        <h4>Auf Drive herunterladen</h4>
                        <ul class="app">
                            <li style="display: none;">
                                <a href="{{Setting::get('store_link_ios','#')}}"> <img src="{{asset('asset/front/img/appstore.png')}}" width="30%" height="30%"> </a>
                            </li>
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=de.threenow"> <img src="{{asset('asset/front/img/playstore.png')}}" width="30%" height="30%"> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="social-media">
                        <ul>
                            <li>
                                <a href="#"><img src="{{ url('asset/front_dashboard/img/facebook.png') }}" alt="facebook" /></a>
                            </li>
                            <li>
                                <a href="#"><img src="{{ url('asset/front_dashboard/img/google-plus.png') }}" alt="facebook" /></a>
                            </li>
                            <li>
                                <a href="#"><img src="{{ url('asset/front_dashboard/img/twitter.png') }}" alt="facebook" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-manu">
                        <ul>
                                    <li><a href="/page/about">Über uns</a></li>
                                    <li><a href="/page/impressum">impressum</a></li>
                                    <li><a href="/page/how-it-works" class="hboynas2">Wie es funktioniert</a></li>
                                    <li><a href="/page/datenschutz" class="hboynas2">Datenschutz-Bestimmungen</a></li>
                                    <li><a href="/page/agb">AGB</a></li>
                                    <li><a href="/page/terms-and-conditions">Fragen und Antworten</a></li>

							<!--@foreach(getPages() as $list)
                            @if($list->slug == 'about-us' || $list->slug == 'refund-policy' || $list->slug == 'why-us' || $list->slug == 'privacy-policy' || $list->slug == 'terms-conditions')
								<li><a href="{{ url('').'/'.$list->slug }}">{{ucfirst($list->title)}}</a></li>
                                @endif
							@endforeach-->
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="menu-right">
                        <ul>
                            <li><a href="{{ url('/helppage') }}" class="hboynas2">Hilfe</a></li>
                             <!-- <li><a href="{{ url('/support') }}">Suppo</a></li> -->
                            <li><a href="{{ url('/support/complaint') }}" class="hboynas2">Unterstützung</a></li>
                            <li><a href="{{ url('/contact_us') }}">Kontakt</a></li>
                            <li><a href="{{ url('/lost-item') }}" class="hboynas2">Verlorener Gegenstand</a></li>
                            <li><a href="{{ url('/') }}" class="hboynas2">Anmelden</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>