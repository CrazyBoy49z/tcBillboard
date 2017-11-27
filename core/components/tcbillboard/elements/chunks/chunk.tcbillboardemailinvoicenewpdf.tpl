<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11pt; }
        table { width: 100% }
        .color-red { color: #800000; }
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
            <h3>Rechnung</h3>
            <p class="color-red">[[+createdon]]</p>
        </td>
        <td width="50%"></td>
        <td width="25%" valign="top">Rechnungsdatum:</td>
    </tr>
    <tr></tr>
</table>
<br />

<table style="border-bottom: 1px solid #000000; padding-bottom: 10pt;">
    <tr>
        <td>
            <h4>Rechnung Nr. <span class="color-red">[[+num]]</span></h4>
            <p style="font-size: 10pt;">Bitte bei Zahlungen und Schriftverkehr angeben!</p>
        </td>
    </tr>
</table>

<table class="items" width="100%" style="border-collapse: collapse; margin-top: 10pt;" cellpadding="8">
    <tr style="background-color: #c6d9f1; border: 1px solid #000000;">
        <th align="left">Bezeichnung</th>
        <th align="right" style="border-left: 1px solid #000000;">Betrag</th>
    </tr>
    <tr>
        <td style="border-left: 1px solid #000000;">
            Werbung von <span class="color-red">[[+pub_date]]</span> bis <span class="color-red">[[+unpub_date]]</span>
        </td>
        <td align="right" style="border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <span class="color-red">[[+sum]] EUR</span>
        </td>
    </tr>
    <tr>
        <td style="border-left: 1px solid #000000; border-bottom: 1px solid #000000;">
            <span class="color-red">[[+days]]</span> Tagen je <span class="color-red">[[+price]]</span> EUR
        </td>
        <td style="border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000;"></td>
    </tr>
    <tr>
        <th align="right">Gesamtbetrag</th>
        <th align="right" style="border-left: 1px solid #000000; border-bottom: 1px solid #000000;
            border-right: 1px solid #000000;"><span class="color-red">[[+sum]] EUR</span></th>
    </tr>
</table>
<br />

<div>Es wird gemäß §19 Abs. 1 Umsatzsteuergesetz keine Umsatzsteuer erhoben.</div>
<br />

<div>
    <span>Zahlungsart: <span class="color-red">[[+paymentName]]</span></span>
    <br />
    <span>Bitte überweisen Sie den Rechnungsbetrag innerhalb von 15 Tagen.</span>
</div>
<br />

<div>
    <span>[[++tcbillboard_bank_transfer_name]]</span><br />
    <span>Alexander Lotz</span><br />
    <span>IBAN [[++tcbillboard_bank_transfer_iban]]</span><br />
    <span>BIC [[++tcbillboard_bank_transfer_bic]]</span><br />
    <span>Verwendungszweck: <span class="color-red">[[+num]]</span></span><br />
    <span>Bertag: <span class="color-red">[[+sum]]</span>€</span>
</div>
<br /><br /><br />

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