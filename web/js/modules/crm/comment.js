let $body = $('body');

$body.on('click', '.crm-entity-section-tab', function () {

    let _this = $(this);
    let partial = _this.attr('data-tab-id');
    let model_id = _this.closest('ul').attr('data-model-id');
    let url = _this.closest('ul').attr('data-log-url');

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            partial: partial,
            model_id: model_id
        },
        dataType: 'html',
        success: function (response) {
            $('.render-crm-log').html(response);
        }
    });
});

$body.on('submit', '#comment', function (event) {
    event.preventDefault();

    let _this = $(this);
    let action = _this.attr('action');
    let method = _this.attr('method');

    let form = _this.serializeArray();

    $.ajax({
        url: action,
        method: method,
        data: form,
        dataType: 'html',
        success: function (response) {
            _this.trigger("reset");
            $(response).insertAfter('#comment');
        }
    });
});

$body.on('click', '.crm-entity-stream-content-new-comment-btn-container > span', function () {
    $(this).closest('form').trigger('reset');
});