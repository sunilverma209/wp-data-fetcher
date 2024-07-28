jQuery( document ).ready( function( $ ) {
    console.log('ready2');
    $( '#refresh-data' ).on( 'click', function() {
        console.log('hit455');

        $.post( WpDataFetcher.ajax_url, {
            action: 'my_data_fetcher_get_data',
            _ajax_nonce: WpDataFetcher.nonce
        }, function( response ) {
            if ( response.success ) {

                var data = response.data;

                var table = '<table class="wp-list-table widefat fixed striped">';
                table += '<thead><tr>';


                for ( var key in data[0] ) {
                    table += '<th>' + key + '</th>';
                }


                table += '</tr></thead><tbody>';
                data.forEach( function( row ) {
                    table += '<tr>';
                    for ( var key in row ) {
                        table += '<td>' + row[key] + '</td>';
                    }
                    table += '</tr>';
                } );
                table += '</tbody></table>';
                $( '#data-table' ).html( table );
            }
            
        } );
    } );

} );
