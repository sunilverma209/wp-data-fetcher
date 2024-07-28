import { useBlockProps } from '@wordpress/block-editor';

const Save = (props) => {
    const { attributes } = props;
    const { data, columns } = attributes;
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
            <table>
                <thead>
                    <tr>
                        {availableColumns.map((col) => <th key={col}>{col}</th>)}
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
    );
};

export default Save;
