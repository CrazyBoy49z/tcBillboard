<div class="col-xs-10 col-sm-6 col-md-4 col-lg-3 col-xs-offset-1 col-sm-offset-0">
    <a href="/[[+uri]]" class="previewFont">
        <div class="tcbillboard-preview thumbnail previewBox">
            <img class="tcbillboard-preview-img preview1"
                 src="[[+thumb:isnot=``:then=`[[+thumb:phpthumbon=`w=320&h=240`]]`:else=`[[+photo:phpthumbon=`w=320&h=240`]]`]]"
                 alt="" />
            <p class="tcbillboard-preview-user">[[+fullname]]</p>
            <div class="tcbillboard-preview-pagetitle bgp">[[+pagetitle]]</div>
            <div class="tcbillboard-preview-dates preview2">
                [[+start_stock:strtotime:date=`%d-%m-%Y`]] &mdash; [[+end_stock:strtotime:date=`%d-%m-%Y`]]
            </div>
            <hr class="previewHR">
            <div class="tcbillboard-preview-expand preview3">[[%tcbillboard_front_expand? &namespace=`tcbillboard`]]&nbsp;&nbsp;
                <i class="glyphicon glyphicon-expand"></i>
            </div>
        </div>
    </a>
</div>
[[$streifen]]