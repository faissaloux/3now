
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <title>3now | Mit uns fahren = Geld sparen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/public/asset/new/css/styles.css?v=1.3.2">
    <link rel="icon" type="image/png" href="/public/favicon.svg" />


    <style>
      #map {
          height: 100% !important;
      }
      .container1 {padding: 100px 0;}

      section.container0 {
          height: 400px;
      }



      .hboynas {
          visibility: hidden !important;
      }

      .hboynas2 {
          display: none !important;
      }

      img.talimg {
          width: 300px;
      }

      .tadivt {
          display: inline-block;
          min-width: 350px;    
      }

      .nes {
          width: 50%;
          float: left;
      }

      .nes label {
          text-align: left !important;
          padding-left: 0px;
      }

      section.container1 {
    width: 100%;
}
    </style>  

  </head>
  <body>

    <header class='hidenme'>
      <nav>
        <img class="logo" src="/public/asset/new/cars/logoB.png" alt="3NOW logo">
        <div class="con">
        <a href="#Download"><button class="btn btn1">App herunterladen</button></a>
        <a href="/register"><button class="btn btn2"> Anmelden </button></a>
        </div>
      </nav>
      <div class="hero">
    <?php if(Session::has('message')): ?>
      <p class="alert <?php echo e(Session::get('alert-class', 'alert-info')); ?>"><?php echo e(Session::get('message')); ?></p>
    <?php endif; ?>

      <h1>Mit uns fahren = Geld sparen
        <br>
      </h1>
      

      <p>  Mit 3NOW kannst Du in 2 Schritten ans Ziel kommen.  </p>
      </div>

          <form class="booking">
            <img src="/public/asset/new/img/ziel.png" alt="">
            <label> Abholort (straße, hausnummer, plz)</label>
            <input type="text"  id="origin-input"  class="btntext" placeholder="Start">

            <label>  Zielort (straße, hausnummer, plz)</label>
            <input type="text"  id="destination-input" class="btntext" placeholder="Ziel">

            <div class="tadivt">
              <div class="nes">
                <label class="ldfklsklls">Datum Hinfahrt</label>
                <label for="" class='phone_lone'>Datum Hinfahrt</label>
                <input type="datetime-local" class="go_get_info from_field btntext Date" placeholder="Ziel">  
              </div>
              <div class="nes">
                <label class="ldfklsklls">Datum Rückfahrt</label>
                <label for="" class='phone_lone'>Datum Rückfahrt</label>
                <input type="datetime-local" class="go_get_info to_field btntext Date" placeholder="Ziel">
              </div>
              
            </div>
          </form>
        <div class="carBox">
          <article class="btncar">
            <img src="/public/asset/new/img/c.png" alt="C-klass">
          <a href="javascipt:;" data-price='' data-car='c-klasse'  style='display:none;'><button class="btn btn1">
         
            <span class="c-klasse"></span>
        
            €
          </button></a>
          </article>

          <article class="btncar">
            <img src="/public/asset/new/img/e.png" alt="E-klass">
          <a href="javascipt:;" data-price='' data-car='e-klasse'  style='display:none;'> <button class="btn btn1">
            <span class="e-klasse"></span>

            €
          </button></a>
          </article>
          <article class="btncar">
          <img src="/public/asset/new/cars/vito.png" alt="Vito">
            <a href="javascipt:;" data-price='' data-car='vito'  style='display:none;'><button class="btn btn1">
            <span class="vito"></span>

            €
          </button></a>

          </article>
          <article class="btncar">
            <img src="/public/asset/new/cars/v-klasse.png" alt="V-klass">
            <a href="javascipt:;" data-price='' data-car='v-klasse'  style='display:none;'><button class="btn btn1">
            <span class="v-klasse"></span>

            €
          </button></a>
          </article>

        </div>
    </header>
 
    <section class="container0 hidenme">
      <img src="/public/asset/new/img/Asset1.png" class="talimg" alt="">
      <section class="container1">
      <article class="Pic">
      <img src="/public/asset/new/img/p.png" alt="Preiswert">
        <h4>Günstig</h4>
        <p>Komfort genießen und dabei min. 20% sparen</p>
      </article>

      <article class="Pic hidenme">
        <img src="/public/asset/new/img/k.png" alt="Preiswert">
        </h4>
        <h4>Komfortabel</h4>
        <p>Mit PayPal, Kreditkarte
