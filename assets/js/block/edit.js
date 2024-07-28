import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, CheckboxControl } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { data, columns, title } = attributes;
    const blockProps = useBlockProps();
    const [availableColumns, setAvailableColumns] = useState([]);
    const [columnMapping, setColumnMapping] = useState({});

    useEffect(() => {
        fetch(WpDataFetcher.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'wp_data_fetcher_get_data',
                _ajax_nonce: WpDataFetcher.nonce,
            }),
        })
            .then(response => response.json())
            .then(responseData => {
                if (responseData.success) {

                    const fetchedData = responseData.data.data.rows;
                    const headers = responseData.data.data.headers;
                    const fetchedTitle = responseData.data.title;

                    setAttributes({ data: fetchedData , title: fetchedTitle });

                    // Map headers to row keys
                    const mapping = {
                        'ID': 'id',
                        'First Name': 'fname',
                        'Last Name': 'lname',
                        'Email': 'email',
                        'Date': 'date'
                    };

                    setColumnMapping(mapping);

                    // Dynamically set available columns based on the fetched data headers
                    setAvailableColumns(headers);

                    // Initialize columns visibility if not already set
                    if ( Object.keys(columns).length === 0 ) {
                        const initialColumns = headers.reduce(( acc, col ) => {
                            acc[col] = true;
                            return acc;
                        }, {});
                        setAttributes({ columns: initialColumns });
                    }
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }, []);

    const toggleColumnVisibility = (column) => {
        const newColumns = { ...columns, [column]: !columns[column] };
        setAttributes({ columns: newColumns });
    };

    return (
        <div {...blockProps}>
            <InspectorControls>
                <PanelBody title={__('Column Visibility', 'wp-data-fetcher')}>
                    {availableColumns.map((col) => (
                        <CheckboxControl
                            key={col}
                            label={col}
                            checked={columns[col]}
                            onChange={() => toggleColumnVisibility(col)}
                        />
                    ))}
                </PanelBody>
            </InspectorControls>
            <div className='sv-data-fetcher-block'>
                <div className='sv-data-fetcher-block__inner'>
                    <h2>{ title ?? '' }</h2>
                    <table className='wp-list-table widefat fixed striped'>
                        <thead>
                            <tr>
                                {availableColumns.map((col) => columns[col] && <th key={col}>{col}</th>)}
                            </tr>
                        </thead>
                        <tbody>
                            {Object.keys(data).map((rowKey, rowIndex) => (
                                <tr key={rowIndex}>
                                    {availableColumns.map((col) => columns[col] && <td key={col}>{data[rowKey][columnMapping[col]]}</td>)}
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
};

export default Edit;
