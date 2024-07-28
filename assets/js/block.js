import { postList } from '@wordpress/icons';
import { registerBlockType, getBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

import DataFetcherEdit from './edit';
import DataFetcherSave from './save';

if ( ! getBlockType( 'cshr/card' ) ) {
	registerBlockType( 'cshr/card', {
		title: __( 'Data Fetcher' ),
		description: __( 'Card block with flexiblity of title, description' ),
		icon: postList,
		category: 'cshr',
		apiVersion: 3,
		edit: CardEdit,
		save: CardSave,
		supports: {
			align: [ 'full' ],
			spacing: {
				padding: true,
			},
			color: {
				background: true,
				text: true,
			},
		},
	} );
}