oder Bar bezahlen und die
Rechnung bequem über die
App ausdrucken</p>
      </article>

      <article class="Pic hidenme">
        <img src="/public/asset/new/img/s.png" alt="Preiswert">
        <h4>Sicher</h4>
        <p>Unsere registierten Fahrer sorgen
immer für eine sichere Fahrt
zum Ziehlort
</p>
      </article>
      </section>


    </section>



    <section class="container0 hidenme fonction">
      <h3>Wie funktioniert 3Now?</h3>
      <section class="container1">
      <article class="Pic">
        <img src="/public/asset/new/img/z.png" alt="Adresse eingeben">
        <h4>Adresse eingeben</h4>
        <p>Abholort und das
gewünschte Ziel angeben </p>
      </article>

      <article class="Pic hidenme">
        <img src="/public/asset/new/img/bez.png" alt="zahlmethoden auswählen">
        <h4>Zahlungsart auswählen
      </h4>
        <p>PayPal, Kreditkarte oder Bar</p>
      </article>

      <article class="Pic hidenme">

        <img src="/public/asset/new/img/fahrer.png" alt="Bis gleich">
        <h4>Bis gleich</h4>
        <p></p>
     
        <p>Unser 3now Fahrer komme zum
angegeben Ort</p>
      </article>
      </section>



    </section>

    <section class="app hidenme" id="Download">
 

      <article class="stor">
        <p>Jetzt das App kostenlos herunterladen</p>
        <a href="https://apps.apple.com/nz/app/3now/id1524167394">
        <img src="/public/asset/new/img/apple.png" alt="">
        </a>
        <a href="https://play.google.com/store/apps/details?id=de.threenow">
        <img src="/public/asset/new/img/android.png" alt="">
        </a>
      </article>
      <img class="teleBa7" src="/public/asset/new/img/appimg2.png" alt="">
    </section>






    <footer class="hidenme">
           <div class="container-footer">
            <div class="footer-topborder">
                        <div class="row">
                            <div class="col-md-4 footer-uber">
                              

                                <div class="footer-topheading"> <img src="/public/asset/new/cars/logoB.png"> </div>
                            </div>
                            <div class="col-md-4 footer-signup">
                                <div class="footer-topbtn"> <a href="https://www.3now.de" class="btn btn-default button-shadow hboynas">REGISTRIEREN SIE SICH</a> </div>
                            </div>
                            <div class="col-md-4 footer-becomedriver">
                                <div class="footer-topbtn"> <a href="https://www.3now.de/provider/register" class="btn btn-default button-shadow">Fahrer werden</a> </div>
                            </div>
                        </div>
                    </div>
                  <div class="col-md-4">
                    <div class="location-footer hboynas">
                        <h4>Zum Fahren herunterladen</h4>
                        <ul class="app">
                            <li style="display: none;">

                                <a href=""> <img src="/asset/front/img/appstore.png" > </a>
                            </li>
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=de.threenow"> <img src="/asset/front/img/playstore.png" > </a>
                            </li>
                        </ul>
                        <h4>Auf Drive herunterladen</h4>
                        <ul class="app">
                            <li style="display: none;">
                                <a href=""> <img src="/asset/front/img/appstore.png"> </a>
                            </li>
                            <li>
                                <a href="https://play.google.com/store/apps/details?id=de.threenow"> <img src="/asset/front/img/playstore.png" > </a>
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
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="menu-right">
                        <ul>
                            <li><a href="https://www.3now.de/helppage" class="hboynas2">Hilfe</a></li>
                            <li><a href="https://www.3now.de/support/complaint" class="hboynas2">Unterstützung</a></li>
                            <li><a href="https://www.3now.de/contact_us">Kontakt</a></li>
                            <li><a href="https://www.3now.de/lost-item" class="hboynas2">Verlorener Gegenstand</a></li>
                            <li><a href="https://www.3now.de" class="hboynas2">Anmelden</a></li>
                        </ul>
                    </div>
                </div>
                </div>
    </footer>






