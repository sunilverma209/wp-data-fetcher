<?php
/**
 * Gutenberg Block Setup.
 *
 * @package SUNIL\Plugins\WpDataFetcher
 */

declare( strict_types=1 );

namespace SUNIL\Plugins\WpDataFetcher;

class Block {
    /**
     * Constructor to initialize the Gutenberg Block.
     */
    public function __construct() {
        add_action( 'init', [ $this, 'register_block' ] );
        add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_assets' ] );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_assets' ] );
    }

    /**
     * Register the Gutenberg block.
     *
     * @return void
     */
    public function register_block() {
        
        if ( ! function_exists( 'register_block_type' ) ) {
            return;
        }

        register_block_type('sunil/data-fetcher-block', [
            'editor_script' => 'wp-data-fetcher-block',
            'editor_style' => 'wp-data-fetcher-block-editor',
            'style' => 'wp-data-fetcher-block',
        ]);
    }

    /**
	 * Enqueue Frontend Assets
	 *
	 * @return void
	 */
	public function enqueue_assets(): void {

        wp_enqueue_script(
            'wp-data-fetcher-block',
            WP_DATA_FETCHER_PLUGIN_URL . 'build/block.build.js',
            [ 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components' ],
            WP_DATA_FETCHER_VERSION,
            true
        );

        wp_enqueue_style (
            'wp-data-fetcher-block-style',
            WP_DATA_FETCHER_PLUGIN_URL . 'build/build.block.css',
            [],
            WP_DATA_FETCHER_VERSION
        );
	}

    /**
     * Render the Gutenberg block content.
     *
     * @param array $attributes Block attributes.
     *
     * @return string
     */
    public function render_block( $attributes ) {
        $data = get_transient( 'wp_data_fetcher_data' );

        if ( false === $data ) {
            return '<p>' . esc_html__( 'No data available.', 'wp-data-fetcher' ) . '</p>';
        }

        ob_start();
        echo '<table>';
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

        return ob_get_clean();
    }
}
