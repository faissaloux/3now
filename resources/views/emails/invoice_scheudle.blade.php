<html><head></head><body>
<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">

 <tbody>
    <tr>
    
    <td style="background: rgb(62,186,236);
  background: linear-gradient(148deg, rgba(62,186,236,1) 49%, rgba(78,142,214,1) 100%);
    height: auto;
    border-radius: 0px 0px 170px 0px;
    padding: 40px 60px;
    color: white;
    margin-bottom: 50px;">
      <img class="logo" src="https://www.3now.de/public/email/logo.png" />
    <h4>Buchungsbestätigung</h4>
    </td>
    </tr>
   <tr>
  
     <td style='padding-top: 45px;'>
       
  <h2>Lieber 3Now-Kunde,</h2>
  <p>vielen Dank fur Deine Bunchung. </p>
  <p>Buchungsnummer  (# {{ $user['invoice_id'] }} )</p>

     </td>
 
   </tr>
   <tr>
      <td>
        <hr>
     </td>
   </tr>
   
   
  <tr>
     <td>
        <h2>  Mercedes Vito </h2>


        <img style="width:25px;" src="https://i.imgur.com/2BABuTc.png" alt="">  8
        <img style='width:25px;margin-left:10px; ' src="https://i.imgur.com/zknSGgk.png" alt=""> 6 Max
     </td>
   </tr>

    <tr>
      <td>
        <hr>
     </td>
   </tr>

 </tbody>
</table>




<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">


  <tbody>

  <tr>
     <td>
        <h4>Routenplaner</h4>

     </td>
   </tr>
 </tbody></table>



<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
      <tbody>
        <tr>

        <td rowspan="7"><img style="width: 6px;margin-top: -40px;" class="imgFinghadi" src="https://www.3now.de/public/email/img/hadik.png" alt=""></td>
      </tr>
      <tr>
        <td colspan="2"  style='text-align: left;' class="pick">ABHOLORT </td>
      </tr>
      <tr>
        <td>
          <b style='font-size: 18px;font-weight: bold;'>{{ $user['s_address'] }}</b>
        </td>
      </tr>
      
      <tr>
      <td colspan="2" style='text-align: left;'  class="pick">ZIELORT </td>
      </tr>
      <tr>
        <td colspan="2"><b style='font-size: 18px;font-weight: bold;' >{{ $user['d_address'] }}</b></td>
      </tr>


  <tr>
        <td>    {{  $full_order->schedule_at }}    </td>
      </tr>
    </tbody>
  </table>












<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">

  <tr>
     <td>
        <hr>
     </td>
   </tr>
 </tbody></table>




@php
  if($full_order->status == 'SCHEDULED' ):
@endphp



<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">


  <tbody>

  <tr>
     <td>
        <h4>Zusätzliche Wunsche</h4>

     </td>
   </tr>
 </tbody></table>



<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
      <tbody><tr>
        <td>  <img style="width:25px;"  src="https://www.3now.de/public/email/chair-solid.png" alt=""> Kindersitz ({{ $full_order->kindersitz }}) </td>
        <td class="price" style="text-align: right;">{{ $full_order->Kindersitz_cash() }}€</td>
      </tr>
      <tr>
        <td><img style="width:25px;"  src="https://www.3now.de/public/email/baby-carriage-solid.png" alt="">Babyschale   ({{ $full_order->babyschale }}) </td>
        <td class="price" style="text-align: right;">{{ $full_order->Babyschale_cash() }}€</td>
      </tr>
      <tr>
        <td><img style="width:25px;"  src="https://www.3now.de/public/email/briefcase-solid.png" alt="">Namenscheild  </td>
        <td class="price" style="text-align: right;">{{ $full_order->Namenscheild_cash() }}€</td>
      </tr>
    </tbody>
  </table>


@php
  endif;
@endphp




@php
  if(!is_null( $full_order->note )):
@endphp
<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">

  <tbody>

  <tr>
     <td>
        <hr>
     </td>
   </tr>
 </tbody></table>


<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
  <tbody>
    <tr>
      <td><h4>bemerkungen</h4></td>
    </tr>
      <tr>
      <td><p style="background: #F7F7F7;
    padding: 20px 21.28px;
    margin-bottom: 21.28px;
    border-radius: 10px;
    color: #888888;" class="para">{{ $full_order->note }}</p></td>
    </tr>
  </tbody>
</table>



<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">


  <tbody>

  <tr>
     <td>
        <hr>
     </td>
   </tr>
 </tbody></table>

@php
  endif;
@endphp






<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
  <tbody>
    <tr>
        <td><b>Gesamt</b> </td>
        <td class="price" style="text-align: right;">   <b> {{ $user['total_fee'] }} €  </b> </td>
      </tr>
      <tr>
        <td><b>ink. 16% MwSt</b></td>
      </tr>
    
    </tbody>
</table>

<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
  <tbody>

  <tr>
     <td>
        <hr>
     </td>
   </tr>
 </tbody></table>

 <table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
   <tbody>
         <tr>
      <td>   <img src="https://i.imgur.com/eO4SVl6.png" style="width:25px;"  alt="">      Zahlungsmethode</td>
      <td class="price" style="text-align: right;">{{ $full_order->payment_mode }}</td>
    </tr>
    <tr style="text-align:center;">
      <td style="
    padding: 30px 0;
    text-align: center;
    width: 100% !important;
    " colspan="2">
        <a href="#" style="    background: #3EBAED;
    text-decoration: none;
    color: white;
    padding: 15px 50px;
    border-radius: 10px;
    font-size: 40px;" class="totalPrice">{{ $user['total_fee'] }} €</a>
      </td>
    </tr>
   </tbody>
 </table>

 
 <table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
  <tbody>
  <tr>
     <td>
        <hr>
     </td>
   </tr>
 </tbody>
</table>







@php
  if($full_order->status == 'SCHEDULED' ):
@endphp
<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
  <tbody>
    <tr>
      <td><h3 style='color: red; margin-bottom:15px; '>Wichtig</h3></td>
    </tr>
     <tr>
      <td style="background: #F7F7F7;
    padding: 20px 21.28px;
    margin-bottom: 21.28px;
    border-radius: 10px;
    color: #888888;">Bei einer Flughafentransferbuchung, bitten wir Dich sobald der Flug Beendet ist, dass Du Dein Mobiltelefon anschaltest, damit sich der Fahrer mit Dir in Verbindung setzten kann.</td>
    </tr>
  </tbody>
</table>



@php
  endif;
@endphp



  

<table  dir="ltr" style="disblay:block; max-width:790px; min-width: 790px !important; margin:0 auto;">
  <tbody>





    <tr>
      <td style="text-align: left;">
    <a href="https://www.3now.de/page/datenschutz" style="color: #888888;">Datenschutz</a>
      </td>
      <td style="text-align: center;">
            <a href="https://www.3now.de/page/agb" style="color: #888888;">AGB</a>
      </td>
        <td style="text-align: right;">
            <a href="https://www.3now.de/page/impressum" style="color: #888888;">impressum</a>
      </td>
    </tr>
    </tbody>
</table></body></html>