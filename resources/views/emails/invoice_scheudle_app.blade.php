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