<section class="container" id="nextStep" style="display: none">
        <div class="conb conb1" style="    float: left;">
        <h3>Zusätzliche Wünsche</h3>

        <article class="op">
                    <div class="Kindersitzicon"></div>

          <h5>Kindersitz</h5>
          <p>Für den Fall, dass mehr als ein Sitz
          angefordert wird, sind 5€ zu zahlen.</p>
            <input type="number"   class="btntext number kindersitz" placeholder="1 " max="2" value='1' frei>
        </article>


        <article class="op">
          <div class="Babyschaleicon"></div>
          <h5>Babyschale</h5>
          <p>Für den Fall, dass mehr als einen Schale
            angefordert wird, sind 10€ zu zahlen.</p>
            <input type="number" class="btntext number babyschale" placeholder="1" value='1'  max="2">

        </article>



        <article class="op">
          <div class="Namensschieldicon"></div>
          <h5>Namenschield</h5>       

          
          <input type="checkbox" class="namensschield_active" />
            <p>Bei Bestellung mit Namensschild
              wird eine Gebühr von 15€ fällig.</p>
              <input type="text" class="reg btntext namensschield_desc" placeholder="Bitte Namen eingeben">
        </article>


        <article class="op Bemerkungen">
                  <h3>Bemerkungen</h3>
              <input type="text" class="reg btntext bemerkungen" placeholder="Hier Bemerkung schreiben">
        </article>







      <article class="op Registrieren" >
        <h3>Registrieren</h3>
          <input type="text" class="reg1 reg vorname btntext"  placeholder="Vorname" />
          <input type="text" class="reg1 reg btntext nachname"  placeholder="Nachname" />
          <input type="text" class="reg btntext eingeben"  placeholder="Handynummer eingeben " />
          <input type="email" class="reg emailadress btntext"  placeholder="E-Mail Adresse eingeben " />
      </article>

 

        <article class="kase">

          <p>ink. 16% MwSt</p>
          <h1 class='main_price'><span ></span>€</h1>
          
          </article> <a href="javascript:;" id="go_pay"> <button class="btn btn1">
<img src="https://media1.tenor.com/images/d6cd5151c04765d1992edfde14483068/tenor.gif" style="display: none" class="loading">
          Bestätigen</button></a>
          </article>
          <div class="errors"></div>

    </div>


    <div class="conb conb2" style="display: none">
      
  <article class="payementForm">
    <h1 style='margin-bottom: 25px;'>Wählen Sie eine Bezahlungsart</h1>
  <table>
    <tr>
      <td><input type="checkbox" value="paypal" id="paypal_logo" name="payementMethod" class="payementMethod" /></td>
      <td><label for="paypal_logo"><img src="/public/asset/new/cars/paypal.png"  class="paypal_logo" ></label></td>
    </tr>
     <tr>
      <td><input type="checkbox" value="stripe" id='stripe_logo' name="payementMethod" class="payementMethod" /></td>
      <td><label for="stripe_logo"><img src="/public/asset/new/cars/stripe.png" class="stripe_logo"></label></td>
    </tr>
    <tr>
      <td><input type="checkbox" value="cash" id='cash_logo' name="payementMethod" class="payementMethod" checked /></td>
      <td><label for="cash_logo"><img src="https://i.imgur.com/pk34bNl.png" class="cash_logo"></label></td>
    </tr>
     <tr>
      <td colspan="2"> <a style="margin-top: 35px;" href="javascript:;" id='finish_form' class="btn btn1" >Bestätigen</a>  </td>
    </tr>
  </table>



<style type="text/css">
  img.cash_logo {
     width: 100px !important;
}
</style>




   <form role="form" action="<?php echo e(route('stripe.post')); ?>" style='display: none;' method="post" class="require-validation"
                                                     data-cc-on-file="false"
                                                    data-stripe-publishable-key="<?php echo e(env('STRIPE_KEY')); ?>"
                                                    id="payment-form">
  
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name auf der Karte</label> <input
                                    class='form-control' size='4' type='text'>
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Kartennummer</label> <input
                                    autocomplete='off' class='form-control card-number' id="card-number" size='20'
                                    type='text'>
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Monat des Ablaufens</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Ablaufjahr</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'></div>
                            </div>
                        </div>
  
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Zahlen Sie jetzt</button>
                            </div>
                        </div>
                          
                    </form>



  </article>

    </div>

   <div id="map" style=' width:60%;   float: left;   height: 900px;'></div>


  </section>

  


