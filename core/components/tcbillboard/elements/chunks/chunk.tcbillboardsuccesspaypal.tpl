<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div>
    <p>[[%tcbillboard_bank_success]]</p>
    <br /><br /><br />
</div>

<div>
    <p>Осталось оплатить заказ, нажав эту кнопку.</p>
</div>




<div id="paypal-button-container"></div>

<div id="confirm" style="display: none;">
    <div>Ship to:</div>
    <div><span id="recipient"></span>, <span id="line1"></span>, <span id="city"></span></div>
    <div><span id="state"></span>, <span id="zip"></span>, <span id="country"></span></div>

    <button id="confirmButton">Complete Payment</button>
</div>

<div id="thanks" style="display: none;">
    Thanks, <span id="thanksname"></span>!

    <br /><br />
    <a href="[[*uri]]" class="btn btn-default">[[%tcbillboard_open]]</a>
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
            sandbox:    'AQahnTkrbrXlGO83r7qW2kiG_acR2zj5CN-r15ry6IMBm6cN6cszCzorLPgr8mXpUdZfD2B6iicHUB_Q',
            production: 'AZh9fDi0JdI052zaJXBHVMIMOnHQil3CbedobqTGDHUsUb4kn9NDcgEpZQuKm-DcKH-gR6en2FQKCGAW'
        },

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '0.01', currency: 'USD' }
                        }
                    ]
                }
            });
        },

        // Wait for the payment to be authorized by the customer

        onAuthorize: function(data, actions) {

            // Get the payment details

            return actions.payment.get().then(function(data) {

                // Display the payment details and a confirmation button

                var shipping = data.payer.payer_info.shipping_address;

                document.querySelector('#recipient').innerText = shipping.recipient_name;
                document.querySelector('#line1').innerText     = shipping.line1;
                document.querySelector('#city').innerText      = shipping.city;
                document.querySelector('#state').innerText     = shipping.state;
                document.querySelector('#zip').innerText       = shipping.postal_code;
                document.querySelector('#country').innerText   = shipping.country_code;

                document.querySelector('#paypal-button-container').style.display = 'none';
                document.querySelector('#confirm').style.display = 'block';

                // Listen for click on confirm button

                document.querySelector('#confirmButton').addEventListener('click', function() {

                    // Disable the button and show a loading message

                    document.querySelector('#confirm').innerText = 'Loading...';
                    document.querySelector('#confirm').disabled = true;

                    // Execute the payment

                    return actions.payment.execute().then(function() {

                        // Show a thank-you note

                        document.querySelector('#thanksname').innerText = shipping.recipient_name;

                        document.querySelector('#confirm').style.display = 'none';
                        document.querySelector('#thanks').style.display = 'block';
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

[[-
Sandbox
Sandbox account - yugan@inbox.ru
Client ID - AdmL3nCHKKF3YygPIyaQAMiaKX4WJzG0OZj3b4oiHdmFqjVyBOGC4GuRyaHkepLr7BLKdSIIfA3buEAx
Secret key - EAAdQ9c69Esse9GB7gV-5pkXc9Szs8ctBP129eDcPNVJgZkHdeOVMJTXrEF86RpUlBVm-H1LcRQCO8r7


PayPal account: yugan@inbox.ru
Client ID - AXPX8ldoeZZZHudbR5Yiuxtvu7Ud7-RWnnPTnruVMMG37nrkKx3q_SBGVzobAaY5e4cuS0fGgc4jLl_9
Secret key - EH_2YK1c2xDx0jqmgdWZd-1Xz38qem6PC5yPqYEh7IjZL92225sT9h2pV9yI04LPwTMGDCkRjedRBJll

]]