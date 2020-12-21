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
      <h1 style="color: #32B0E9">Fragen und antworten</h1>

      <h3>Wie kann ich ein 3 Now-Konto erstellen?</h3>
      <p>Wir würden uns freuen, Sie an Bord zu haben! Führen Sie die folgenden einfachen Schritte aus, um ein Konto zu eröffnen:</p>
      <p>Alternativ über die App:</p>
      <p>Laden Sie die 3Now-Anwendung für Android und iOS aus Ihrem App Store herunter. Öffnen Sie die App und tippen Sie auf "Registrieren". Befolgen Sie die einfachen Anweisungen und Sie können 3Now verwenden!</p>

      <h3>Welche Informationen sind bei der Kontoregistrierung nötig?</h3>
      <p>Wenn Sie ein Konto bei 3 Now erstellen, erfassen wir die von Ihnen angegebenen Informationen wie Ihren Namen, Ihre E-Mail-Adresse, Ihre Telefonnummer, und Ihr Geburtsdatum. Sie können uns auch andere Einstellungen vornehmen.</p>

      <h3>Wie verwenden wir Ihre Daten?</h3>
      <p>Wir verwenden Ihre persönlichen Daten, um:</p>
      <p>Kundenunterstützung zu bieten, unsere Plattform zu verbessern und Sicherheit der 3 Now-Plattform und ihrer Benutzer zu gewährleisten.</p>

      <h3>Welche nützlichen Erfahrungen bietet Ihnen die 3 Now-Plattform?</h3>
      <p>Sie können:</p>
      <ul>
        <li>Ihre Identität überprüfen und Ihr Konto und Ihre Einstellungen pflegen</li>
        <li>Sich mit Ihren Fahrten verbinden und deren Fortschritt verfolgen.</li>
        <li>Zahlungen verarbeiten und Preise berechnen</li>
        <li>Zu Ihren Erfahrungen Feedback sammeln.</li>
      </ul>

      <h3>Wie kann ich meine Reservierungen sehen?</h3>
      <p>Über unsere App können Sie die aktiven 3 Now-Reservierungen schnell und einfach überprüfen.</p>

      <h3>Was kann ich tun, wenn ich mit dem Fahrer unzufrieden war?</h3>
      <p>Wenn Sie eine Reise beendet haben, können Sie sich mit uns in Verbindung setzen und erklären, was schief gelaufen ist. Geben Sie uns die Reisedetails an, damit wir überprüfen können, welchen Fahrer Sie hatten. Wir werden Ihren Fall untersuchen und uns bei Ihnen melden.</p>

      <h3>Was kann ich tun, wenn die App meinen Standort nicht richtig liest?</h3>
      <p>Wenn Sie Ihr 3 Now bestellen, können Sie Ihren Abholpunkt am zuverlässigsten eingeben, indem Sie entweder eine Adresse eingeben oder über den Ortsnamen suchen.</p>

      <h3>Was passiert, wenn ich am Abholpunkt nicht auftauche?</h3>
      <p>Wenn Ihr Fahrer am Abholpunkt ankommt und Sie dort nicht findet, wartet er 5 Minuten auf Sie. Er wird dann versuchen, Sie zu kontaktieren, aber wenn er keine weiteren Anweisungen von Ihnen erhalten hat, wird er gehen. In diesem Fall wird Ihnen der Mindestreisepreis berechnet. <br> Wenn Sie feststellen, dass Sie den Abholzeitpunkt nicht erreichen können, rufen Sie am besten den Fahrer an und sagen Sie ihm, wo Sie sich befinden, damit er Sie abholen kann. Ihr Standort wird zum neuen Abholpunkt. Beachten Sie, dass der Preis Ihrer Reise möglicherweise beeinflusst wird.</p>
    </div>
   </div>
</div>




@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('asset/front/js/slick.min.js')}}"></script>
@endsection