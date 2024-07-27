<?php
/**
 * Data Fetcher Interface.
 *
 * @package SUNIL\Plugins\WpDataFetcher\Interfaces
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher\Interfaces;

interface DataFetcherInterface {

    /**
     * Fetch data from the remote API.
     *
     * @return []
     */
    public function fetch();
}
