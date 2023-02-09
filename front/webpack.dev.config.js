const path = require('path');
//const TerserPlugin = require('terser-webpack-plugin'); //compress js et css size (installed by default on prod mode)
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const HtmlWebpackPlugin  = require('html-webpack-plugin')
const { ModuleFederationPlugin } = require('webpack').container

module.exports = {
    entry: './src/dashboard.js',
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, "./dist"),
        publicPath: 'http://localhost:9000/',
        // this option can be use instead of cleanWebpackPlugin (from version 5 of webpack), be sure that the plugin declaration is removed then
        clean: {
            dry: true,
            keep: '\.jpg$'
        }
    },
    mode: 'development',
    devServer: {
        port: 9000,
        static: {
            directory: path.resolve(__dirname, "./dist")
        },
        devMiddleware: {
            index: 'dashboard.html',
            writeToDisk: true,
        },
        historyApiFallback: {
            index: 'dashboard.html' /*always return this file*/
        }
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: '/node_modules',
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/env'],
                    }
                }              
            },
            {
                test: /\.scss$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ]
            },
        ]
    },
    plugins: [
        //new TerserPlugin(),
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: [
                '**/*',
                path.join(process.cwd(), 'build/**/*')
            ]
        }),
        new HtmlWebpackPlugin(
            {
                title: 'Dashboard kiwi',
                filename: 'dashboard.html',
            }
        ),
        new ModuleFederationPlugin({
            name: 'App',
            filename: 'remoteEntry.js'
        })
    ]
}