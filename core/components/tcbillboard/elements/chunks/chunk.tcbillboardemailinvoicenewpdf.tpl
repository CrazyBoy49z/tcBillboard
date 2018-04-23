<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11pt; }
        table { width: 100% }
    </style>
</head>
<body>

<table>
    <tr>
        <td width="50%" style="text-align: left;"><img src="/assets/components/tcbillboard/examples/img/logo.png" /></td>
        <td width="50%"></td>
    </tr>
</table>

<div style="margin-top:30pt; font-size: 9pt;"><u>Werbeagentur Lotz – Kaiser-Wilhelm-Ring 27-29 - 50672 Köln</u></div>
<br />

<table>
    <tr>
        <td width="25%" valign="top">
            <p>[[+fullname]]</p>
            <p>[[+anrede]] [[+vorname]] [[+nachname]]</p>
            <p>[[+address]]</p>
            <p>[[+zip]] [[+city]]</p>
        </td>
        <td width="40%"></td>
        <td width="35%" valign="top">
            <p>Werbeagentur Lotz</p>
            <p>Inh. Alexander Lotz</p>
            <p>Kaiser-Wilhelm-Ring 27-29</p>
            <p>50672 Köln</p>
            <p>Tel.: +49 176 47519730</p>
            <p>E-Mail: info@saisonverkauf.info</p>
            <p>Internet: saisonverkauf.info</p>
        </td>
    </tr>
</table>
<br />
<table>
    <tr>
        <td width="65%">
            <h3>Rechnung</h3>
        </td>
        <td width="35%" valign="top">Rechnungsdatum: [[+createdon]]</td>
    </tr>
    <tr></tr>
</table>
<br />

<table style="border-bottom: 1px solid #000000; padding-bottom: 10pt;">
    <tr>
        <td>
            <h4>Rechnung Nr. <span>[[+num]]</span></h4>
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
            Werbung von <span>[[+pub_date]]</span> bis <span>[[+unpub_date]]</span>
        </td>
        <td align="right" style="border-left: 1px solid #000000; border-right: 1px solid #000000;">
            <span>[[+sum]] EUR</span>
        </td>
    </tr>
    <tr>
        <td style="border-left: 1px solid #000000; border-bottom: 1px solid #000000;">
            <span>[[+days]]</span> Tagen je <span>[[+price]]</span> EUR
        </td>
        <td style="border-left: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000;"></td>
    </tr>
    <tr>
        <th align="right">Gesamtbetrag</th>
        <th align="right" style="border-left: 1px solid #000000; border-bottom: 1px solid #000000;
            border-right: 1px solid #000000;"><span>[[+sum]] EUR</span></th>
    </tr>
    <tr>
        <th align="right">НДС</th>
        <th align="right" style="border-left: 1px solid #000000; border-bottom: 1px solid #000000;
            border-right: 1px solid #000000;"><span>[[+nds]] EUR</span></th>
    </tr>
</table>
<br />

<div>Es wird gemäß §19 Abs. 1 Umsatzsteuergesetz keine Umsatzsteuer erhoben.</div>
<br />

<div>
    <span>Zahlungsart: <span>[[+paymentName]]</span></span>
    <br />
    <span>Bitte überweisen Sie den Rechnungsbetrag innerhalb von 15 Tagen.</span>
</div>
<br />

<div>
    <span>[[++tcbillboard_bank_transfer_name]]</span><br />
    <span>Alexander Lotz</span><br />
    <span>IBAN [[++tcbillboard_bank_transfer_iban]]</span><br />
    <span>BIC [[++tcbillboard_bank_transfer_bic]]</span><br />
    <span>Verwendungszweck: <span>[[+num]]</span></span><br />
    <span>Bertag: <span>[[+sum]]&nbsp;</span>€</span>
</div>
<br /><br /><br />

<table style="font-size: 9pt;">
    <tr>
        <td>Werbeagentur Lotz</td>
        <td>[[++tcbillboard_bank_transfer_name]]</td>
        <td>DE314077357</td>
        <td></td>
    </tr>
    <tr>
        <td>Inh. Alexander Lotz</td>
        <td>IBAN [[++tcbillboard_bank_transfer_iban]]</td>
        <td>Finanzamt Leverkusen</td>
    </tr>
    <tr>
        <td>Kaiser-Wilhelm-Ring 27-29</td>
        <td>BIC [[++tcbillboard_bank_transfer_bic]]</td>
        <td></td>
    </tr>
    <tr>
        <td>50672 Köln</td>
        <td></td>
        <td></td>
    </tr>
</table>

</body>
</html>