<div>
    <br />
    <p>[[%tcbillboard_bank_success]]</p>
    <br />
    <label>[[%tcbillboard_bank]]</label>
    <br /><br />

    [[+sum:gt=`0`:then=`
    <table class="table tcbillboard-table">
        <tr>
            <td>Kreditinstitut</td>
            <td><strong>[[++tcbillboard_bank_transfer_name]]</strong></td>
        </tr>
        <tr>
            <td>Kontoinhaber</td>
            <td><strong>Alexander Lotz</strong></td>
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
            <td><strong>[[+sum]] €</strong></td>
        </tr>
        [[++tcbillboard_nds_active:is=`1`:then=`
            <tr>
                <td>[[%tcbillboard_front_nds]]:</td>
                <td>[[+nds]]</td>
            </tr>
        `]]
    </table>
    `]]

    <br /><br />
    <a href="[[*uri]]" class="btn btn-primary">[[%tcbillboard_open]]</a>
</div>