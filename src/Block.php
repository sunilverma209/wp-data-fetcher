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

        wp_register_script(
            'wp-data-fetcher-block',
            WP_DATA_FETCHER_PLUGIN_URL . 'build/block.build.js',
            [ 'wp-blocks', 'wp-element', 'wp-editor' ],
            WP_DATA_FETCHER_VERSION,
            true
        );

        wp_register_style(
            'wp-data-fetcher-block-editor',
            WP_DATA_FETCHER_PLUGIN_URL . 'build/block.editor.build.css',
            [ 'wp-edit-blocks' ],
            WP_DATA_FETCHER_VERSION
        );

        wp_register_style(
            'wp-data-fetcher-block',
            WP_DATA_FETCHER_PLUGIN_URL . 'build/block.style.build.css',
            [ 'wp-blocks' ],
            WP_DATA_FETCHER_VERSION
        );

        register_block_type('sunil/data-fetcher-block', [
            'editor_script' => 'wp-data-fetcher-block',
            'editor_style' => 'wp-data-fetcher-block-editor',
            'style' => 'wp-data-fetcher-block',
        ]);
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
