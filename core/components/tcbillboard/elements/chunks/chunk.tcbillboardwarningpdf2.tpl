<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 10.5pt; }
        table { width: 100% }
        .color-red { color: #800000; }
        .account { width: 50%; }
        .account tr td { padding: 0 }
    </style>
</head>
<body>

<table>
    <tr>
        <td width="50%" style="text-align: left;"><img src="/assets/components/tcbillboard/examples/img/logo.png" /></td>
        <td width="50%"></td>
    </tr>
</table>

<div style="margin-top:30pt; font-size: 9pt;"><u>Werbeagentur Lotz – Kleiststr. 2 – 42799 Leichlingen</u></div>
<br />

<table>
    <tr>
        <td width="25%" valign="top">
            <p class="color-red">[[+fullname]]</p>
            <p class="color-red">[[+anrede]] [[+vorname]] [[+nachname]]</p>
            <p class="color-red">[[+address]]</p>
            <p class="color-red">[[+zip]] [[+city]]</p>
        </td>
        <td width="40%"></td>
        <td width="35%" valign="top">
            <p>Werbeagentur Lotz</p>
            <p>Inh. Alexander Lotz</p>
            <p>Kleiststr. 2</p>
            <p>42799 Leichlingen</p>
            <p>Tel.: +49 176 47519730</p>
            <p>E-Mail: info@saisonverkauf.info</p>
            <p>Internet: saisonverkauf.info</p>
        </td>
    </tr>
</table>

<table>
    <tr>
        <td width="25%">
            <h3>2. Mahnung</h3>
        </td>
        <td width="50%"></td>
        <td width="25%" valign="top">Datum: [[+date]]</td>
    </tr>
    <tr></tr>
</table>
<br />

<table style="padding-bottom: 10pt;">
    <tr>
        <td>
            <h4>Rechnung Nr. <span class="color-red">[[+num]]</span></h4>
            <h4>Rechnungsdatum: <span class="color-red">[[+createdon]]</span></h4>
            <h4>Rechnungsbetrag: <span class="color-red">[[+sum]]€</span></h4>
        </td>
    </tr>
</table>

<div>
    <p>Sehr geehrte Herrn Max Mustermann,</p>
    <p>mit meinem Schreiben vom <span class="color-red">[[+createdon]]</span> habe ich Ihnen den fälligen Betrag in Höhe von
        <span class="color-red">[[+sum]]€</span> für oben genannte Rechnungsnummer in Rechnung gestellt.
    </p>
    <p>Auf meine letzte Mahnung vom [[+prevWarning]] haben Sie nicht reagiert.
        Aus gegebenen Anlass sehe ich mich gezwungen Verzugszinsen und erhöhte Mahngebühren wie folgt zu verrechnen:
    </p>
</div>

<table class="account">
    <tr>
        <td width="45%">Rechnungsbetrag</td>
        <td width="10%"><span class="color-red">[[+sum]]€</span></td>
        <td width="25%"></td>
    </tr>
    <tr>
        <td width="45%">Verzugszinsen ([[+percent]] %)</td>
        <td width="10%"></td>
        <td width="25%">+ [[+percentPrice]]€</td>
    </tr>
    <tr>
        <td width="45%">Mahngebühren</td>
        <td width="10%"></td>
        <td width="25%">+ [[+fine]]€</td>
    </tr>
    <tr style="border-bottom: 1px solid #000000">
        <th width="45%" align="left">Zu zahlender Gesamtbetrag</th>
        <th width="10%"></th>
        <th width="25%" align="left">= [[+cost]]€</th>
    </tr>
</table>

<div>
    <p>Falls Sie den offenen Gesamtbetrag von [[+cost]]€ nicht bis spätestens [[+nextWarning]] beglichen haben,
        werde ich gerichtliche Schritte gegen Sie einleiten müssen. Die Kosten des gesamten Verfahrens würden zu Ihren Lasten gehen.
    </p>
    <p>Sollten Sie die Rechnung inzwischen beglichen haben, betrachten Sie dieses Schreiben als gegenstandslos.</p>
    <p>Mit freundlichen Grüßen</p>
    <p>Alexander Lotz</p>
</div>
<br /><br />

<table style="font-size: 9pt;">
    <tr>
        <td>Werbeagentur Lotz</td>
        <td>[[++tcbillboard_bank_transfer_name]]</td>
        <td>Steuer-Nr 12345612</td>
        <td></td>
    </tr>
    <tr>
        <td>Inh. Alexander Lotz</td>
        <td>IBAN [[++tcbillboard_bank_transfer_iban]]</td>
        <td>Finanzamt Leverkusen</td>
    </tr>
    <tr>
        <td>Kleiststr. 2</td>
        <td>BIC [[++tcbillboard_bank_transfer_bic]]</td>
        <td></td>
    </tr>
    <tr>
        <td>42799 Leichlingen</td>
        <td></td>
        <td></td>
    </tr>
</table>

<!--mpdf
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
{PAGENO}-{nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->


</body>
</html>