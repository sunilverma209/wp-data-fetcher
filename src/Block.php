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

        register_block_type( 'sunil/data-fetcher-block', [
            'editor_script' => 'wp-data-fetcher-block',
            'editor_style' => 'wp-data-fetcher-block-editor',
            'style' => 'wp-data-fetcher-block',
            'render_callback' => [ $this, 'render_block' ],
            'attributes' => [
                'data' => [
                    'type' => 'array',
                    'default' => []
                ],
                'columns' => [
                    'type' => 'object',
                    'default' => []
                ],
                'title' => [
                    'type' => 'string',
                    'default' => ''
                ]
            ],
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
        $columns = $attributes['columns'];
        $data = get_transient( 'wp_data_fetcher_data' );

        if ( false === $data ) {
            return '<p>' . esc_html__( 'No data available.', 'wp-data-fetcher' ) . '</p>';
        }

        $mapping = [
            'ID' => 'id',
            'First Name' => 'fname',
            'Last Name' => 'lname',
            'Email' => 'email',
            'Date' => 'date',
        ];

        ob_start();
        echo '<div class="sv-data-fetcher-block">';
        echo '<div class="sv-data-fetcher-block__inner">';
        echo '<h2>' . esc_html( $attributes['title'] ) . '</h2>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr>';

        // Render headers based on visibility in block attributes
        foreach ( $data['data']['headers'] as $header ) {
            if ( isset( $columns[ $header ] ) && $columns[ $header ] ) {
                echo '<th>' . esc_html( $header ) . '</th>';
            }
        }
        echo '</tr></thead>';
        echo '<tbody>';

        // Render rows based on visibility of columns
        foreach ( $data['data']['rows'] as $item ) {
            echo '<tr>';
            foreach ( $data['data']['headers'] as $header ) {
                if ( isset( $columns[ $header ] ) && $columns[ $header ] ) {
                    $key = $mapping[$header] ?? null;
                    echo '<td>' . esc_html( $item[ $key ] ) . '</td>';
                }
            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';

        return ob_get_clean();
    }
}
