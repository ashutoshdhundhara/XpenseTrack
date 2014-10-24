$(document).ready(function () {
    $('[title]').tooltip(tooltip_right);
    $("input:file, select").uniform();
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