$(document).ready(function() {

    //var form = $('#ticketForm');

    var uploader = new plupload.Uploader({
        runtimes: 'html5,flash,silverlight,html4',
        container: 'tcbillboard-file-container',
        browse_button: 'tcbillboard-file-select',
        form: $('#ticketForm'),

        /*runtimes: 'html5,flash,silverlight,html4',

        browse_button: 'ticket-files-select',
        //upload_button: document.getElementById('ticket-files-upload'),
        container: 'ticket-files-container',
        filelist: 'ticket-files-list',
        progress: 'ticket-files-progress',
        progress_bar: 'ticket-files-progress-bar',
        progress_count: 'ticket-files-progress-count',
        progress_percent: 'ticket-files-progress-percent',
        form: form,*/

        multipart_params: {
            action: $('#' + this.container).data('action') || 'tcbillboard/titul/upload',
            tid: $('#ticketForm').find('[name="tid"]').val(),
            form_key: $('#ticketForm').find('[name="form_key"]').val(),
            ctx: TicketsConfig.ctx || 'web'
        },

        url: '/assets/components/tcbillboard/action.php',

        filters: {
            max_file_size: TicketsConfig.source.size,
            mime_types: [{
                title: 'Files',
                extensions: TicketsConfig.source.extensions
            }]
        },

        resize: {
            width: TicketsConfig.source.width || 1080,
            height: TicketsConfig.source.height || 1080
        },

        flash_swf_url: TicketsConfig.jsUrl + 'web/lib/plupload/js/Moxie.swf',
        silverlight_xap_url: TicketsConfig.jsUrl + 'web/lib/plupload/js/Moxie.xap',

        init: {
            Init: function () {

            },

            PostInit: function (up) {

                //console.log(up);
            },

            FilesAdded: function (up) {

                //console.log(up);

                this.settings.form.find('[type="submit"]').attr('disabled', true);
                up.start();
            },

            FileUploaded: function (up, file, response) {
                response = $.parseJSON(response.response);
                if (response.success) {
                    //if (response.data.new) {
                        //$('#tcbillboard-file-container a').replaceWith(response.data.tpl);
                        $('#tcbillboard-img').attr('src', response.data.thumb).css('display', 'block');
                    $('input[name=thumbp]').val(response.data.thumb);
                        $('#tcbillboard-img').attr('alt', response.data.name);
                        $('#tcbillboard-file-remove').css('display', 'inline-block');

                    //console.log(up);
                }

                //console.log(up, file, response);
            },

            UploadComplete: function (up) {

                //console.log(up);

                $(up.settings.browse_button).show();
                $('#' + up.settings.progress).hide();
                up.total.reset();
                up.splice();
                this.settings.form.find('[type="submit"]').attr('disabled', false);
            },

            Error: function (up, err) {
                Tickets.Message.error(err.message);
            }
        }
    });

    uploader.init();

});
