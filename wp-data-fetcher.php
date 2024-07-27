<?php
/**
 * Plugin Name: Data Fetcher - API Based
 * Description: A plugin to fetch data from a remote API and display it in a custom Gutenberg block and admin page.
 * Version: 1.0.0
 * Author: Sunil Verma
 * Author URI: https://sunilverma.co.uk/
 * Text Domain: wp-data-fetcher
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

require_once __DIR__ . '/vendor/autoload.php';

use SUNIL\Plugins\WpDataFetcher\Admin\AdminPage;
use SUNIL\Plugins\WpDataFetcher\AjaxHandler;

// Define plugin constants
define( 'API_DATA_FETCHER_VERSION', '1.0.0' );
define( 'API_DATA_FETCHER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'API_DATA_FETCHER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'API_DATA_FETCHER_REMOTE_URL', 'https://miusage.com/v1/challenge/1/' );

/**
 * Class DataFetcher
 * 
 * This class is used to intialise all the main handlers
 */
class DataFetcher {

    /**
     * Constructor to initialize the plugin.
     */
    public function __construct() {
        $this->initialize();
    }

    /**
     * Initialize the plugin components.
     *
     * @return void
     */
    private function initialize() {
         new AjaxHandler();
    }
}

/**
 * Initialize the plugin.
 */
new DataFetcher();
