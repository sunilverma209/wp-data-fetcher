<?php
/**
 * Data Fetcher Service.
 *
 * @package SUNIL\Plugins\WpDataFetcher\Services
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher\Services;

use SUNIL\Plugins\WpDataFetcher\Interfaces\DataFetcherInterface;

class DataFetcher implements DataFetcherInterface {
    
    public function fetch() {
        $response = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );

        if ( is_wp_error( $response ) ) {
            return [];
        }

        $body = wp_remote_retrieve_body( $response );

        return json_decode( $body, true );
    }
}
