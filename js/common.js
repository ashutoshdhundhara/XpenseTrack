$(document).ready(function () {
    $('[title]').tooltip(tooltip_right);
    $("input:file, select").uniform();

    $('a.delete_expense').click(function (event) {
        event.preventDefault();
        $that = $(this);
        // Ajax request for Cluster map.
        $.ajax({
            type: 'GET',
            url: $that.attr('href'),
            /*data: '',*/
            cache: false,
            dataType: 'json',
            success: function () {
                alert();
            }
        })
    });

    $('#add_expense_form').bind('ajax:complete', function() {
        window.location.reload();
   });

    $('#add_expense').click(function (event) {
        event.preventDefault();
        var $dialog_content = '<form id="add_expense_form" action="" method="POST">' +
            '<input type="hidden" name="add_expense" value="true">' +
            '<table>' +
            '<tr>' +
            '<td>Amount : </td>' +
            '<td><input id="expense_amount" type="text" name="expense_amount" /></td>' +
            '</tr>' +
            '<tr>' +
            '<td>Type : </td>' +
            '<td>' + 
            '<select id="expense_type" name="expense_type">' +
            '<option value="---">Select Type</option>' +
            '<option value="FOOD">Food</option>' +
            '<option value="FEES">Fees</option>' +
            '<option value="FUN">Fun</option>' +
            '<option value="DEBT">Debt</option>' +
            '</select>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Date : </td>' +
            '<td><input id="expense_date" class="datefield" type="text" name="expense_date" /></td>' +
            '</tr>' +
            '</table>' +
            '</form>';
        var buttonOptions = {};
        buttonOptions.OK = function () {
            if ($('#expense_amount').val().length === 0) {
                alert('Enter Amount!');
                return false;
            }
            if ($('#expense_type').val() == '---') {
                alert('Select Expense type!');
                return false;
            }
            if ($('#expense_date').val().length === 0) {
                alert('Enter Date!');
                return false;
            }

            $('#add_expense_form').submit();
        };
        buttonOptions.Cancel = function () {
            $(this).remove();
        };
        // Dialog content.
        var $dialog_content = $('<div/>').append($dialog_content);
        // Create dialog.
        $response_dialog = $($dialog_content).dialog({
            minWidth: 300,
            minHeight: 200,
            modal: true,
            title: 'Add a new Expense',
            resizable: false,
            draggable: true,
            buttons: buttonOptions,
            open: function () {
                $('.ui-dialog select').uniform();
                $('.ui-dialog .datefield').datepicker(datepicker_defaults);
            },
            close: function () {
                $(this).remove();
            }
        });
    });
});

/**
 * Default options for tooltip widget.
 */
var tooltip_right = {
    position: {
      my: 'left center',
      at: 'right center'
    },
    disabled: false,
    tooltipClass: 'xt_tooltip'
};

/**
 * Default options for datepicker widget.
 */
var datepicker_defaults = {
    defaultDate: new Date(),
    numberOfMonths: 1,
    showButtonPanel: false,
    changeMonth: true,
    changeYear: true,
    dateFormat: 'yy-mm-dd'
};

/**
 * Display notification message.
 *
 * @param string message  Message to be displayed
 * @param string type     Type of message (error, success etc.)
 * @return jQuery Object
 */
function XT_showNotification(message, type)
{
    // Whether the notification will automatically disappear
    var self_closing = true;
    // Remove any previous notification.
    $('.xt_notification').remove();

    // Initialize some variables.
    var uiClass = 'ui-state-highlight';
    var uiIcon  = 'ui-icon-info';
    var uiText  = '';
    message = (message !== undefined) ? message : 'Please wait...';
    type = (type !== undefined) ? type : 'load';

    switch(type) {
        case 'load':
            self_closing = false;
            break;
        case 'info':
            uiText = 'NOTICE: ';
            break;
        case 'error':
            uiClass = 'ui-state-error';
            uiIcon  = 'ui-icon-alert';
            uiText  = 'ERROR: ';
    }

    var $notification = $(
        '<div class="ui-widget xt_notification"' +
        'title="Click to dismiss">' +
        '<div class="ui-corner-all ' + uiClass + '" style="padding: 0.8em; font-size: 0.8em;">' +
        '<p>' +
        '<span class="ui-icon ' + uiIcon + '" style="float: left; margin-right: .3em;"></span>' +
        '<strong>' + uiText + '</strong>' +
        message +
        '</p>' +
        '</div>'
    )
    .hide()
    .appendTo('.body_content')
    .bind('click', function () {
        if (type !== 'load') {
            $(this)
            .stop(true, true)
            .fadeOut('medium', function () {
                $(this).tooltip('destroy');
                $(this).remove();
            });
        } else {
            return false;
        }
    })
    .show();

    if (self_closing) {
        $notification
        .delay(3000)
        .fadeOut('medium', function () {
            if ($(this).is(':data(tooltip)')) {
                $(this).tooltip('destroy');
            }
            // Remove the notification
            $(this).remove();
        });
    }

    if (type !== 'load') {
        $($notification).tooltip({
            tooltipClass: 'xt_tooltip',
            track: true,
            show: true
        });
    } else {
        $($notification).attr('title', '');
    }

    return $notification;
}

$(document).ajaxStop(function(){
    window.location.reload();
});