<form  method="POST"  action="web/payment" id="location_form" >
      <?php echo e(csrf_field()); ?>

      <input type="hidden" name="s_address" id="s_address">
      <input type="hidden" name="d_address" id="d_address">
      <input type="hidden" name="s_latitude" id="origin_latitude">
      <input type="hidden" name="s_longitude" id="origin_longitude">
      <input type="hidden" name="d_latitude" id="destination_latitude">
      <input type="hidden" name="d_longitude" id="destination_longitude">
      <input type="hidden" name="current_longitude" id="long">
      <input type="hidden" name="current_latitude" id="lat">
      <input type="hidden" name="car" id="chosen_car" />
      <input type="hidden" name="from" id="chosen_from" />
      <input type="hidden" name="to" id="chosen_to" />
      <input type="hidden" name="destination-input" id="destination_input" />
      <input type="hidden" name="origin-input" id="origin_input" />
      <input type="hidden" name="price" id="original_price" />
      <input type="hidden" name="kindersitz" id="kindersitz" />
      <input type="hidden" name="babyschale" id="babyschale" />
      <input type="hidden" name="namensschield_active" id="namensschield_active" />
      <input type="hidden" name="namensschield_desc" id="namensschield_desc" />
      <input type="hidden" name="bemerkungen" id="bemerkungen" />
      <input type="hidden" name="method" id="method" />
      <input type="hidden" name="total" id="total" />
      <input type="hidden" name="distance" id="distance" />
      <input type="hidden" name="vorname" id="vorname" >
      <input type="hidden" name="nachname" id="nachname" >
      <input type="hidden" name="eingeben" id="Handynummer" >
      <input type="hidden" name="emailadress" id="emailadress" >
</form>


<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script>
var current_latitude = 52.52,
  current_longitude = 13.405;

function initMap() {
  var e = new google.maps.Map(document.getElementById("map"), {
    mapTypeControl: !1,
    zoomControl: !0,
    center: {
      lat: current_latitude,
      lng: current_longitude
    },
    zoom: 1,
    styles: [{
      elementType: "geometry",
      stylers: [{
        color: "#f5f5f5"
      }]
    }, {
      elementType: "labels.icon",
      stylers: [{
        visibility: "off"
      }]
    }, {
      elementType: "labels.text.fill",
      stylers: [{
        color: "#616161"
      }]
    }, {
      elementType: "labels.text.stroke",
      stylers: [{
        color: "#f5f5f5"
      }]
    }, {
      featureType: "administrative.land_parcel",
      elementType: "labels.text.fill",
      stylers: [{
        color: "#bdbdbd"
      }]
    }, {
      featureType: "landscape.man_made",
      elementType: "geometry",
      stylers: [{
        color: "#e4e8e9"
      }]
    }, {
      featureType: "poi",
      elementType: "geometry",
      stylers: [{
        color: "#eeeeee"
      }]
    }, {
      featureType: "poi",
      elementType: "labels.text.fill",
      stylers: [{
        color: "#757575"
      }]
    }, {
      featureType: "poi.park",
      elementType: "geometry",
      stylers: [{
        color: "#e5e5e5"
      }]
    }, {
      featureType: "poi.park",
      elementType: "geometry.fill",
      stylers: [{
        color: "#7de843"
      }]
    }, {
      featureType: "poi.park",
      elementType: "labels.text.fill",
      stylers: [{
        color: "#9e9e9e"
      }]
    }, {
      featureType: "road",
      elementType: "geometry",
      stylers: [{
        color: "#ffffff"
      }]
    }, {
      featureType: "road.arterial",
      elementType: "labels.text.fill",
      stylers: [{
        color: "#757575"
      }]
    }, {
      featureType: "road.highway",
      elementType: "geometry",
      stylers: [{
        color: "#dadada"
      }]
    }, {
      featureType: "road.highway",
      elementType: "labels.text.fill",
      stylers: [{
        color: "#616161"
      }]
    }, {
      featureType: "road.local",
      elementType: "labels.text.fill",
      stylers: [{
        color: "#9e9e9e"
      }]
    }, {
      featureType: "transit.line",
      elementType: "geometry",
      stylers: [{
        color: "#e5e5e5"
      }]
    }, {
      featureType: "transit.station",
      elementType: "geometry",
      stylers: [{
        color: "#eeeeee"
      }]
    }, {
      featureType: "water",
      elementType: "geometry",
      stylers: [{
        color: "#c9c9c9"
      }]
    }, {
      featureType: "water",
      elementType: "geometry.fill",
      stylers: [{
        color: "#9bd0e8"
      }]
    }, {
      featureType: "water",
      elementType: "labels.text.fill",
      stylers: [{
        color: "#9e9e9e"
      }]
    }]
  });
  new AutocompleteDirectionsHandler(e);
  var t, a = document.getElementById("origin_latitude").value,
    n = document.getElementById("origin_longitude").value,
    i = document.getElementById("destination_latitude").value,
    o = document.getElementById("destination_longitude").value;
  a.length && n.length && i.length && o.length && (t = new google.maps.Polyline({
    strokeColor: "#111",
    strokeOpacity: .8,
    strokeWeight: 4
  }), directionsService = new google.maps.DirectionsService, directionsDisplay = new google.maps.DirectionsRenderer({
    map: e,
    suppressMarkers: !1,
    polylineOptions: t
  }))
}

