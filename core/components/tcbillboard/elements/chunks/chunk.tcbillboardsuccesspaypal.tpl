<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div>
    <p>[[%tcbillboard_bank_success]]</p>
    <br /><br /><br />
</div>

<div id="tcbillboard-confirm">
    <h4>[[%tcbillboard_front_data_order]]:</h4>
    <table class="table tcbillboard-table">
        <tr>
            <td>[[%tcbillboard_num_invoice]]:</td>
            <td><strong>[[+num]]</strong></td>
        </tr>
        <tr>
            <td>[[%tcbillboard_pubdatedon]]:</td>
            <td><strong>[[+pubdatedon]]</strong></td>
        </tr>
        <tr>
            <td>[[%tcbillboard_unpubdatedon]]:</td>
            <td><strong>[[+unpubdatedon]]</strong></td>
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

    <p><strong>[[%tcbillboard_front_select_payment]]</strong></p>
</div>

<div id="paypal-button-container"></div>

<div id="tcbillboard-error" class="text-danger"></div>

<div id="confirm" style="display: none;">
    <button id="confirmButton" class="btn btn-primary">[[%tcbillboard_front_complete_payment]]</button>
</div>

<div id="thanks" style="display: none;">
    <span id="thanksname"></span>, [[%tcbillboard_front_success_payment]]
</div>

<br /><br />
<div id="tcbillboard-open" style="display: none;">
    <a href="[[*uri]]" class="btn btn-primary">[[%tcbillboard_open]]</a>
</div>


<script>
    paypal.Button.render({
        env: 'sandbox', // sandbox | production
        locale: 'de_DE',
        style: {
            size: 'medium',
            fundingicons: true
        },
        client: {
            sandbox:    '[[++tcbillboard_paypal_key_sandbox]]',
            //production: '[[++tcbillboard_paypal_key_production]]'
        },

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '[[+sum:replace=`,==.`]]', currency: '[[++tcbillboard_paypal_currency]]' }
                        }
                    ]
                }
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.get().then(function(data) {
                var shipping = data.payer.payer_info.shipping_address;
                var sendData = {
                        action: 'tcBillboard/paymentPayPal',
                        value: data,
                        res: [[*id]]
                }

                document.querySelector('#paypal-button-container').style.display = 'none';
                document.querySelector('#tcbillboard-confirm').style.display = 'none';

                $.ajax({
                    type: 'POST',
                    url: '[[++assets_url]]components/tcbillboard/action.php',
                    data: sendData,
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        if (response.success == true) {
                            document.querySelector('#confirm').style.display = 'block';
                        } else if(response.success == false) {
                            document.querySelector('#tcbillboard-error').innerText = response.message;
                            document.querySelector('#tcbillboard-open').style.display = 'block';
                        }
                    }
                });

                document.querySelector('#confirmButton').addEventListener('click', function() {

                    document.querySelector('#confirm').innerText = 'Loading...';
                    document.querySelector('#confirm').disabled = true;

                    return actions.payment.execute().then(function(data) {
                        var sendData = {
                            action: 'tcBillboard/paymentPayPal',
                            value: data,
                            res: [[*id]]
                        }

                        $.ajax({
                            type: 'POST',
                            url: '[[++assets_url]]components/tcbillboard/action.php',
                            data: sendData,
                            dataType: 'json',
                            cache: false,
                            success: function(response) {
                                if (response.success == true) {
                                    document.querySelector('#thanksname').innerText = shipping.recipient_name;

                                    document.querySelector('#confirm').style.display = 'none';
                                    document.querySelector('#thanks').style.display = 'block';
                                    document.querySelector('#tcbillboard-open').style.display = 'block';
                                } else if(response.success == false) {
                                    document.querySelector('#tcbillboard-error').innerText = response.message;
                                    document.querySelector('#tcbillboard-open').style.display = 'block';
                                }
                            }
                        });
                    });
                });
            });
        },

        onCancel: function(data, actions) {

            console.log(data, actions)

            /*
             * если покупатель отменяет платеж
             */
        },

        onError: function(err) {

            console.log(err)

            /*
             * при возникновении ошибки
             */
        }

    }, '#paypal-button-container');

</script>