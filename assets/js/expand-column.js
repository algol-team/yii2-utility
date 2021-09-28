var ExpandRow = function (options) {
    var _url = options.url,
        countColumns = options.countColumns,
        enableCache = options.enableCache,
        loading = options.loading,
        showEffect = options.showEffect,
        hideEffect = options.hideEffect,
        redirect = options.redirect;

    this.hideNotCurrent = function (rowID, current) {
        this.hide($("tr[id^=expand-column-detail-" + rowID + "]").not(current));
    };

    this.hide = function (element) {
        switch (hideEffect) {
            case 'slideUp':
                element.slideUp();
                break;
            case 'fadeOut':
                element.fadeOut();
                break;
            default:
                element.hide();
        }
    };

    this.show = function (element) {
        switch (showEffect) {
            case 'slideDown':
                element.slideDown();
                break;
            case 'fadeIn':
                element.fadeIn();
                break;
            default:
                element.show();
        }
    };

    this.run = function ($el) {
        if (redirect === true) {
            var params = $el.data('info');
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", _url);
            for(var key in params) {
                if(params.hasOwnProperty(key)) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", params[key]);
                    form.appendChild(hiddenField);
                }
            }
            document.body.appendChild(form);
            form.submit();
        } else {
            var row_id = $el.data('row_id'),
                col_id = $el.data('col_id'),
                _data = $el.data('info'),
                parent = $el.parents('tr').eq(0),
                tr = $('#expand-column-detail-' + row_id + col_id);
            if (tr.length && !tr.is(':visible') && enableCache) {
                this.hideNotCurrent(row_id, tr);
                this.show(tr);
                return;
            } else if (tr.length && tr.is(':visible')) {
                this.hide(tr);
                return;
            }
            if (tr.length) {
                this.hideNotCurrent(row_id, tr);
                tr.find('td').html(loading);
                if (!tr.is(':visible')) {
                    this.show(tr);
                }
            } else {
                this.hide($("tr[id^=expand-column-detail-" + row_id + "]"));
                var td = $('<td/>').html(loading).attr({'colspan': countColumns});
                tr = $('<tr/>').prop({'id': 'expand-column-detail-' + row_id + col_id}).append(td);
                parent.after(tr);
            }
            $.ajax({
                url: _url,
                method: 'GET',
                data: _data,
                success: function (data) {
                    tr.find('td').html(data);
                },
                error: function () {
                    tr.find('td').html('not found page');
                }
            });
        }
    };

};