function AutocompleteDirectionsHandler(e) {
  this.map = e, this.originPlaceId = null, this.destinationPlaceId = null, this.travelMode = "DRIVING";
  var t = document.getElementById("origin-input"),
    a = document.getElementById("destination-input"),
    n = (document.getElementById("mode-selector"), document.getElementById("origin_latitude")),
    i = document.getElementById("origin_longitude"),
    o = document.getElementById("destination_latitude"),
    l = document.getElementById("destination_longitude"),
    r = new google.maps.Polyline({
      strokeColor: "#111",
      strokeOpacity: .8,
      strokeWeight: 4
    });
  this.directionsService = new google.maps.DirectionsService, this.directionsDisplay = new google.maps.DirectionsRenderer({
    suppressMarkers: !1,
    polylineOptions: r
  }), this.directionsDisplay.setMap(e);
  var s = new google.maps.places.Autocomplete(t),
    c = new google.maps.places.Autocomplete(a);
  s.addListener("place_changed", function (e) {
    var t = s.getPlace();
    if (t.hasOwnProperty("place_id")) {
      if (!t.geometry) return;
      n.value = t.geometry.location.lat(), i.value = t.geometry.location.lng()
    } else service.textSearch({
      query: t.name
    }, function (e, t) {
      t == google.maps.places.PlacesServiceStatus.OK && (n.value = e[0].geometry.location.lat(), i.value = e[0].geometry.location.lng())
    })
  }), c.addListener("place_changed", function (e) {
    var t = c.getPlace();
    if (t.hasOwnProperty("place_id")) {
      if (!t.geometry) return;
      o.value = t.geometry.location.lat(), l.value = t.geometry.location.lng()
    } else service.textSearch({
      query: t.name
    }, function (e, t) {
      t == google.maps.places.PlacesServiceStatus.OK && (o.value = e[0].geometry.location.lat(), l.value = e[0].geometry.location.lng())
    })
  }), this.setupPlaceChangedListener(s, "ORIG"), this.setupPlaceChangedListener(c, "DEST")
}

