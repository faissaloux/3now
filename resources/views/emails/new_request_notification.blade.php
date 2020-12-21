<div style='display:none;'>
	<p>Please see the request details</p>
<br />
<br />
<p><strong>Request ID : {{ $data['booking_id']  }}</strong></p>
<br />
<br />
<br />
<p>User Details</p>
<br />
<p>User Name : {{ $data['username'] }}</p>
<p>User Mobile No. : {{ $data['usermobile'] }}</p>
<p>Payment Mode : {{ $data['payment_mode'] }}</p>
<br />
<br />
<br />
<p>Driver Details</p>
<br />
<p>Driver Name : {{ $data['drivername'] }}</p>
<p>Mobile No. : {{ $data['drivermobile'] }}</p>

</div



<!DOCTYPE html>
<html>
<head>
	<style>
		.center {
margin: auto;
width: 60%;
font-family: 'Tajawal';
}

.nav_header{
background: #3EBAED;
height: auto;
border-radius: 0px 0px 170px 0px;
padding: 40px 60px;
color: white;
margin-bottom: 50px;
}

.logo {
margin-top: 20px
}

.line{
	border-color: #F7F7F7;
}

.tableInfo{
	width: 90%;
}

.price{
	text-align: right;
}

.pick{
	text-align: left;
	font-weight: 900;
}

p.para {
    background: #F7F7F7;
    padding: 20px 21.28px;
    margin-bottom: 21.28px;
    border-radius: 10px;
    color: #888888;
}


.container{
	margin: auto;
    width: 65%;
}

.tableInfo {
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 21.28px;
}

a.totalPrice {
    background: #3EBAED;
    text-decoration: none;
    color: white;
    padding: 15px 50px;
    border-radius: 10px;
    font-size: 40px;
}

table.tableInfo.tablePrice {
    margin-bottom: 21.28px;
    margin-top: 21.28px;
}

i.fa.fa-briefcase {
    margin-left: 15px;
}

.totalPriced {
    margin-bottom: 50px;
    text-align: center;
}

.important h3 {
    color: red;
}

table.tableInfo.payPal {
    margin-bottom: 40px;
}

i.fa {
    margin-right: 5px;
}
i.fas {
    margin-right: 5px;
}

.siteInfo {
	margin-top: 15px;
}
.siteInfo a {
    text-decoration: none;
    color: #6589BA;
}

.about {
	text-align: center;
	margin: 50px;
}
.about a{
	color: #888888;
	margin: 20px
}

a.tele {
    color: #888888;
}

a.tele {
    color: #888888;
}

a.adresse {
    color: #6589BA;
}

.tablePrice td {
    font-weight: 600;
}

.finghadi {
    display: -webkit-box;
}
img.imgFinghadi {
    width: 6px;
    margin-top: -40px;
}

.CarInfo {
    margin-bottom: 21.28px;
}

@media (max-width: 700px) and (min-width: 0px) {

body.center {
    width: 100%;
    overflow-x: hidden;
}

.container {
    width: 90%;
}

table.tableInfo {
    margin-left: 10px;
    width: 90% !important;
}

.nav_header {
    text-align: center;
}
}

@media (max-width: 1200px) and (min-width: 700px) {

body.center {
    width: 75%;
    overflow-x: hidden;
}

table.tableInfo {
    width: 90% !important;
}

.nav_header {
    text-align: center;
}
}

@media (max-width: 1500px) and (min-width: 1200px) {

body.center {
    width: 75%;
    overflow-x: hidden;
}

table.tableInfo {
    width: 90% !important;
}

.nav_header {
    text-align: center;
}
}
	</style>
	<script src="https://kit.fontawesome.com/3b9ce42c66.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Tajawal&display=swap">
</head>
<body class="center">

<div class="nav_header">
	<img class="logo" src="img/HGNiYTA.png" alt="">
	<h4>Buchungsbestätigung</h4>
</div>

