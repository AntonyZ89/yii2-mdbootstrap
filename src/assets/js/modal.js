$(function () {
    function tryParseJSON(jsonString) {
        try {
            var o = JSON.parse(jsonString);

            // Handle non-exception-throwing cases:
            // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
            // but... JSON.parse(null) returns null, and typeof null === "object",
            // so we must check for that, too. Thankfully, null is falsey, so this suffices:
            if (o && typeof o === "object") {
                return o;
            }
        } catch (e) {
        }

        return false;
    };
    $(document).on('click', '.show-modal', function () {
        const self = $(this),
            target = $(self.attr('data-target')),
            ajax_url = (self.attr('data-url') || self.attr('href'))?.replace(/&?modal=1&?/g, ''),
            header = self.attr('data-header') || '';
        const h4 = target.find('.modal-header').find('h4');

        //callback
        const callback = self.attr('data-callback');

        if (callback) {
            target.attr('data-callback', callback);
        }

        if (h4.length === 0) {
            $('<h4>' + header + '</h4>').appendTo(target.find('.modal-header'));
        } else {
            h4.text(header);
        }
        if (ajax_url) {
            var body = target.modal('show').find('.modal-body').empty();
            $.ajax({
                url: ajax_url,
                success: function (response) {
                    body.html(response);

                    if (callback) {
                        body.find('form').attr('data-ajax', 1);
                    }
                },
                error: function (jqXHR) {
                    body.html('<div class="error-summary">' + jqXHR.responseText + '</div>');
                },
                complete: function () {
                    target.trigger('loaded.bs.modal');
                    mdb_helper.input.init();
                }
            });
            return false;
        } else {
            target.modal('show');
        }
    });

    $(document).on('submit', 'form[data-ajax]', function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        const form = $(this);
        const body = form.closest('.modal-body');
        const modal = form.closest('.modal')
        let action = form.attr('action')
        body.empty();

        if (action.includes('?')) {
            action += '&modal=1';
        } else {
            action += '?modal=1';
        }

        console.log({ action })

        // submit form
        $.ajax({
            url: action,
            type: 'post',
            enctype: 'multipart/form-data',
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            data: formData,
            success: function (response) {
                if (response.success) {
                    modal.modal('hide');
                } else {
                    body.html(response);
                }

                const callback = modal.attr('data-callback');

                callback && eval(`typeof ${callback} === 'function'`) && eval(callback)(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                body.html('<div class="error-summary">' + jqXHR.responseText + '</div>');
            },
            complete: function () {
                modal.removeAttr('data-callback');
            }
        });
        return false;
    });

    $('body').on('click', 'a[data-ajax]', function () {
        var self = $(this),
            modal_body = self.closest('.modal-body').empty();
        $.ajax({
            url: self.attr('href'),
            success: function (response) {
                modal_body.html(response);
            },
            error: function (jqXHR) {
                modal_body.html('<div class="error-summary">' + jqXHR.responseText + '</div>');
            }
        });
        return false;
    });
});