function calculatePrice() {
  var e = parseFloat($("#original_price").val()),
    t = $("body .kindersitz").val(),
    a = $("body .babyschale").val();
  return 1 < t && (e += 5 * t - 5), 1 < a && (e += 10 * a - 10), $("body .namensschield_active").is(":checked") && (e += 15), $("body .main_price span").html(e), $("#total").val(e), e
}
AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function (t, a) {
  var n = this;
  t.bindTo("bounds", this.map), t.addListener("place_changed", function () {
    var e = t.getPlace();
    e.place_id && ("ORIG" === a ? n.originPlaceId = e.place_id : n.destinationPlaceId = e.place_id, n.route())
  })
}, AutocompleteDirectionsHandler.prototype.route = function () {
  var a;
  this.originPlaceId && this.destinationPlaceId && (a = this).directionsService.route({
    origin: {
      placeId: this.originPlaceId
    },
    destination: {
      placeId: this.destinationPlaceId
    },
    travelMode: this.travelMode
  }, function (e, t) {
    "OK" === t && a.directionsDisplay.setDirections(e)
  })
}, $("body #origin-input").change(function () {
  $("#location_form #origin_input").val($(this).val())
}), $("body #destination-input").change(function () {
  $("#location_form #destination_input").val($(this).val())
}), $("body .to_field ").change(function () {
  $("body #chosen_to").val($(this).val())
}), $("body .from_field  ").change(function () {
  $("body #chosen_from").val($(this).val())
}), $("body .kindersitz").change(function () {
  $("body #kindersitz").val($(this).val()), calculatePrice()
}), $("body .babyschale").change(function () {
  $("body #babyschale").val($(this).val()), calculatePrice()
}), $("body .namensschield_active").click(function () {
  $(this).is(":checked") ? $("body #namensschield_active").val("1") : $("body #namensschield_active").val("0"), calculatePrice()
}), $("body .namensschield_desc").change(function () {
  $("body #namensschield_desc").val($(this).val()), calculatePrice()
}), $("body .bemerkungen").change(function () {
  $("body #bemerkungen").val($(this).val()), calculatePrice()
}), $("body .from_field").change(function () {
  $("body #from_field").val($(this).val())
}), $("body .to_field").change(function () {
  $("body #to_field").val($(this).val())
}), $("body .to_field").bind("keyup change paste", function (e) {
  var t = $("#location_form"),
    a = (t.find("#origin_input"), t.find("#destination_input"), t.find("#origin_latitude").val(), t.find("#origin_longitude").val(), t.find("#destination_latitude").val(), t.find("#destination_longitude").val(), t.find("#from_field").val(), t.find("#to_field").val(), t.serializeArray());
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    type: "POST",
    url: "/web/order/getPrices",
    data: a,
    success: function (e) {
      $("body .btncar a").show(), $.each(e, function (e, t) {
        "distance" == e ? $("#location_form #distance").val(t) : ($("span." + e).html(t), $('[data-car="' + e + '"]').attr("data-price", t))
      })
    }
  })
}), $("body .from_field").bind("keyup change paste", function (e) {
  var t = $("#location_form"),
    a = (t.find("#origin_input"), t.find("#destination_input"), t.find("#origin_latitude").val(), t.find("#origin_longitude").val(), t.find("#destination_latitude").val(), t.find("#destination_longitude").val(), t.find("#from_field").val(), t.find("#to_field").val(), t.serializeArray());
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    type: "POST",
    url: "/web/order/getPrices",
    data: a,
    success: function (e) {
      $("body .btncar a").show(), $.each(e, function (e, t) {
        "distance" == e ? $("#location_form #distance").val(t) : ($("span." + e).html(t), $('[data-car="' + e + '"]').attr("data-price", t))
      })
    }
  })
}), $(".btncar a").click(function () {
  var e = $("#origin-input").val();
  $("#s_address").val(e);
  var t = $("#destination-input").val();
  $("#d_address").val(t);
  var a = $(this).attr("data-price");
  $("#nextStep").show(), $("body .hidenme").hide(), $("#chosen_car").val($(this).attr("data-car")), $("#original_price").val(a), $(".main_price span").html(a), $("#location_form #total").val(a)
}), 


$("#go_pay").click(function () {

  $(this).find("button").prop("disabled", !0), $(this).find(".loading").show();
  var e = $("body .kindersitz").val();
  $("#kindersitz").val(e);
  var t = $("body .babyschale").val();
  $("#babyschale").val(t);
  
  /*
  $("body .namensschield_active").val() ? $("#namensschield_active").val("true") : $("#namensschield_active").val("false");
  */
  var a = $("body .namensschield_desc").val();
  $("#namensschield_desc").val(a);


    if($('.namensschield_active').is(":checked")){
          $('#namensschield_active').val('true');
    }else {
        $('#namensschield_active').val('false');
    }


  var n = $(".Registrieren .vorname").val(),
    i = $(".Registrieren .nachname").val(),
    o = $(".Registrieren .eingeben").val(),
    l = $(".Registrieren .emailadress").val();
  $("#location_form #vorname").val(n), $("#location_form #nachname").val(i), $("#location_form #Handynummer").val(o), $("#location_form #emailadress").val(l);
  var r = $("#location_form").serializeArray();
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    type: "POST",
    url: "/save/scheduled/order",
    data: r,
    success: function (e) {
      return "found" == e ? $(".errors").html("E-Mail existiert bereits") : ($(".errors").html(""), $(".conb2").show(), $(".conb1").hide()), !1
    }
  })
}), 


