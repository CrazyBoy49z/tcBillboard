<div class="row">
    <div class="col-md-5 col-md-push-5 alert alert-success">
        <span>[[%tcbillboard_front_titular_text? &namespace=`tcbillboard`]]</span>
        <br /><br />
    </div>
    <div class="col-md-5 col-md-pull-5">
        <div class="tcbillboard-preview thumbnail">
            <img class="tcbillboard-preview-img" src="[[+thumbp]]" />
            <p class="tcbillboard-preview-user">[[+modx.user.id:userinfo=`username`]]</p>
            <div class="tcbillboard-preview-pagetitle bgp">[[+pagetitle]]</div>
            <div class="tcbillboard-preview-dates">[[+start_stock]] &mdash; [[+end_stock]]</div>
            <div class="tcbillboard-preview-expand">[[%tcbillboard_front_expand? &namespace=`tcbillboard`]]&nbsp;&nbsp;
                <i class="glyphicon glyphicon-expand"></i>
            </div>
        </div>
    </div>
    <div class="col-xs-12 tcbillboard-hr"></div>

    <div class="col-md-5">
        <div class="tcbillboard-preview">
            <img class="tcbillboard-preview-img" src="[[+thumbp]]" />
        </div>
    </div>
    <div class="col-md-7">
        <h2>[[+modx.user.id:userinfo=`username`]]</h2>
        <br />
        <h4>[[+pagetitle]]</h4>
        <br />

        <div class="tcbillboard-preview-promotion bgp">
            [[%tcbillboard_front_duration_of_promotion? &namespace=`tcbillboard`]]&nbsp;
            [[+start_stock]] &mdash; [[+end_stock]]
        </div>
    </div>
    <br /><br />

    <div class="col-xs-12 tcbillboard-preview-content">[[+content]]</div>
    <br /><br />

    <div class="col-xs-12 tcbillboard-preview-imges">
        [[!tcBillboardPreviewImg?
            &id = `[[+tid]]`
        ]]
    </div>

    <div class="col-xs-12">
        <div>
            <caption><b>Adresse:</b></caption>
            <table>
                <tr>
                    <td>[[+modx.user.id:userinfo=`address`]]</td>
                </tr>
                <tr>
                    <td>[[+modx.user.id:userinfo=`zip`]] [[+modx.user.id:userinfo=`city`]]</td>
                </tr>
            </table>
            <br />
            [[+modx.user.id:userinfo=`website`:isnot=``:then=`
                <caption><b>Webseite:</b></caption>
                <table>
                    <tr>
                        <td><a href="http://[[+modx.user.id:userinfo=`website`]]" target="_blank">[[+modx.user.id:userinfo=`website`]]</a></td>
                    </tr>
                </table>
                <br />
            `]]
        </div>
        <div class="tcbillboard-wrap-map">
            <div id="map"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var safeColors = ['d5423f','e2843e','c571a1','a478d3','53c760','78a744','07b1aa','0aa9ec','2b98e3','845cb5'];
    var rand = function() {
        return Math.floor(Math.random()*10);
    };
    var randomColor = function() {
        var r = safeColors[rand()];
        return "#"+r;
    };
    function colr(){
        $('.bgp').each(function() {
            $(this).css('background',randomColor());
        });
    }
    window.addEventListener('onload', colr());
</script>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: [[++tcbillboard_google_map_zoom]],
            center: {
                lat: [[++tcbillboard_google_map_latitude]],
                lng: [[++tcbillboard_google_map_longitude]]
            }
        });
        var geocoder = new google.maps.Geocoder();

        geocodeAddress(geocoder, map);
    }

    function geocodeAddress(geocoder, resultsMap) {
        var address = '[[+modx.user.id:userinfo=`address`]], [[+modx.user.id:userinfo=`zip`]] [[+modx.user.id:userinfo=`city`]]';
        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status === 'OK') {
                resultsMap.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location
                });
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=[[++tcbillboard_google_api_key]]&callback=initMap"
        async defer>
</script>