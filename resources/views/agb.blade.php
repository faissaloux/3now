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
      <h1 style="color: #32B0E9">AGB (Allgemeine Geschäftsbedingungen)</h1>
      <p>Diese Allgemeinen Geschäftsbedingungen enthalten Regeln und Bestimmungen, die eine rechtsverbindliche Vereinbarung zwischen Ihnen und 3 Now darstellen. Und Diese Allgemeinen Geschäftsbedingungen („Allgemeine Geschäftsbedingungen“) gelten für die Nutzung der 3 Now App und für Ihre Nutzung von Diensten, die von 3 Now bereitgestellt oder unterstützt werden. Diese Bestimmungen gelten für alle Länder und Städte, in denen 3 Now tätig ist. Nach dem Abschluss dieser Vereinbarung erkennen Sie ausdrücklich an, dass Sie diese Vereinbarung (einschließlich der Bestimmungen zur Beilegung von Streitigkeiten und zur Schlichtung) verstehen und alle ihre Bedingungen akzeptieren. Wenn Sie nicht damit einverstanden sind, an die Bedingungen dieser Vereinbarung gebunden zu sein, melden Sie bitte Ihr Profil ab und deinstallieren Sie die 3 Now-App.</p>

      <h3>1. ALLGEMEINES</h3>
      <p>In diesen Allgemeinen Geschäftsbedingungen:</p>
      <ul>
        <li>Alle Gebühren sind nicht erstattungsfähig (Keine Rückerstattung). Diese Richtlinie ohne Rückerstattung gilt jederzeit, unabhängig von Ihrer Entscheidung, die Nutzung der 3 Now-Plattform zu beenden, von Störungen der 3 Now-Plattform oder der Mitfahrgelegenheiten. Darüber hinaus werden die Gebühren durch einen Zahlungsprozessor eines Drittanbieters (z. B. Braintree, ein Geschäftsbereich von PayPal, Inc.) erleichtert. 3 Now kann seinen Drittanbieter-Zahlungsabwickler ohne vorherige Ankündigung ersetzen. Gebühren werden nur über die 3 Now-Plattform erhoben. Barzahlungen sind mit Ausnahme von Trinkgeldern strengstens untersagt. Ihre Zahlung von Gebühren an 3 Now erfüllt Ihre Zahlungsverpflichtung für die Nutzung der 3 Now-Plattform und der Mitfahrgelegenheiten. 3 Now kann mehrere Gebühren auf Ihrer Zahlungsmethode zu einer einzigen aggregierten Transaktion zusammenfassen, basierend auf dem Datum, an dem sie entstanden sind. Wenn Sie eine Transaktion nicht erkennen, überprüfen Sie Ihre Fahrbelege und den Zahlungsverlauf.</li>
        <li>Nach dem Hinzufügen einer neuen Zahlungsmethode oder jeder Fahranforderung kann 3 Now die Autorisierung Ihrer ausgewählten Zahlungsmethode einholen, um die Zahlungsmethode zu überprüfen, sicherzustellen, dass die Fahrkosten gedeckt werden, und um sich vor unbefugtem Verhalten zu schützen. Die Autorisierung ist keine Gebühr, kann jedoch Ihr verfügbares Guthaben bis zum nächsten Verarbeitungszyklus Ihrer Bank um den Autorisierungsbetrag reduzieren. Sollte der Betrag unserer Autorisierung den Gesamtbetrag der Einzahlung auf Ihr Konto überschreiten, kann es sein, dass die Bank, die Ihre Debit- oder Prepaid-Karte ausstellt, NSF-Gebühren überzieht. Wir können für diese Gebühren nicht verantwortlich gemacht werden und können Sie nicht bei der Einziehung dieser Gebühren von Ihrer ausstellenden Bank unterstützen. In unserer Hilfe erfahren Sie mehr über die Verwendung von Vorautorisierungsstopps.</li>
        <li>Möglicherweise erhalten Sie Gutscheine, die Sie nach Abschluss einer Fahrt für die Zahlung bestimmter Gebühren verwenden können. Gutscheine sind nur für die Verwendung auf der 3- Now-Plattform gültig und können nicht gegen Bargeld übertragen oder eingelöst werden, es sei denn, dies ist gesetzlich vorgeschrieben. Gutscheine können nicht kombiniert werden. Wenn die Kosten Ihrer Fahrt den geltenden Kredit- oder Rabattwert überschreiten, berechnen wir Ihre hinterlegte Zahlungsmethode für die ausstehenden Kosten der Fahrt. Für notierte oder variable Tarife kann 3 Now den Betrag abziehen, der der Servicegebühr, den Gebühren oder anderen Gebühren zuzurechnen ist, bevor der Gutschein angewendet wird. Zusätzliche Einschränkungen für Gutscheine können gelten, wie Ihnen in einer relevanten Aktion oder durch Klicken auf den entsprechenden Gutschein im Abschnitt "Aktionen" der 3 Now-App mitgeteilt.</li>
      </ul>

      <h3>2. DIE 3 NOW-PLATTFORM</h3>

      <ul>
        <li>Durch das Herunterladen der 3 Now App erklären Sie sich mit diesen Allgemeinen Geschäftsbedingungen einverstanden. Die 3 Now-Plattform bietet Ihnen einen Marktplatz, auf dem Personen, die einen Transport zu bestimmten Zielen suchen, mit Transportoptionen zu solchen Zielen abgeglichen werden können.</li>
        <li>Eine Möglichkeit für Fahrer besteht darin, eine Mitfahrgelegenheit von Mitfahrgelegenheitsfahrern anzufordern, die zu oder durch diese Ziele fahren. Als Benutzer autorisieren Sie 3 Now, Sie anhand von Faktoren wie Ihrem Standort, der voraussichtlichen Abholzeit, Ihrem Ziel, den Benutzereinstellungen und der Plattformeffizienz mit einem Fahrer abzugleichen und ein vorhandenes Match und einen erneuten Match basierend auf dem zu stornieren gleiche Überlegungen.</li>
        <li>Die Entscheidung des Benutzers zum Anbieten oder Annehmen liegt im alleinigen Ermessen dieses Benutzers. Jeder Mitfahrservice, den ein Fahrer einem Fahrer zur Verfügung stellt, ist eine separate Vereinbarung zwischen diesen Personen.</li>
      </ul>

      <h3>3. SICHERHEIT</h3>

      <ul>
        <li>3 Now stellt seinen Nutzern einen Onlinedienst zur Beilegung von Streitigkeiten zur Verfügung. Dieser Service ist unverbindlich. 3 Now ist nicht verpflichtet, Streitigkeiten beizulegen. Dieser Service wird nach alleinigem Ermessen von 3 Now angeboten und kann jederzeit zurückgezogen werden. Wenn eine Streitigkeit nicht beigelegt wird, behält sich 3 Now das Recht vor, vom Passagier gezahlte Beträge einzubehalten, bis eine einvernehmliche Vereinbarung zwischen dem Passagier und dem Fahrer getroffen wurde oder eine endgültige gerichtliche Entscheidung getroffen wurde.</li>
        <li>Alle Ansprüche zwischen Community-Fahrten müssen direkt unter den Community-Mitgliedern gerührt werden. Im Streitfall kann 3 Now versuchen, eine Einigung zwischen den Community-Mitgliedern zu erzielen, ist jedoch nicht für eine Lösung verantwortlich. Im Falle eines Rechtsstreits zwischen Community-Mitgliedern oder wenn ein Community-Mitglied von dem Missbrauch der 3 Now-App oder von einem Verhalten erfährt, das anderen Community-Mitgliedern abträglich ist, verpflichtet sich das Mitglied, 3 Now unverzüglich zu informieren.</li>
      </ul>

      <h3>4. ZAHLUNGEN</h3>

      <p>3 Now ist unverzüglich und schriftlich über alle Unstimmigkeiten bei der Bearbeitung der Spesenabrechnungen zu informieren. Werden innerhalb eines Monats nach Bearbeitung eines Spesenbeitrags keine Ansprüche geltend gemacht, gilt dies als vom Empfänger akzeptiert. Wenn ein Abzug fehlschlägt oder rückgängig gemacht wird, wird der Schuldner den fehlenden Betrag sofort ausgleichen. Wenn der Fehler auf Gründe zurückzuführen ist, auf die der Schuldner Einfluss hat (z. B. ist die hinterlegte Zahlungsmethode nicht mehr gültig oder nicht ausreichend gedeckt, wird eine Zahlung auf Anordnung des Schuldners usw. storniert), der Schuldner muss auch alle Schäden abdecken, die aufgrund des Ausfalls entstanden sind. Wenn die Auszahlung auf das hinterlegte Bankkonto fehlschlägt, benachrichtigt 3 Now das Community-Mitglied und bittet um Korrektur des hinterlegten Bankkontos. Der auszuzahlende Betrag wird zur nächsten regulären Auszahlung addiert und gleichzeitig mit der nächsten Auszahlung ausgezahlt.</p>
      <p>Um etwaige Auszahlungen von Spesenbeiträgen zu erhalten, müssen die Fahrer ein Konto bei unserem Zahlungsanbieter erstellen und ein funktionierendes persönliches Bankkonto erfassen. Passagiere müssen eine gültige Zahlungsmethode bei unserem Zahlungsanbieter über die 3 Now App registrieren.</p>
      <p>Alle elektronischen Zahlungen dürfen nur über das vom Zahlungsanbieter unterstützte 3 Now Wallet abgewickelt werden. 3 Now haftet nicht für Verzögerungen oder Probleme, die aufgrund des Zahlungsanbieters verursacht werden.</p>
      <p>Sobald eine Zahlung an einen Fahrer geleistet wurde, ist die Zahlung (einschließlich Abzug oder Verwaltungsgebühr) unabhängig von der Reise oder einer anderen verursachten Störung (einschließlich, aber nicht beschränkt auf Unfälle) nicht erstattungsfähig. Sobald ein Community-Mitglied einen Beitrag zu den Kosten des Fahrers leistet oder auf andere Weise eine Zahlung innerhalb der Community veranlasst, wird der Betrag der bei unserem Zahlungsanbieter hinterlegten Zahlungsmethode belastet.</p>
      <p>3 Now kann jedem Benutzer Werbeangebote anbieten. Diese Werbeangebote liegen im alleinigen Ermessen von 3 Now. Alle Sonderrabatte, Angebote und Prämienpunkte in Form von 3 Now Wallet-Geldern / gesammelten Punkten können im Falle einer verdächtigen Kontoaktivität oder einer böswilligen Absicht des Benutzers ohne vorherige Ankündigung widerrufen werden.</p>
      <p>Wenn eine Zahlung an 3 Now in Bezug auf eine stornierte Transaktion erfolgreich war, wird das Geld an die Benutzer zurückerstattet. 3 Now ist bestrebt, solche Zahlungen innerhalb von [90] Werktagen zu leisten, kann jedoch nicht für Verzögerungen haftbar gemacht werden, die außerhalb seiner Kontrolle liegen.</p>
      <p>Wenn Sie mit dem Auto anreisen, erklären Sie sich damit einverstanden, alle Steuern zu zahlen, die möglicherweise für die Zahlungen gelten, die Sie von Passagieren erhalten, und diese Verantwortung liegt ausschließlich bei Ihnen.</p>

      <h3>5. TEILNAHMEBERECHTIGUNG</h3>

      <p>Die 3 Now-Plattform darf nur von Personen genutzt werden, die das Recht und die Befugnis zum Abschluss dieser Vereinbarung haben und kompetent sind, die hierin enthaltenen Bedingungen und Pflichten zu erfüllen.</p>
      <p>Die 3 Now -Plattform steht Benutzern nicht zur Verfügung, deren Benutzerkonto vorübergehend oder dauerhaft deaktiviert wurde. Sie dürfen anderen Personen nicht erlauben, Ihr Benutzerkonto zu verwenden, und Sie stimmen zu, dass Sie der einzige autorisierte Benutzer Ihres Kontos sind. Um die 3 Now-Plattform nutzen zu können, muss jeder Benutzer ein Benutzerkonto erstellen. Jede Person darf nur ein Benutzerkonto erstellen, und 3 Now behält sich das Recht vor, zusätzliche oder doppelte Konten zu deaktivieren.</p>
      <p>Wenn Sie Benutzer werden, versichern Sie, dass Sie mindestens 18 Jahre alt sind. Ungeachtet des Vorstehenden können Sie als Elternteil oder Erziehungsberechtigter eines 16- oder 17-jährigen Minderjährigen ein 3 Now-Konto für diesen Minderjährigen erstellen, um die Plattform unter den folgenden Anforderungen und Einschränkungen zu nutzen:</p>
      <ol type="A">
        <li>Sie stellen sicher, dass Minderjährige die 3 Now-Plattform und das anwendbare Fahrrad nutzen.</li>
        <li>storstng_imrastore</li>
        <li>Sie stellen sicher, dass die Die Nutzung der 3 Now-Plattform durch Minderjährige beschränkt sich ausschließlich auf den Zugriff auf.</li>
        <li>Sie garantieren ausdrücklich, dass der Minderjährige die Bestimmungen dieser Vereinbarung akzeptiert. Sie sind verantwortlich für Verstöße gegen die oben genannten Zusicherungen, Garantien und / oder diese Vereinbarung und / oder für jeden Versuch des Minderjährigen, diese Vereinbarung nicht zu bestätigen. Darüber hinaus erklären Sie hiermit, dass Sie uneingeschränkt berechtigt sind, diese Vereinbarung im Namen von Ihnen und allen anderen Eltern oder Erziehungsberechtigten des minderjährigen Fahrers auszuführen.</li>
      </ol>
      <p>Durch die Einrichtung eines 3 Now-Kontos für einen solchen Minderjährigen erteilen Sie hiermit im Namen des Minderjährigen die Erlaubnis und Zustimmung zur Vereinbarung und übernehmen jegliche Verantwortung und Haftung für die Nutzung der 3 Now-Plattform durch den Minderjährigen gemäß den Bestimmungen dieser Vereinbarung und etwaige geltende Zusatzvereinbarungen.</p>

      <h3>6. 3 NOW COMMUNICATIONS</h3>

      <p>Durch die Nutzung der 3 Now-Plattform erklären Sie sich damit einverstanden, Mitteilungen von uns zu erhalten, einschließlich per E-Mail, SMS, Anrufen und Push-Benachrichtigungen. Sie stimmen zu, dass Anrufe, Texte oder aufgezeichnete Nachrichten von automatischen Telefonwahlsystemen generiert werden können. Für von uns gesendete Textnachrichten fallen Standardgebühren für Textnachrichten an, die von Ihrem Mobilfunkanbieter erhoben werden.</p>
      <p>Zu den Mitteilungen von 3 Now, seinen verbundenen Unternehmen und / oder Fahrern gehören unter anderem: Betriebsmitteilungen zu Ihrem Benutzerkonto oder zur Nutzung der 3 Now-Plattform oder der Mitfahrgelegenheiten, Aktualisierungen zu neuen und Bestehende Funktionen auf der 3 Now-Plattform, Mitteilungen zu Werbeaktionen, die von uns oder unseren Drittpartnern durchgeführt werden, sowie Neuigkeiten zu 3 Now- und Branchenentwicklungen.</p>

      <h3>7. GEMEINSCHAFTSFAHRTEN</h3>

      <p>Es wird kein Vertrag (z. B. Transportvertrag) zwischen Fahrern und Passagieren geschlossen. Die 3 Now Community und die App dürfen nicht missbraucht werden, um Verträge zwischen Community-Mitgliedern zu erleichtern. Eine vertraglich vereinbarte Fahrt ist keine Gemeinschaftsreise, auch wenn die App zur Erleichterung der Reise verwendet wird. Ansprüche gegen 3 Now, insbesondere für eine Rechnung oder die Erstattung von Gebühren, können nicht auf einem solchen Missbrauch beruhen.</p>
      <p>Now hat das Recht, eine Transaktion jederzeit nach eigenem Ermessen zu stornieren. Gründe für die Stornierung können ohne Einschränkung sein:</p>
      <ul>
        <li>3 Now findet einen Benutzer, der gegen diese Allgemeinen Geschäftsbedingungen verstößt.</li>
        <li>In der 3 Now App gibt es keine Interaktion zwischen Fahrer und Beifahrer.</li>
        <li>Fahrer und Passagiere haben eine Reise nicht bestätigt.</li>
      </ul>
      <p>Now bildet einen Vertrauenskreis und es ist wichtig, dass diese Vertrauensniveaus beibehalten werden. Als solches kann 3 Now nach eigenem Ermessen Benutzer aus irgendeinem Grund von der Plattform verbannen, einschließlich, aber nicht beschränkt auf potenzielle verdächtige Aktivitäten wie Geldwäsche, betrügerische Transaktionen über Kreditkarten usw. 3 Now behält sich das Recht vor, mit ihnen zusammenzuarbeiten und die örtlichen Strafverfolgungsbehörden in diesen Fällen zu melden. Nach Beendigung einer Reise trägt der Passagier über das in die 3 Now-App integrierte Zahlungssystem zu den Kosten des Fahrers bei. Die App enthält einen proprietären Algorithmus zur Kostenteilung, mit dem die Fahrtkosten berechnet und zwischen Fahrer und Passagier gerecht aufgeteilt werden können.</p>
      <p>Darüber hinaus behalten wir uns das Recht vor, für jede Fahrt eine Verwaltungsgebühr zu erheben. Die Höhe ist je nach Geografie von 3 Now zu bestimmen. Die Verwaltungsgebühr deckt die Kosten für Supportkosten, erbrachte Dienstleistungen und Technologie ab.</p>

      <h3>8. NUTZUNGSBEDINGUNGEN VON INHALTEN</h3>

      <p>Solange Sie in Übereinstimmung mit diesen Geschäftsbedingungen handeln, gewähren wir Ihnen eine widerrufliche, nicht exklusive Lizenz für die persönliche, nicht kommerzielle Nutzung der 3 Now App. Sie können keine Unterlizenzen erteilen und dürfen den Inhalt nicht ändern oder auf eine Weise verwenden, die in diesen Allgemeinen Geschäftsbedingungen und im Verhaltenskodex der Gemeinschaft nicht ausdrücklich gestattet ist.</p>
      <p>Wenn Sie Ihre eigenen Inhalte in die 3 Now-App im Allgemeinen einbringen, z. B. in Form von Bildern, Profilinformationen, Bewertungen und Kommentaren, bleiben diese Inhalte immer Ihr Eigentum. Indem Sie sie zur 3 Now Community beitragen, gewähren Sie uns eine unwiderrufliche, nicht ausschließliche, übertragbare, unterlizenzierbare Lizenz für Ihr geistiges Eigentum in dem Wissen, dass es als Teil der 3 Now Community verwendet, geändert, kopiert, veröffentlicht und verbreitet wird. Dies umfasst die Nutzung Ihres geistigen Eigentums für Werbezwecke sowie die Veröffentlichung außerhalb der Community, sofern eine ausreichend starke Verbindung zur 3 Now Community besteht.</p>
      <p>Die Mitglieder dürfen keine Inhalte beitragen, die andere Rechte an geistigem Eigentum verletzen, illegal, rassistisch, pornografisch beleidigend oder auf andere Weise für die 3 Now -Community unangemessen sind. Diese Art von Inhalten wird ohne Vorwarnung gelöscht und Sie stellen uns von allen direkten oder indirekten Verlusten, Schäden oder Kosten frei, die sich daraus ergeben.</p>

      <h3>9. HAFTUNG</h3>

      <p>Die 3 Now-App, die Website und die Plattform werden bereitgestellt, und alle Benutzer müssen ihre eigene Sorgfalt durchführen, bevor sie sich mit einem anderen Benutzer in Verbindung setzen. 3 Now ist lediglich ein Plattformanbieter und haftet nicht für das Verhalten, Schäden oder Verluste, die von Mitgliedern bei der Nutzung der 3 Now-App entstehen.</p>
      <p>3 Now lehnt Ungeachtet einer Bestimmung in diesen Allgemeinen Geschäftsbedingungen und auf andere Weise ausdrücklich jede ausdrückliche oder stillschweigende Garantie in Bezug auf die Plattform, jede auf der Plattform erleichterte Reise, Zuverlässigkeit, Vollständigkeit der Informationen und die Rechtmäßigkeit, das Qualifikationsniveau, die Angemessenheit oder das fahrerische Können ab eines beliebigen Benutzers.</p>
      <p>Wenn Ansprüche gegen 3 Now aufgrund des Verhaltens eines Mitglieds geltend gemacht werden, sollten alle Mitglieder zur Verteidigung gegen solche Ansprüche beitragen. Wenn das Verhalten auf die Handlungen eines Benutzers zurückzuführen ist, wird dieser Benutzer dies tun (ohne Einschränkung eines anderen Benutzers). Rechtsmittel, die 3Now möglicherweise zur Verfügung stehen, entschädigen 3 Now für Schäden, Verluste, Kosten oder Rechts- oder Transaktionsgebühren, die 3 Now oder seinen Nutzern entstehen.</p>
      <p>Das Mitglied erstattet alle Verluste, Schäden oder Kosten, die ihm oder seiner Handlung oder Untätigkeit zuzurechnen sind, wenn 3 Now aufgrund des fahrlässigen Verhaltens eines Mitglieds beschädigt wird.</p>

      <h3>10. DATENSCHUTZ</h3>

      <p>3 Now nimmt die Privatsphäre unserer Benutzer sehr ernst und hält sich an die geltenden Datenschutzgesetze. Weitere Informationen finden Sie in unseren Datenschutzbestimmungen.</p>

      <h3>11. KÜNDIGUNG</h3>

      <p>3 Now behält sich das Recht vor, die hier beschriebenen Leistungen zu ändern oder den Betrieb ganz oder teilweise einzustellen.</p>

      <h3>12. RECHTSWAHL, GERICHTSSTAND UND STREITBEHEBUNG</h3>

      <p>Diese Allgemeinen Geschäftsbedingungen unterliegen den Gesetzen Deutschlands, werden gemäß diesen ausgelegt und durchgesetzt, ohne Rücksicht auf Kollisionsnormen.</p>
      <p>Alle Kontroversen, Konflikte, Streitigkeiten oder sich aus diesen Allgemeinen Geschäftsbedingungen ergebenden Entscheidungen werden durch ein Schiedsverfahren in Deutschland. Das Gericht besteht aus Schiedsrichter, deren Entscheidung Bindung und endgültig ist.</p>

      <h3>13. KONTAKTIEREN SIE UNS</h3>

      <p>Wenn Sie Fragen oder Bedenken zu Ihrer Privatsphäre oder zu etwas in dieser Richtlinie haben, einschließlich wenn Sie in einem alternativen Format auf diese Richtlinie zugreifen müssen, empfehlen wir Ihnen, uns zu kontaktieren.</p>

      
    </div>
   </div>
</div>




@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('asset/front/js/slick.min.js')}}"></script>
@endsection