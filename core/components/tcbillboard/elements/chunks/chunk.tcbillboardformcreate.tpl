<form class="tcbillboard-form well create" method="post" action="" id="ticketForm" enctype="multipart/form-data">
    <input type="hidden" name="tid" value="0"/>

    <input type="hidden" name="files" value="" />

    <div class="form-group">
        <label for="ticket-sections">[[%tcbillboard_front_select_category]]</label>
        <select name="parent" class="form-control" id="ticket-sections">[[+sections]]</select>
        <span class="error"></span>
    </div>
    <br />

    <div class="row">
        <div class="col-md-5 col-md-push-7 alert alert-success">
            <span>[[%tcbillboard_front_titular_text]]</span>
            <br /><br />
        </div>

        <div class="col-md-7 col-md-pull-5">
            <div id="tb-titul-block">

                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" style="width: 170px; height: 170px; line-height: 170px;">
                        <img id="tcbillboard-img" src="[[+thumb]]" alt="[[+name]]" />
                    </div>
                </div>

                <input type="hidden" name="thumbp" value="[[+thumb]]" />

                <div id="tcbillboard-file-container" data-action="tcbillboard/titul/upload">

                    <a id="tcbillboard-file-select" class="btn btn-default" href="javascript:;">[[%tcbillboard_front_change]]</a>
                    <a id="tcbillboard-file-remove" class="btn btn-default[[+display]]"
                       href="javascript:;" data-action="tcbillboard/titul/remove"
                       data-tid="[[+id]]">[[%tcbillboard_front_remove]]</a>

                </div>

            </div>
            <br /><br />

            <div class="form-group">
                <label for="ticket-pagetitle">[[%tcbillboard_describe_your_action]]</label>
                <input type="text" class="form-control" name="pagetitle" value="" maxlength="50" id="ticket-pagetitle"/>
                <span class="error"></span>
            </div>
            <br />

            <div><label>[[%tcbillboard_front_duration_of_action]]:</label></div>

            <div class="row">
                <div class="col-xs-6">
                    <div class="form-inline">
                        <label class="tcbilboard-label">[[%tcbillboard_front_with]]</label>
                        <input id="datetimepicker3" type="text" class="form-control tcbilboard-input"
                               data-tcbillboard="tcbillboard/startstock"name="start_stock" value="" />
                        <input id="mask-start-stock" type="hidden" name="mask_start_stock" value="" />
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-inline">
                        <label class="tcbilboard-label">[[%tcbillboard_front_by]]</label>
                        <input id="datetimepicker4" type="text" class="form-control tcbilboard-input"
                               data-tcbillboard="tcbillboard/endstock"name="end_stock" value="" />
                        <input id="mask-end-stock" type="hidden" name="mask_end_stock" value="" />
                    </div>
                </div>
                <span id="tcbillboard-err-date-stock" class="error"></span>
            </div>
            <br /><br />

        </div>
    </div>

    <div class="form-group">
        <textarea class="form-control" placeholder="[[%ticket_content]]" name="content" id="ticket-editor"
                  rows="10"></textarea>
        <span class="error"></span>
    </div>

    <div class="ticket-form-files">
        [[+files]]
    </div>

    <div class="form-actions row">
        <div class="col-md-6">
            <input type="button" class="btn btn-default preview" value="[[%ticket_preview]]" title="Ctrl + Enter"/>
        </div>
    </div>
    <br /><br />

    <div id="ticket-preview-placeholder"></div>

    <div><label>[[%tcbillboard_front_promotion_displayed]]:</label></div>

    <div class="row">
        <div class="col-xs-7">
            <div class="col-xs-6">
                <div class="form-inline">
                    <label class="tcbilboard-label">[[%tcbillboard_front_with]]</label>
                    <input id="datetimepicker1" type="text" class="form-control tcbilboard-input"
                           name="pub_date" data-tcbillboard="tcbillboard/pubdate" value="" />
                    <div class="error"></div>
                    <input id="mask-pub-date" type="hidden" name="mask_pub_dade" value="" />
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-inline">
                    <label class="tcbilboard-label">[[%tcbillboard_front_by]]</label>
                    <input id="datetimepicker2" type="text" class="form-control tcbilboard-input"
                           name="unpub_date" data-tcbillboard="tcbillboard/unpubdate" value="" />
                    <div class="error"></div>
                    <input id="mask-unpub-date" type="hidden" name="mask_unpub_dade" value="" />
                </div>
            </div>
            <span id="tcbillboard-err-date" class="error"></span>

            <div id="tcbillboard-score" class="clearfix"></div>

        </div>
    </div>
    <br /><br />

    <div><label class="tcbilboard-label">[[%tcbillboard_front_payment_method]]</label></div>

    <div>
        <div class="radio">
            <label>
                <input type="radio" name="payment" value="1" checked />
                [[%tcbillboard_front_bank_transfer]]
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="payment" value="2" />
                [[%tcbillboard_front_paypal]]
            </label>
        </div>
    </div>
    <br /><br />

    <div class="row">
        <div class="col-md-12">
            <div>
                <label for="tcbillboard-checked">
                    <input type="checkbox" id="tcbillboard-checked" />
                    Я прочитал <a href="" target="_blank">условия договора</a> и согласен с ним.
                </label>
            </div>
            <br />
            <input type="button" id="tcbillboard-form" class="btn btn-primary publish"
                   name="publish" value="[[%ticket_publish]]" data-tcbillboard="tcBillboard/publish" disabled />
        </div>
    </div>
    <br /><br />

</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tcbillboard-checked').change(function() {
            $('#tcbillboard-form').prop('disabled', function(i, val) {
                return !val;
            })
        });

        $('[data-fancybox]').fancybox();
    });

</script>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinyMCE.PluginManager.add('stylebuttons', function(editor, url) {
        ['pre', 'p', 'code', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'].forEach(function(name){
            editor.addButton("style-" + name, {
                tooltip: "Header " + name.toUpperCase(),
                text: name.toUpperCase(),
                onClick: function() { editor.execCommand('mceToggleFormat', false, name); },
                onPostRender: function() {
                    var self = this, setup = function() {
                        editor.formatter.formatChanged(name, function(state) {
                            self.active(state);
                        });
                    };
                    editor.formatter ? setup() : editor.on('init', setup);
                }
            })
        });
    });

    tinymce.init({
        selector: "#ticket-editor",
        setup: function (editor) {editor.on('change', function () {editor.save();});},
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code stylebuttons'
        ],
        advlist_bullet_styles:'',
        advlist_number_styles:'',
        menu:{},
        toolbar:'undo redo | bold italic underline strikethrough alignleft aligncenter | bullist numlist | link'
    });
</script>