<div class="container">
	<div class="DriverInfo">
	<h2>Lieber 3Now-Kunde,</h2>
	<p>vielen Dank fur Deine Bunchung</p>
	<p>Deine Buchung (#156165151)</p>
	</div>

	<hr class="line">

	<div class="CarInfo">
		<h2>Mercedes C-Klasse</h2>
		<tr>
			<td class="nbrPlaces"><i class="fa fa-user" aria-hidden="true"></i> 4</td>
		</tr>
		<tr>
			<td class="nbrBags"><i class="fa fa-briefcase" aria-hidden="true"></i> 3</td>
		</tr>
	</div>

	<hr class="line">

	<div>
		<h4>Routenplaner</h4>
		<div class="finghadi">
			
		<table class="tableInfo">
			<tr>
				<td rowspan="7"><img class="imgFinghadi" src="img/hadik.png" alt=""></td>
			</tr>
			<tr>
				<th colspan="2" class="pick">ABHOLORT - Gerlingstr,43 Essen</th>
				<td rowspan="6" class="price">5,00$</td>
			</tr>
			<tr>
				<td colspan="2">ABHOLORT, 43 Essen</td>
			</tr>
			<tr>
				<td>15.01.2020</td>
				<td>12:00 Uhr</td>
			</tr>
			<tr>
			<th colspan="2"  class="pick">ABHOLORT - Gerlingstr,43 Essen</th>
			</tr>
			<tr>
				<td colspan="2">ABHOLORT, 43 Essen</td>
			</tr>
			<tr>
				<td>15.01.2020</td>
				<td>12:00 Uhr</td>
			</tr>
		</table>
		</div>
	</div>

	<hr class="line">

	<div class="">
		<h4>Zusätzliche Wunsche</h4>
		<table class="tableInfo">
			<tr>
				<td><i class="fas fa-chair"></i>Kindersitz</td>
				<td class="price">5,00$</td>
			</tr>
			<tr>
				<td><i class='fas fa-baby-carriage'></i>Babyschale</td>
				<td class="price">10,00$</td>
			</tr>
			<tr>
				<td><i class="fa fa-id-card" aria-hidden="true"></i>Namenscheild</td>
				<td class="price">15,00$</td>
			</tr>
		</table>
	</div>

	<hr class="line">

	<div class="notes">
		<h4>bemerkungen</h4>
		<p class="para">hadik a 7amiiiiiiiiiiiiid</p>
	</div>

	<hr class="line">

	<div class="">
		<table class="tableInfo tablePrice">
			<tr>
				<td>Gesamt</td>
				<td class="price">85,00$</td>
			</tr>
			<tr>
				<td>19% MwSt</td>
				<td class="price">10,00$</td>
			</tr>
			<tr>
				<td>Netto</td>
				<td class="price">15,00$</td>
			</tr>
		</table>
	</div>

	<hr class="line">

	<table class="tableInfo payPal">
		<tr>
			<td><i class="fa fa-money" aria-hidden="true"></i>
Zahlungsmethode</td>
			<td class="price">payPal</td>
		</tr>
	</table>

	<div class="totalPriced"><a href="#" class="totalPrice">185,00$</a></div>

	<hr class="line">

	<div class="important">
		<h3>Wichtig</h3>
		<p class="para">Bei Einer Flughafentransfer buchung , bitten wir dich sobald der Flug beendest ist , das du dein Mobiltelefon anschaltst , damit dich der Fahrer mit dir in Verbindung setz.</p>
	</div>

	<div class="siteInfo">
		<table width="100%">
			<td>
				<a class="adresse" href="#">Königsberger Str.240 <br> 40231 Düsseldorf</a>
			</td>
			<td style="text-align: right;">
				<a class="tele" href="#">tel. +49 000 000 000 00 <br> fax. +49 000 000 000 00</a>
			</td>
		</table>
		
	</div>

	<div class="siteInfo">
		<a href="#">info@3now.de <br> www.3now.de</a>
	</div>

	<div class="about">
		<a href="#">Über uns</a>
		<a href="#">Impresseum</a>
	</div>
</div>


</body>
</html>