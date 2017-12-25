<style>
    .tcbillboard-preview {
        padding-top: 20px;
        text-align: center;
    }
    .tcbillboard-preview-img {
        padding: 3px;
        border: 1px solid #ddd;
    }
    .tcbillboard-preview-promotion,
    .tcbillboard-preview-imges,
    .tcbillboard-preview-content {
        margin-bottom: 20px;
    }
    .tcbillboard-preview-promotion {
        padding: 7px;
        background: #e78439;
        color: #fff;
        text-align: center;
    }
    .tcbillboard-preview-content {
        padding: 30px 30px 0;
    }
    .tcbillboard-imges {
        padding: 5px;
        margin: 5px;
        border: 1px solid #ddd;
        display: inline-block;
    }
    .tcbillboard-wrap-map {
        padding: 3px;
        border: 1px solid #ddd;
    }
    #map {
        height: 300px;
    }
</style>


<div class="row">
    <div class="col-md-5">
        <div class="tcbillboard-preview">
            <img class="tcbillboard-preview-img"
                 src="[[+thumbp:isnot=``:then=`[[+thumbp]]`:else=`[[+photo]]`]]" />
        </div>
    </div>

    <div class="col-md-7 text-center">
        <h2>[[+fullname]]</h2>
        <br />
        <h1>[[*pagetitle]]</h1>
        <br />

        <div class="tcbillboard-preview-promotion bgp">
            [[%tcbillboard_front_duration_of_promotion? &namespace=`tcbillboard`]]&nbsp;
            [[+start_stock:strtotime:date=`%d-%m-%Y`]] &mdash; [[+end_stock:strtotime:date=`%d-%m-%Y`]]
        </div>
    </div>
    <br /><br />

    <div class="col-xs-12 tcbillboard-preview-content">[[*content]]</div>
    <br /><br />

    <div class="col-xs-12 tcbillboard-preview-imges">
        [[!tcBillboardPreviewImg?
            &id = `[[*id]]`
            &createdBy = `[[+internalKey]]`
        ]]
    </div>

    <div class="col-xs-12">

        [[!*createdby:ismember=`Skunden`:then=`
        <div>
            <caption><b>Adresse:</b></caption>
            <table>
                <tr>
                    <td>[[+address]]</td>
                </tr>
                <tr>
                    <td>[[+zip]] [[+city]]</td>
                </tr>
            </table>
            <br />
            [[+website:isnot=``:then=`
            <caption><b>Webseite:</b></caption>
            <table>
                <tr>
                    <td><a href="http://[[+website]]" target="_blank">[[+website]]</a></td>
                </tr>
            </table>
            <br />
            `]]
        </div>
        `]]

        [[!*createdby:ismember=`Okunden`:then=`
            [[+website:isnot=``:then=`
            <caption><b>Webseite:</b></caption>
            <table>
                <tr>
                    <td><a href="http://[[+website]]" target="_blank">[[+website]]</a></td>
                </tr>
            </table>
            <br />
            `]]
        `]]
        <div class="tcbillboard-wrap-map">
            <div id="map"></div>
        </div>
    </div>
</div>

[[$streifen]]

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
        var address = '[[+address]], [[+zip]] [[+city]]';
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

    $(document).ready(function() {
        $('[data-fancybox]').fancybox();
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=[[++tcbillboard_google_api_key]]&callback=initMap"
        async defer>
</script>