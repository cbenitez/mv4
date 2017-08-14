var mapperJs = {
    list: function( module ){
        $.ajax({
            url: window.location+'../system/async/list',
            data: 'module=' + module + '&task=list',
            type: 'POST',
            dataType: 'json',
            success: function( r ){
                if( r.status == '200' ){
                    $('#load_content').empty().html( r.list );
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
    action: function( task, pk ){

    },
    modal: function ( module, pk ) {
        $('#view_modal_content').empty();
        $('#view_modal_content').load( window.location + '../system/async/modal?module=' + module + '&pk=' + pk );
        $('#view_modal').modal( 'show' );
    }
}