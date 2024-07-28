<?php
/**
 * Admin Page Setup.
 *
 * @package SUNIL\Plugins\WpDataFetcher\Admin
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher\Admin;

use SUNIL\Plugins\WpDataFetcher\Services\Cache;

class AdminPage {
    private $cache;

    /**
     * Constructor to initialize the Admin Page.
     */
    public function __construct() {
        $this->cache = new Cache();
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Add admin menu for the plugin.
     *
     * @return void
     */
    public function add_admin_menu() {
        add_menu_page(
            __( 'Data Fetcher', 'wp-data-fetcher' ),
            __( 'Data Fetcher', 'wp-data-fetcher' ),
            'manage_options',
            'wp-data-fetcher',
            [ $this, 'render_admin_page' ],
            'dashicons-chart-line'
        );
    }

    /**
     * Enqueue admin scripts.
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_script(
            'wp-data-fetcher-admin-script',
            WP_DATA_FETCHER_PLUGIN_URL . 'build/admin.build.js',
            [ 'jquery' ],
            WP_DATA_FETCHER_VERSION,
            true
        );

        wp_localize_script( 'wp-data-fetcher-admin-script', 'WpDataFetcher', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'wp_data_fetcher_nonce' ),
        ] );
    }

    /**
     * Render the admin page content.
     *
     * @return void
     */
    public function render_admin_page() {
        $data = $this->cache->get( 'wp_data_fetcher_data' );
    
        if ( false === $data ) {
            $data = [];
        }
    
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__( 'Data Fetcher', 'wp-data-fetcher' ) . '</h1>';
        echo '<div id="data-table">';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>';
        echo '<th>' . esc_html__( 'Column 1', 'wp-data-fetcher' ) . '</th>';
        echo '<th>' . esc_html__( 'Column 2', 'wp-data-fetcher' ) . '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ( $data as $item ) {
            echo '<tr>';
            echo '<td>' . esc_html( $item['column1'] ) . '</td>';
            echo '<td>' . esc_html( $item['column2'] ) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '<button id="refresh-data" class="button button-primary">' . esc_html__( 'Refresh Data', 'wp-data-fetcher' ) . '</button>';
        echo '</div>';
    }
    
}
