import path from 'path';
import merge from 'webpack-merge';
import WebpackNotifierPlugin from "webpack-notifier";

export const dir = 'client';

const client = path.join(__dirname, dir);

/**
 * Mocha testing configuration.
 */
export const mocha = {
    reporter: 'spec',
    ui: 'bdd',
    requires: []
};

/**
 * Webpack build configuration.
 */
export const webpack = {
    entry: {
        readlinks: 'app.js'
    },
    output: {
        path: 'assets/',
        filename: '[name].js'
    },
    modifier: (config, state) => merge(config, {
        output: {
            filename: state.command.opts.env === 'production' ? '[name].min.js' : config.output.filename
        },
        module: {
            rules: [
                {
                    test: /\.(less|css)$/,
                    loaders: ['style-loader', 'css-loader?-url', 'less-loader']
                }
            ]
        },
        plugins: [
            new WebpackNotifierPlugin({ alwaysNotify: true })
        ]
    })
};

/**
 * Storybook development environment configuration.
 *
 * This will use the webpack configuration defined above.
 */
export const storybook = {
    port: 9001,
    host: null,
    staticDirs: [],
    https: {
        enabled: false
    },
    devServer: {},
    middleware: (router, state) => router
};
