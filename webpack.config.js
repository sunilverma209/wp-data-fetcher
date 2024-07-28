const path = require('path');

module.exports = {
    entry: {
        block: './assets/js/block/index.js',
        admin: './assets/js/admin.js'
    },
    output: {
        path: path.resolve(__dirname, 'build'),
        filename: '[name].build.js',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env', '@babel/preset-react'],
                    },
                },
            },
        ],
    },
    externals: {
        react: 'React',
        'react-dom': 'ReactDOM',
        '@wordpress/blocks': ['wp', 'blocks'],
        '@wordpress/element': ['wp', 'element'],
        '@wordpress/block-editor': ['wp', 'blockEditor'],
        '@wordpress/dom-ready': ['wp', 'domReady'],
    },
};
