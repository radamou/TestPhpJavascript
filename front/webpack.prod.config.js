const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin') // extract css in another bundle
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const HtmlWebpackPlugin  = require('html-webpack-plugin')
const { ModuleFederationPlugin } = require('webpack').container

module.exports = {
    entry: './src/dashboard.js',
    output: {
        filename: '[name].[contenthash].js',
        path: path.resolve(__dirname, "./dist"),
        publicPath: 'http://localhost:9000/',
        // this option can be use instead of cleanWebpackPlugin (from version 5 of webpack), be sure that the plugin declaration is removed then
        clean: {
            dry: true,
            keep: '\.jpg$'
        }
    },
    mode: 'production',
    optimization: {
        splitChunks: {
            chunks: 'all', //extract common library from application code,
            minSize: 3000
        }
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /\.js$/,
                exclude: '/node_modules',
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/env']                    
                    }
                }              
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].[contenthash].css'
        }),
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
        )
    ]
}