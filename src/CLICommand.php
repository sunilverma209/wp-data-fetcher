<?php
/**
 * CLI Command Setup.
 *
 * @package SUNIL\Plugins\WpDataFetcher
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher;

use WP_CLI;

class CLICommand {
    /**
     * Constructor to register the CLI command.
     */
    public function __construct() {

        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            \WP_CLI::add_command( 'wp-data-fetcher-refresh', [ $this, 'refresh_data' ] );
        } else {
            error_log('WP_CLI is not defined or not available');
        }
    }

    /**
     * Refresh data by clearing the cache.
     *
     * @return void
     */
    public function refresh_data() {
        delete_transient( 'wp_data_fetcher_data' );
        WP_CLI::success( 'Data cache cleared.' );
    }
}
