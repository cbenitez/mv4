var mapperJs = {
    location: window.location,
    list: function( module ){
        $.ajax({
            url: this.location + 'system/async/list',
            data: 'module=' + module + '&task=list',
            type: 'POST',
            dataType: 'json',
            success: function( r ){
                if( r.status == '200' ){
                    $('#load_content').empty().html( r.result );
                }else{
                    $('#load_content').empty().html(
                        '<div class="alert alert-' + r.type + '" role="alert">'
                        + r.message +
                    '</div >');
                }
            }
        });
    },
    paginate: function(){

    },
    action: function ( module, task, pk ){
        $.ajax({
            url: this.location + 'system/async/' + task,
            data: 'module=' + module + '&task=' + task + '&pk=' + pk,
            type: 'POST',
            dataType: 'json',
            success: function ( r ) {
                if ( r.status == '200' ) {
                    $('#load_content').empty().html( r.result );
                } else {
                    $('#load_content').empty().html(
                        '<div class="alert alert-' + r.type + '" role="alert">'
                        + r.message +
                    '</div >');
                }
            }
        });
    },
    modal: function ( module, pk ) {
        $('#view_modal_content').empty();
        $('#view_modal_content').load( this.location + 'system/async/modal?module=' + module + '&pk=' + pk );
        $('#view_modal').modal( 'show' );
    }
};