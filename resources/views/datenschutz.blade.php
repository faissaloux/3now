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
      <h1 style="color: #32B0E9">DATENSCHUTZ</h1>
      <p>Sie werden im Folgenden darüber informiert, welche personenbezogenen Daten 3 Now verarbeitet und zu welchen Zwecken dies geschieht. Wir informieren Sie außerdem über weitere datenschutzrechtlich wichtige Einzelheiten.</p>
      
      <h3>1. ALLGEMEINES</h3>
      <ul>
        <li>Unser Unternehmen 3 Now nimmt den Schutz Ihrer Daten sehr ernst. Unsere Datenschutzrichtlinie Richtlinie gilt für alle 3 Now Benutzer, einschließlich die Fahrer sowie für alle 3 Now-Plattformen und -Dienste, einschließlich unserer Apps, Websites, Funktionen und anderen Dienste Bitte beachten Sie, dass Ihre Nutzung der 3 Now-Plattform auch unseren Nutzungsbedingungen unterliegt.</li>
        <li>Durch die Verwendung der von uns angebotenen Dienste oder dieser Website stimmen Sie der Offenlegung, Verwendung und Erfassung dieser Informationen über Sie gemäß dieser Datenschutzrichtlinie zu und erklären sich damit einverstanden, an diese gebunden zu sein.</li>
      </ul>

      <h3>2. SAMMELN VON INFORMATIONEN</h3>
      <p>Bestimmte Informationen, die erforderlich sind, um sich auf der Website zu registrieren oder auf andere von uns bereitgestellte Dienste zuzugreifen, einschließlich Ihres Namens, Ihrer Adresse, Ihres Geburtsdatums und wenn Sie Fahrer sind, bestimmter Informationen über Ihr Fahrzeug usw, und somit können wir die folgenden persönlichen Informationen oder Daten über Sie sammeln und verarbeiten:</p>
      <ul>
        <li>Ihre E-Mail-Adresse und ein Passwort. <br> Eine Aufzeichnung aller Buchungen oder Reisen, die Sie mit oder über die Website getätigt haben.</li>
        <li>Eine Mobiltelefonnummer.</li>
        <li>Ihre Antworten auf Umfragen oder Fragebögen, die wir möglicherweise für Forschungszwecke verwenden.</li>
        <li>Einzelheiten zu Buchhaltungs- oder Finanztransaktionen, einschließlich Transaktionen, die über die Website oder auf andere Weise ausgeführt werden. Dies kann Informationen wie Ihre Kreditkarte, Debitkarte oder Bankkontodaten, Details zu Reisen (wie in unseren Bedingungen beschrieben) enthalten, die Sie über die Website gebucht oder angeboten haben.</li>
        <li>Details Ihrer Besuche auf der Website und der Ressourcen, auf die Sie zugreifen.</li>
        <p>Informationen werden auch gesammelt, ohne dass Sie sie aktiv bereitstellen. Dabei werden verschiedene Technologien und Methoden wie IP-Adressen (Internet Protocol) und Cookies verwendet. Diese Methoden sammeln oder speichern keine persönlichen Informationen.</p>
        <p>Wir verwenden Ihre IP-Adresse, um Probleme mit unserem Server zu diagnostizieren, aggregierte Informationen zu melden und den schnellsten Weg für Ihren Computer zu ermitteln, um eine Verbindung zu unserer Site herzustellen und die Site zu verwalten und zu verbessern.</p>
        <p>Wir erfassen solche Informationen nur, wenn Sie sie uns zur Verfügung stellen. Sie müssen uns keine persönlichen Daten zur Verfügung stellen, können jedoch möglicherweise nicht alle von uns angebotenen Dienstleistungen in Anspruch nehmen, ohne dies zu tun.</p>
      </ul>

      <h3>3. VERWENDEN</h3>
      <p>Wir können diese Informationen verwenden, um:</p>
      <ul>
        <li>Sie an Funktionen der Website und anderen Diensten teilnehmen zu können.</li>
        <li>Unterstützung bei allgemeinen Verbesserungen der Website zu erhalten.</li>
        <li>sicherzustellen, dass der Inhalt der Website für Sie und Ihren Computer auf die effektivste Weise dargestellt wird, und die Website an Ihre Vorlieben anpassen.</li>
        <li>Verpflichtungen zu verwalten, die sich aus Vereinbarungen ergeben, die zwischen Ihnen und uns geschlossen wurden.</li>
        <li>zu analysieren, wie Benutzer die Website nutzen und für interne Marketing- und Forschungszwecke.</li>
        <li>Zahlungen von Ihnen einzuziehen;</li>
      </ul>
      <p>Wir werden Ihre Daten weder für Marketingzwecke Dritter verwenden noch an Dritte weiterverkaufen.</p>

      <h3>4. KORREKTUR VON PERSÖNLICHEN INFORMATIONEN</h3>
      <p>Wir ergreifen alle geeigneten Maßnahmen, um Ihre personenbezogenen Daten zu schützen, während Sie Ihre Daten von Ihrem Computer auf unsere Website übertragen,
      und um diese Informationen vor Verlust, Missbrauch und unbefugtem Zugriff,
      Offenlegung, Änderung oder Zerstörung zu schützen. Wir verwenden führende
      Technologien und Verschlüsselungssoftware, um Ihre Daten zu schützen, und wenden
      strenge Sicherheitsstandards an, um unbefugten Zugriff darauf zu verhindern. Deshalb
      werden wir alle angemessenen Schritte im Einklang mit unseren gesetzlichen
      Verpflichtungen unternehmen, um personenbezogene Daten in unserem Besitz, die Sie
      über diese Website übermitteln, zu aktualisieren oder zu korrigieren.</p>
      <p>Wenn Sie auf dieser Website Kennwörter, Benutzernamen oder andere spezielle
      Zugriffsfunktionen verwenden, sind Sie auch dafür verantwortlich, angemessene
      Maßnahmen zu deren Schutz zu ergreifen.</p>
      <p>Sie haben das Recht, auf Informationen zuzugreifen, die über Sie gespeichert sind. Ihr
      Zugangsrecht kann gemäß den örtlichen Gesetzen ausgeübt werden. Wenn Sie Details
      zu persönlichen Informationen sehen möchten, die wir über Sie gespeichert haben,
      kontaktieren Sie uns bitte über unsere Kontaktseite.</p>

      <h3>5. ZAHLUNGEN UND TEILEN VON INFOS.</h3>
      <p>Damit Zahlungen verarbeitet werden können, müssen Sie unserem Zahlungsabwickler möglicherweise einige erforderliche Details mitteilen. Wir werden Sie an dem Punkt darüber informieren, an dem wir diese Informationen sammeln.</p>
      <p>Wenn wir Ihnen Gebühren in Rechnung stellen oder Geld von Ihnen im Zusammenhang mit Dienstleistungen auf der Website einziehen, werden Kredit- oder Debitkartenzahlungen von unserem Zahlungsabwickler eingezogen.</p>
      <p>Wir geben keine Informationen, die Sie über die Website bereitstellen, an Dritte weiter, außer:</p>
      <ul>
        <li>Wenn wir verpflichtet sind, Ihre personenbezogenen Daten offen zu legen oder weiterzugeben, um einer gesetzlichen Verpflichtung nachzukommen.</li>
        <li>zur Erbringung unserer Dienstleistungen können Informationen an einen Passagier oder an einen Fahrer weitergegeben werden.</li>
      </ul>
      <p>Wir können Informationen mit unseren internationalen Partner-Websites teilen, wenn
      Sie eine Buchung über die Website mit einem Benutzer unserer Partner-Websites
      vorgenommen haben oder wenn Sie die Website zur Interaktion mit Dritten verwendet
      haben.</p>
      <p>um Nutzungsbedingungen durchzusetzen, die für eine der Websites gelten, oder um
      andere Bedingungen oder Vereinbarungen für unsere Dienste durchzusetzen, die
      möglicherweise gelten;</p>
      <p>Wir können Ihre persönlichen Daten im Rahmen eines Verkaufs einiger oder aller
      unserer Geschäfte und Vermögenswerte an Dritte oder im Rahmen einer
      Umstrukturierung oder Reorganisation eines Dritten an Dritte übertragen. Wir werden
      jedoch vor einer solchen Übertragung die Zustimmung einholen.</p>
      <p>zum Schutz der Rechte, des Eigentums oder der Sicherheit von 3 Now, den Benutzern
      der Website oder anderen Dritten. Dies umfasst den Informationsaustausch mit
      anderen Unternehmen und Organisationen zum Zwecke des Betrugsschutzes und der
      Reduzierung des Kreditrisikos.</p>
      <p>Wir geben keine Ihrer persönlichen Daten weiter, anders als ober angegeben, es sei
      denn, dass Sie uns die Erlaubnis gewähren.</p>

      <h3>6. ANDERE WEBSITES, TRACKING UND COOKIES VON DRITTANBIETERN</h3>
      <p>Wir können nicht für die Datenschutzrichtlinien von Websites verantwortlich gemacht
      werden, die nicht von uns betrieben werden, selbst wenn Sie über die Website darauf
      zugreifen. Wir empfehlen Ihnen, die Richtlinien jeder von Ihnen besuchten Website zu
      überprüfen und sich bei Bedenken oder Fragen an deren Eigentümer oder Betreiber zu
      wenden.</p>
      <p>Diese Website enthält Links und Verweise auf andere Websites. Bitte beachten Sie, dass
      diese Datenschutzrichtlinie nicht für diese Websites gilt.</p>
      <p>Wenn Sie über eine Website eines Drittanbieters auf diese Website gelangt sind, können
      wir nicht für die Datenschutzrichtlinien der Eigentümer oder Betreiber dieser Website
      eines Drittanbieters verantwortlich sein und empfehlen Ihnen, die Richtlinien dieser
      Website eines Drittanbieters zu überprüfen und Kontakt aufzunehmen sein Eigentümer
      oder Betreiber, wenn Sie irgendwelche Bedenken oder Fragen haben.</p>

      <h3>7. EXPORT VON DATEN</h3>
      <p>Wir können Informationen mit anderen gleichwertigen nationalen Stellen teilen, die sich
      möglicherweise in Ländern weltweit befinden. Wenn wir Ihre Daten außerhalb
      Deutschlands oder anderer Länder übertragen, werden wir Maßnahmen ergreifen, um
      sicherzustellen, dass Ihre Datenschutzrechte weiterhin wie in dieser
      Datenschutzrichtlinie beschrieben und in Übereinstimmung mit den geltenden Gesetzen
      geschützt bleiben.</p>
      <p>Durch die Übermittlung Ihrer persönlichen Daten an uns stimmen Sie der Übertragung,
      Speicherung oder Verarbeitung Ihrer Daten außerhalb Deutschlands auf die oben
      beschriebene Weise zu.</p>
      <p>Wenn Sie die Website außerhalb Deutschlands nutzen, werden Ihre Daten
      möglicherweise außerhalb Deutschlands gespeichert, um Ihnen diese Dienste zur
      Verfügung zu stellen.</p>

      <h3>8. COOKIES, ANALYSEN UND TECHNOLOGIEN VON DRITTANBIETERN.</h3>
      <p>Wir sammeln Informationen mithilfe von „Cookies“, Tracking-Pixeln, Datenanalysetools
      wie Google Analytics, SDKs und anderen Technologien von Drittanbietern, um zu
      verstehen, wie Sie durch die 3 Now-Plattform navigieren und mit Werbung interagieren,
      um Ihre 3 Now-Erfahrung sicherer zu machen. Erfahren Sie, welche Inhalte beliebt sind,
      verbessern Sie Ihre Website-Erfahrung, schalten Sie bessere Anzeigen auf anderen
      Websites und speichern Sie Ihre Einstellungen.</p>
      <p>Cookies sind kleine Textdateien, die Webserver auf Ihrem Gerät ablegen. Sie dienen
      dazu, grundlegende Informationen zu speichern und Websites und Apps dabei zu helfen,
      Ihren Browser zu erkennen. Wir können sowohl Sitzungscookies als auch dauerhafte
      Cookies verwenden. Ein Sitzungscookie verschwindet, nachdem Sie Ihren Browser
      geschlossen haben. Ein dauerhaftes Cookie bleibt nach dem Schließen Ihres Browsers
      erhalten und kann bei jeder Verwendung der 3 Now-Plattform aufgerufen werden. Sie
      sollten Ihre Webbrowser konsultieren, um Ihre Cookie-Einstellungen zu ändern. Bitte
      beachten Sie, dass Sie bestimmte Funktionen der 3 Now-Plattform möglicherweise
      verpassen, wenn Sie Cookies von uns löschen oder nicht akzeptieren.</p>

      <h3>9. MITTEILUNG VON ÄNDERUNGEN AN UNSERER DATENSCHUTZRICHTLINIE</h3>
      <p>Wir können diese Richtlinie von Zeit zu Zeit aktualisieren, wenn sich die 3 Now-Plattform
      ändert und sich das Datenschutzgesetz weiterentwickelt. Wenn wir es aktualisieren, werden
      wir dies online tun, und wenn wir wesentliche Änderungen vornehmen, werden wir Sie über
      die 3 Now-Plattform oder über eine andere Kommunikationsmethode wie E-Mail informieren.
      Wenn Sie 3 Now verwenden, stimmen Sie den neuesten Bestimmungen dieser Richtlinie zu.</p>

      <h3>10. KONTAKT</h3>
      <p>Wenn Sie mit Fragen zu Ihren persönlichen Daten oder uns zu irgendeinem Zeitpunkt mit Ihren
      Ansichten zu unseren Datenschutzerklärungen (Löschung, Überprüfung, Aktualisierung,)
      kontaktieren möchten, können Sie dies tun, indem Sie an support schreiben.</p>
    </div>
   </div>
</div>




@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('asset/front/js/slick.min.js')}}"></script>
@endsection