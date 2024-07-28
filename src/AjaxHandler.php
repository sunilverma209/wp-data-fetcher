<?php
/**
 * Ajax Handler
 *
 * @package SUNIL\Plugins\WpDataFetcher
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher;

use SUNIL\Plugins\WpDataFetcher\Interfaces\AjaxHandlerInterface;
use SUNIL\Plugins\WpDataFetcher\Services\Cache;
use SUNIL\Plugins\WpDataFetcher\Services\DataFetcher;

class AjaxHandler implements AjaxHandlerInterface {
    private $cache;
    private $dataFetcher;

    /**
     * Constructor to initialize the Ajax Handler.
     */
    public function __construct() {
        $this->cache = new Cache();
        $this->dataFetcher = new DataFetcher();
        
        add_action( 'wp_ajax_nopriv_wp_data_fetcher_get_data', [ $this, 'get_data' ] );
        add_action( 'wp_ajax_wp_data_fetcher_get_data', [ $this, 'get_data' ] );
        add_action( 'wp_data_fetcher_cron_hook', [ $this, 'fetch_and_cache_data' ] );
    }


    /**
     * Get data from the cache or fetch from the remote API if not available.
     *
     * @return void
     */    
    public function get_data() {
        $data = $this->cache->get( 'wp_data_fetcher_data' );

        if ( false === $data ) {
            $data = $this->dataFetcher->fetch();
            $this->cache->set( 'wp_data_fetcher_data', $data, HOUR_IN_SECONDS );
        }

        wp_send_json_success( $data );
    }


    /**
     * Fetch data from the remote API and cache it.
     *
     * @return void
     */    
    public function fetch_and_cache_data() {
        $data = $this->dataFetcher->fetch();
        $this->cache->set( 'wp_data_fetcher_data', $data, HOUR_IN_SECONDS );
    }
}
