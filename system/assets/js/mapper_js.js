var mapperJs = {
    limit: 4,
    location: window.location,
    list: function ( module, name ) {
        var page = 1;
        var search = '';
        if ( $('#search').val() !== "" && $('#search').val() !== undefined ){
            search = $('#search').val();
        }
        if ( $( this ).data('position') !== null && $( this ).data('position') !== undefined ){
            page = $( this ).data('page');
        }
        $.ajax({
            url: this.location + 'system/async/list',
            data: 'module=' + module + '&name=' + name + '&task=list&search=' + search + '&limit=' + this.limit + '&page=' + page,
            type: 'POST',
            dataType: 'json',
            success: function (r) {
                if ( r.status == '200' ) {
                    $('#load_content').empty().html( r.result );
                    $('.pagination').empty().html( r.navigation );
                } else {
                    $('#load_content').empty().html(
                        '<div class="alert alert-' + r.type + '" role="alert">'
                        + r.message +
                        '</div >');
                }
            }
        });
    },
    action: function ( module, name, task, pk ) {
        $.ajax({
            url: this.location + 'system/async/' + task,
            data: 'module=' + module + '&name=' + name + '&task=' + task + '&pk=' + pk,
            type: 'POST',
            dataType: 'json',
            success: function (r) {
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
    save: function( module, name ){
        var data = new FormData();
        if ( $('input[type=file]').val() ){
            $.each( $('input[type=file]')[0].files, function( i, file ) {
                data.append( file.name, file );
            });
        }
        var other_data = $('form').serializeArray();
        $.each( other_data,function( key, input ){
            data.append( input.name, input.value );
        });
        $.ajax({
            url: this.location + 'system/async/save?module=' + module,
            type: "post",
            dataType: "json",
            data: data,
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function( r ){
            _notify(r.message, r.type);
            if ( r.status == '200' ){
                mapperJs.list( module, name );
            }
        });
    },
    modal: function ( module, pk ) {
        $('#view_modal_content').empty();
        $('#view_modal_content').load( this.location + 'system/async/modal?module=' + module + '&pk=' + pk );
        $('#view_modal').modal('show');
    }
};