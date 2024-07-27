<?php
/**
 * Cache Service.
 *
 * @package SUNIL\Plugins\WpDataFetcher\Services
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher\Services;

use SUNIL\Plugins\WpDataFetcher\Interfaces\CacheInterface;

class Cache implements CacheInterface {

    /**
     * Get the cached data.
     *
     * @param string $key Cache key.
     *
     * @return mixed
     */
    public function get( string $key ) {
        return get_transient( $key );
    }

    /**
     * Set the cached data.
     *
     * @param string $key       Cache key.
     * @param mixed  $value     Data to cache.
     * @param int    $expiration Expiration time in seconds.
     *
     * @return void
     */
    public function set( string $key, mixed $value, int $expiration ) {
        set_transient( $key, $value, $expiration );
    }
}
