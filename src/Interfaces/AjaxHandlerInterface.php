<?php
/**
 * Ajax Handler Interface.
 *
 * @package SUNIL\Plugins\WpDataFetcher\Interfaces
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher\Interfaces;

interface AjaxHandlerInterface {

    /**
     * Get data from the cache or fetch from the remote API if not available.
     *
     * @return void
     */
    public function get_data();


    /**
     * Fetch data from the remote API and cache it.
     *
     * @return void
     */    
    public function fetch_and_cache_data();
}
