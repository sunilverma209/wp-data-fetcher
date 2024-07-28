jQuery( document ).ready(function ($) {

    $( '#refresh-data' ).on('click', function () {
        $.post(WpDataFetcher.ajax_url, {
            action: 'wp_data_fetcher_get_data',
            _ajax_nonce: WpDataFetcher.nonce
        }, function ( response ) {
            if ( response.success ) {

                var data = response.data;
                var title = data.title;
                var headers = data.data.headers;
                var rows = data.data.rows;

                var table = '<h2>' + title + '</h2>';
                table += '<table class="wp-list-table widefat fixed striped">';
                table += '<thead><tr>';

                headers.forEach(function (header) {
                    table += '<th>' + header + '</th>';
                });

                table += '</tr></thead><tbody>';

                for (var rowId in rows) {
                    var row = rows[rowId];
                    table += '<tr>';
                    for (var key in row) {
                        table += '<td>' + row[key] + '</td>';
                    }
                    table += '</tr>';
                }

                table += '</tbody></table>';
                $('#sv-data-fetcher__table').html(table);
            }
        });
    });
    
});
