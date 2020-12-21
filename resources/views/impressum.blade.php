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
      <h1 style="color: #32B0E9">impressum</h1>
      
<table border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
   <tbody>
      
      
      <tr>
         
         <td width="318" valign="top" style="width:238.65pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">
            <p class="MsoNormal"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt;background:white">Mo`s Fahrdienst Düsseldorf GmbH<u></u><u></u></span></p>
            <p class="MsoNormal"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt;background:white">Königsberger Str. 240<u></u><u></u></span></p>
            <p class="MsoNormal"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt;background:white">40231 Düsseldorf<u></u><u></u></span></p>
            <p class="MsoNormal"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt;background:white">vertr. d.d. GF: M.S. Alhawash<u></u><u></u></span></p>
            <p class="MsoNormal"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt;background:white">HRB 89141</span><u></u><u></u></p>
         </td>
      </tr>
      <tr>
         
         <td width="318" valign="top" style="width:238.65pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">
            <p class="MsoNormal"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt;background:white">Zulassung</span><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;letter-spacing:.1pt;background:white">s<span style="color:black">behörde: Düsseldorf</span></span><u></u><u></u></p>
         </td>
      </tr>
      <tr>
         
         <td width="318" valign="top" style="width:238.65pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">
            <p class="MsoNormal"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt;background:white">Telefon: &nbsp;&nbsp;+49 211 69587089</span><u></u><u></u></p>
         </td>
      </tr>
      <tr style="height:25.45pt">
         
         <td width="318" valign="top" style="width:238.65pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:25.45pt">
            <p style="margin-right:0cm;margin-bottom:7.5pt;margin-left:0cm;line-height:26.25pt"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt">Email: &nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:info@3now.de" target="_blank">info@3now.de</a><u></u><u></u></span></p>
         </td>
      </tr>
      <tr>
         
         <td width="318" valign="top" style="width:238.65pt;border:none;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">
            <p class="MsoNormal"><span style="font-size:13.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black;letter-spacing:.1pt;background:white">USt-IdNr.: DE331786821</span><u></u><u></u></p>
         </td>
      </tr>
      
   </tbody>
</table>

    </div>
   </div>
</div>




@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('asset/front/js/slick.min.js')}}"></script>
@endsection