import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, CheckboxControl } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { data, columns } = attributes;
    const blockProps = useBlockProps();
    
    useEffect(() => {
        // Fetch data from the AJAX endpoint
        fetch( '/wp-json/sunil/data-fetcher/v1/get-data')
            .then(response => response.json())
            .then(fetchedData => setAttributes({ data: fetchedData }))
            .catch(error => console.error('Error fetching data:', error));
    }, []);
    
    return (
        <div {...blockProps}>
            <InspectorControls>
                <PanelBody title={__('Column Visibility', 'wp-data-fetcher')}>
                    <CheckboxControl
                        label={__('Column 1', 'wp-data-fetcher')}
                        checked={columns.column1}
                        onChange={(value) => setAttributes({ columns: { ...columns, column1: value } })}
                    />
                    <CheckboxControl
                        label={__('Column 2', 'wp-data-fetcher')}
                        checked={columns.column2}
                        onChange={(value) => setAttributes({ columns: { ...columns, column2: value } })}
                    />
                    <CheckboxControl
                        label={__('Column 3', 'wp-data-fetcher')}
                        checked={columns.column3}
                        onChange={(value) => setAttributes({ columns: { ...columns, column3: value } })}
                    />
                </PanelBody>
            </InspectorControls>
            <table>
                <thead>
                    <tr>
                        {columns.column1 && <th>{__('Column 1', 'wp-data-fetcher')}</th>}
                        {columns.column2 && <th>{__('Column 2', 'wp-data-fetcher')}</th>}
                        {columns.column3 && <th>{__('Column 3', 'wp-data-fetcher')}</th>}
                    </tr>
                </thead>
                <tbody>
                    {data.map((row, index) => (
                        <tr key={index}>
                            {columns.column1 && <td>{row.column1}</td>}
                            {columns.column2 && <td>{row.column2}</td>}
                            {columns.column3 && <td>{row.column3}</td>}
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default Edit;
