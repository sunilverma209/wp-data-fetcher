<?php
/**
 * Cache Interface.
 *
 * @package SUNIL\Plugins\WpDataFetcher\Interfaces
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher\Interfaces;

interface CacheInterface {

    /**
     * Get the cached data.
     *
     * @param string $key Cache key.
     *
     * @return mixed
     */
    public function get( string $key );


    /**
     * Set the cached data.
     *
     * @param string $key       Cache key.
     * @param mixed  $value     Data to cache.
     * @param int    $expiration Expiration time in seconds.
     *
     * @return void
     */    
    public function set( string $key, mixed $value, int $expiration );
}
