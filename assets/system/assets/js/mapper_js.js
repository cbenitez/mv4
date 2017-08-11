var mapperJs = {
    list: function( module ){
        $.ajax({
            url: window.location+'../assets/system/async/list.async.php',
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

    }
}