$("body #finish_form").click(function (e) {

     e.preventDefault();

     var t = $('body input[name="payementMethod"]:checked').val();


       if( t == 'cash'){
           return window.location.href = "/thankyou";
     	}


  

      "stripe" == t ? $("#payment-form").show() : ($("#method").val(t), $("#payment-form").hide(), 


   

    $("#location_form").submit())
}), $(function () {
  var i = $(".require-validation");

  function o(e, t) {
    if (console.log(t), !t.error) {
      $("body .alert").removeClass("show");
      var a = t.id,
        n = calculatePrice();
       i.append("<input type='hidden' class='my_stripeToken' name='stripeToken' value='" + a + "'/>"), 

      i.append("<input type='hidden' class='my_price' name='price' value='" + n + "'/>");

        if(t.error){
              $(".error").removeClass("hide").find(".alert").addClass("show").text(t.error); 
        }else {
              $(".error").addClass("hide").find(".alert").removeClass("show");
        }

      var formData = new FormData();
      var link = $("form.require-validation").attr('action');   
      var my_stripeToken = $("body .my_stripeToken").val();
      var my_price = $("body .my_price").val();

      formData.append('my_stripeToken', my_stripeToken);  
      formData.append('my_price', my_price);  
      


     $.ajax({
        url: link,
        type: 'POST',
        processData: false, 
        contentType: false, 
        data: formData ,
        cache:false,
        dataType: "html",
        success: function(response) {
            if(response == 'Payment successful'){
                window.location.href = "/thankyou";
            }else{

               $(".error").removeClass("hide").find(".alert").addClass("show").text(response); 
            }
        },
        error : function(response){
         
        }
     });





    }else{
          $(".error").removeClass("hide").find(".alert").addClass("show").text(t.error.message); 
    }
   // 
  }
  $("form.require-validation").bind("submit", function (n) {

    /*
    if($("form.require-validation #stripeToken").length){



    }else {

    }
    */

    var e = $(".require-validation"),
      t = ["input[type=email]", "input[type=password]", "input[type=text]", "input[type=file]", "textarea"].join(", "),
      a = e.find(".required").find(t),
      i = e.find("div.error");
    i.addClass("hide"), $(".has-error").removeClass("has-error"), a.each(function (e, t) {
      var a = $(t);
      "" === a.val() && (a.parent().addClass("has-error"), i.removeClass("hide"), n.preventDefault())
    }), e.data("cc-on-file") || (n.preventDefault(), console.log("working", e.data("stripe-publishable-key")), Stripe.setPublishableKey(e.data("stripe-publishable-key")), 

    Stripe.createToken({
      number: $("#card-number").val(),
      cvc: $(".card-cvc").val(),
      exp_month: $(".card-expiry-month").val(),
      exp_year: $(".card-expiry-year").val()
    }, o))




     console.log('the end');
     return false;

  })
}), $(".cc-num").keyup(function () {
  this.value.length == this.maxLength && ($(this).next(".cc-num").length ? $(this).next(".cc-num").focus() : $(this).blur())
}), $(".cc-num").on("focusin", function () {
  $(".cc-num").attr("type", "password"), $(this).attr("type", "text"), $(".card-number").addClass("focused")
}), $(".cc-num").on("focusout", function () {
  $(".card-number").removeClass("focused")
}), $(".dropdown").click(function () {
  $(this).next("ul").stop().slideToggle(), $(this).toggleClass("selected")
}), $(".card-number").on("keydown", ".cc-num", function (e) {
  -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) || /65|67|86|88/.test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey) || 35 <= e.keyCode && e.keyCode <= 40 || (e.shiftKey || e.keyCode < 48 || 57 < e.keyCode) && (e.keyCode < 96 || 105 < e.keyCode) && e.preventDefault()
});







$(".namensschield_desc").on('keyup change', function (){ 
  
  if($(this).val()){
      $('.namensschield_active').prop('checked', true);
  }else {
      $('.namensschield_active').prop('checked', false);
  }
  
  calculatePrice();
});

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAP_KEY')); ?>&libraries=places&callback=initMap" async defer></script>

</body>
</html>