$.blockUI.defaults.message = '<img src="' + mapperJs.location + 'assets/images/wedges.svg">';
$.blockUI.defaults.css.backgroundColor = "none";
$.blockUI.defaults.css.border = "none";
$.blockUI.defaults.overlayCSS.opacity = 0.1;
$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

function _notify( message, type ){
    var icon;
    switch( type ){
        case 'success':
            icon = 'fa-check-circle';
        break;
        case 'warning':
            icon = 'fa-exclamation-circle';
        break;
        case 'danger':
            icon = 'fa-times-circle';
        break;
        case 'default':
            icon = 'fa-info-circle';
    }
    $.notify({
        icon: 'fa ' + icon,
        message: message
    }, {
        type: type,
        animate: {
            enter: 'animated fadeInRight',
            exit: 'animated fadeOutRight'
        }
    });
}
