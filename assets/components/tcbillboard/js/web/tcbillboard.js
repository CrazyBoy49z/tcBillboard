var tcBillboard = {
    initialize: function(config) {
        actionPatch = config.actionUrl;
        selectorForm = '#' + config.selectorForm;
        selectorScore = '#tcbillboard-score';
        selectorTitulImg = '#tcbillboard-img';
        selectorDisplay = '#tcbillboard-file-remove';
        selectorPreviwImg = '.tcbillboard-preview-img';

        selectorErrDate = '#tcbillboard-err-date';
        selectorErrDateStock = '#tcbillboard-err-date-stock';

        dtPicker1 = '#datetimepicker1';
        dtPicker2 = '#datetimepicker2';
        dtPicker3 = '#datetimepicker3';
        dtPicker4 = '#datetimepicker4';
        maskPubDate = '#mask-pub-date';
        maskUnPubDate = '#mask-unpub-date';
        maskStartStock = '#mask-start-stock';
        maskEndStock = '#mask-end-stock';

        setTimeout(function() {
            tcBillboard.process('tcBillboard/setSession', $('#ticketForm')
                .find('input[name=payment]:checked').val());
            var photo = $(selectorTitulImg).attr('src');
            $(selectorPreviwImg).attr('src', photo);
            $('input[name=thumbp]').val(photo).change();
        }, 3000);

        $(document).on('click touchend', selectorForm, function(e) {
            var payment = $(this).closest('form').find('input[name=payment]:checked').val();
            var act = $(this).data('tcbillboard');

            tcBillboard.process(act, payment);
        });
        // Календарь даты публикации/снятия с публикации
        $(dtPicker1).datetimepicker({
            format: 'DD.MM.YYYY',
            minDate: {
                Default: true
            },
            locale: 'de'
        });
        $(dtPicker2).datetimepicker({
            format: 'DD.MM.YYYY',
            minDate: {
                Default: true
            },
            useCurrent: false,
            locale: 'de'
        });
        $(dtPicker1).on("dp.change",function (e) {
            $(dtPicker2).data("DateTimePicker").minDate(e.date);
            $(maskPubDate).val(e.currentTarget.value).change();

            var action = $(this).data('tcbillboard');
            var mnDate = $(this).val();

            tcBillboard.process(action, mnDate);
        });
        $(dtPicker2).on("dp.change",function (e) {
            $(dtPicker1).data("DateTimePicker").maxDate(e.date);
            $(dtPicker4).data("DateTimePicker").maxDate(e.date);
            $(maskUnPubDate).val(e.currentTarget.value).change();
            $(selectorErrDate).empty();

            var action = $(this).data('tcbillboard');
            var mxDate = $(this).val();

            tcBillboard.process(action, mxDate);
        });
        // Календарь прохождения акции у пользователя
        $(dtPicker3).datetimepicker({
            format: 'DD.MM.YYYY',
            minDate: {
                Default: true
            },
            locale: 'de'
        });
        $(dtPicker4).datetimepicker({
            format: 'DD.MM.YYYY',
            minDate: {
                Default: true
            },
            useCurrent: false,
            locale: 'de'
        });
        $(dtPicker3).on("dp.change",function (e) {
            $(dtPicker4).data("DateTimePicker").minDate(e.date);
            $(dtPicker1).data("DateTimePicker").maxDate(e.date);
            $(maskStartStock).val(e.currentTarget.value).change();

            var action = $(this).data('tcbillboard');
            var mnDate = $(this).val();

            tcBillboard.process(action, mnDate);
        });
        $(dtPicker4).on("dp.change",function (e) {
            $(dtPicker3).data("DateTimePicker").maxDate(e.date);
            $(dtPicker2).data("DateTimePicker").minDate(e.date);
            $(maskStartStock).val(e.currentTarget.value).change();
            $(selectorErrDateStock).empty();

            var action = $(this).data('tcbillboard');
            var mxDate = $(this).val();

            tcBillboard.process(action, mxDate);
        });
        // Удалить титульную картинку
        $(document).on('click touchend', selectorDisplay, function() {
            var action = $(this).data('action');
            var tid = $(this).data('tid');
            tcBillboard.process(action, tid);
        });
    },

    process: function(a, t) {
        var sendData = {
            action: a,
            value: t
        };
        tcBillboard.send(sendData);
    },

    send: function(sendData)  {
        $.ajax({
            type: 'POST',
            url: actionPatch,
            data: sendData,
            dataType: 'json',
            cache: false,
            success: function(response) {
                if (response['success'] == true) {
                    if (response.message == 'tplScore') {
                        $(selectorScore).html(response.data);
                    }
                    // Заменить титульную картинку
                    if (response.data.photo) {
                        $(selectorTitulImg).attr('src', response.data.photo);
                        $(selectorPreviwImg).attr('src', response.data.photo);
                        $(selectorTitulImg).attr('alt', '');
                        $('input[name=thumbp]').val(response.data.photo).change();
                        $(selectorDisplay).attr('style', 'display: none;');
                    }
                } else {
                    if (response.data.end_stock) {
                        $(selectorErrDateStock).html(response.message);
                        $(dtPicker4).val('').change();
                    } else if (response.data.unpub_pub) {
                        $(selectorErrDate).html(response.message);
                        $(dtPicker2).val('').change();
                    }
                }
                //console.log(response);
            },
            error: function(response){

                console.log('error');
            }
        });
    }
};