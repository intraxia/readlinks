const path = require('path');
const WebpackNotifierPlugin = require('webpack-notifier');
const src = path.join(__dirname, '..', 'src', 'js');
const client = path.join(__dirname, 'client');

module.exports = {
    devtool: 'sourcemap',
    entry: {
        readlinks: path.join(client, 'app.js')
    },
    output: {
        path: path.join(__dirname, 'assets'),
        filename: '[name].js'
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                loader: 'eslint-loader',
                exclude: /(node_modules)/,
                enforce: 'pre'
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /(node_modules)/
            },
            {
                test: /\.hbs/,
                loader: 'handlebars-loader',
                query: {
                    helperDirs: [path.join(client, 'helpers')],
                    partialDirs: [client],
                    preventIndent: true,
                    compat: true
                }
            },
            {
                test: /\.(less|css)$/,
                loaders: ['style-loader', 'css-loader?-url', 'less-loader']
            }
        ]
    },
    resolve: {
        mainFields: ['jsnext:main', 'module', 'browser', 'main']
    },
    plugins: [
        new WebpackNotifierPlugin({ alwaysNotify: true })
    ]
};
