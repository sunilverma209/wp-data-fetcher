import { registerBlockType, getBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { tableColumnAfter } from '@wordpress/icons';
import Edit from './edit';
import Save from './save';

if ( !getBlockType( 'sunil/data-fetcher-block' ) ) {
    registerBlockType( 'sunil/data-fetcher-block', {
        title: __( 'Data Fetcher', 'wp-data-fetcher' ),
        description: __('Block to display fetched data in a table', 'wp-data-fetcher'),
        icon: tableColumnAfter,
        category: 'widgets',
        attributes: {
            data: {
                type: 'array',
                default: []
            },
            columns: {
                type: 'object',
                default: {
                    column1: true,
                    column2: true,
                    column3: true
                }
            }
        },
        edit: Edit,
        save: Save
    });
}
