import { useBlockProps } from '@wordpress/block-editor';

const Save = (props) => {
    const { attributes } = props;
    const { data, columns, title } = attributes;
    const blockProps = useBlockProps.save();

    const availableColumns = Object.keys(columns).filter(col => columns[col]);

    const columnMapping = {
        'ID': 'id',
        'First Name': 'fname',
        'Last Name': 'lname',
        'Email': 'email',
        'Date': 'date'
    };

    return (
        <div {...blockProps}>
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

export default Save;
