import { useBlockProps } from '@wordpress/block-editor';

const Save = (props) => {
    const { attributes } = props;
    const { data, columns } = attributes;
    const blockProps = useBlockProps.save();

    return (
        <div {...blockProps}>
            <table>
                <thead>
                    <tr>
                        {columns.column1 && <th>Column 1</th>}
                        {columns.column2 && <th>Column 2</th>}
                        {columns.column3 && <th>Column 3</th>}
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

export default Save;
