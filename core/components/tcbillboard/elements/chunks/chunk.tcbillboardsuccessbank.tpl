<div>
    <p>[[%tcbillboard_bank_success]]</p>
    <br /><br /><br />

    [[+sum:gt=`0`:then=`
    <table class="table tcbillboard-table">
        <tr>
            <th>[[%tcbillboard_bank]]</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td>[[++tcbillboard_bank_transfer_name]]</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Alexander Lotz</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>IBAN</td>
            <td><strong>[[++tcbillboard_bank_transfer_iban]]</strong></td>
        </tr>
        <tr>
            <td>BIC</td>
            <td><strong>[[++tcbillboard_bank_transfer_bic]]</strong></td>
        </tr>
        <tr>
            <td>[[%tcbillboard_num_invoice]]:</td>
            <td><strong>[[+num]]</strong></td>
        </tr>
        <tr>
            <td>[[%tcbillboard_sum_order]]:</td>
            <td><strong>[[+sum]]€</strong></td>
        </tr>
    </table>
    `]]

    <br /><br />
    <a href="[[*uri]]" class="btn btn-default">[[%tcbillboard_open]]</a>
</div>