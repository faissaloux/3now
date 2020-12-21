@extends('website.app')

@section('styles')
<link href="{{asset('asset/front/css/slick.css')}}" rel="stylesheet">
<link href="{{asset('asset/front/css/slick-theme.css')}}"/>
<style type="text/css">


.book_now_wrap  .btn.btn-default.sid_tg {
    text-transform: uppercase;
    font-family: 'open_sansbold';
    font-size: 16px;
    color: #333333;
    background-color: #2bb673;
    border-color: #2bb673;
    border-radius: 0;
    width: 100%;
    text-align: left;
    height: 40px;
    line-height: 28px;
    position: relative;
}

.book_now_wrap figure {
   float: right;
}
.slick-prev{
   z-index: 0 !important;
}
.slick-next{
   z-index: 0 !important;
}
</style>
@endsection

@section('content')
<div class="get_there">
   <div class="banner">
    <div class="container">
      <h1 style="color: #32B0E9">Über uns</h1>
      <p style="font-size: 17px;line-height: 35px;">
        3Now ist ein deutsches Start-up, das Lieferservices über seine eigene Website und intelligente mobile Anwendungen anbietet. 
        <br>

        3Now bietet zusätzlich die Möglichkeit des Limousinen Services bzw. 

        <br>
        Flughafentransfers in Düsseldorf und Umgebung. 

        <br>
        Das Hauptziel ist die Zufriedenheit des Fahrgastes zum günstigsten Preis. 
        <br>
        Unser Service ist rund um die Uhr für Fahrgäste in Düsseldorf und dessen Umgebung verfügbar. 

        <br>
        Sicherheit, Zuverlässigkeit und Komfort stehen bei uns an erster Stelle.
      </p>
    </div>
   </div>
</div>




@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('asset/front/js/slick.min.js')}}"></script>
@endsection