'use strict';

const path               = require('path');
const dotEnvWebPack      = require('dotenv-webpack');
const bundleAnalyzer     = require('webpack-bundle-analyzer');
const linterJsPlugin     = require('eslint-webpack-plugin');
const lingerPugPlugin    = require('./node_modules/sf-mvc-frontend/plugin/linter/pug');
const linterStylusPlugin = require('./node_modules/sf-mvc-frontend/plugin/linter/stylus');
const aliases            = require('./alias.config');

const configPluginDotEnv = (_config) => {
    _config.plugin('dotenv-webpack')
           .use(new dotEnvWebPack({
               path            : path.resolve(__dirname, '.env'),
               expand          : false,
               safe            : true,
               allowEmptyValues: false,
               systemvars      : true,
               silent          : false,
               defaults        : false,
           }));
};

const configAliases = (_config) => {
    // _config.resolve.alias.parent.alias.store.delete('@');
    // _config.resolve.alias.parent.alias.store.delete('@@');
    for (const [_alias, _path] of Object.entries(aliases)) {
        _config.resolve.alias.parent.alias.store.set(_alias, _path);
    }
};

const configPluginPrefetch = (_config) => {
    _config.plugins.delete('prefetch');
};

const configRuleImages = (_config) => {
    _config.module
           .rule('images')
           .use('url-loader')
           .loader('url-loader')
           .tap((_options) => {
               _options.limit = 1024 * 10;

               return _options;
           });
};

const configStylusVariables = (_config) => {
    const types = ['vue-modules', 'vue', 'normal-modules', 'normal'];
    types.forEach((_type) => {
        const rule = _config.module.rule('stylus').oneOf(_type);
        rule.use('style-resource')
            .loader('style-resources-loader')
            .options({
                patterns: [
                    path.resolve(__dirname, './node_modules/sf-mvc-frontend/src/style/media-query.styl'),
                    path.resolve(__dirname, './node_modules/sf-mvc-frontend/src/style/mixin/*.styl'),
                ],
            });
    });
};

const configPluginHtml = (_config) => {
    _config
        .plugin('html')
        .tap((_options) => {
            _options[0].template = path.resolve(__dirname, './src/index.html');
            // _options[0].title = 'test';

            return _options;
        });
};

const configPluginAnalyzer = (_config) => {
    if (process.env.NODE_ENV === 'production') {
        _config.plugin('webpack-bundle-analyzer')
               .use(new bundleAnalyzer.BundleAnalyzerPlugin({
                   analyzerMode  : 'static',
                   reportFilename: path.resolve(__dirname, './analyze/index.html'),
                   openAnalyzer  : false,
               }));
    }
};

const configPluginLinterJs = (_config) => {
    _config.plugin('eslint-webpack-plugin')
           .use(new linterJsPlugin({
               context   : path.resolve(__dirname, './src'),
               extensions: ['js', 'vue'],
               // lintDirtyModulesOnly: true,
           }));
};

const configPluginLinterStyle = (_config) => {
    _config.plugin('stylus-lint-webpack-plugin')
           .use(new linterStylusPlugin({
               files     : path.resolve(__dirname, './src/component'),
               exclude   : path.resolve(__dirname, './node_modules'),
               extensions: ['styl', 'vue'],
           }));
};

const configPluginLinterPug = (_config) => {
    _config.plugin('puglint-webpack-plugin')
           .use(new lingerPugPlugin({
               configFile: path.resolve(__dirname, '.pug-lintrc.js'),
               context   : path.resolve(__dirname, './src'),
               exclude   : path.resolve(__dirname, './node_modules'),
               extensions: ['vue'],
           }));
};
// todo SF prod exclude dir

module.exports = {
    filenameHashing: false,
    chainWebpack   : (_config) => {
        configPluginDotEnv(_config);
        configAliases(_config);
        configPluginPrefetch(_config);
        configRuleImages(_config);
        configStylusVariables(_config);
        configPluginHtml(_config);
        configPluginAnalyzer(_config);
        configPluginLinterJs(_config);
        configPluginLinterStyle(_config);
        configPluginLinterPug(_config);
    },
    // configureWebpack: {
    //     optimization: {
    //         runtimeChunk: 'single',
    //         splitChunks : {
    //             chunks            : 'all',
    //             maxInitialRequests: Number.POSITIVE_INFINITY,
    //             minSize           : 12000,
    //             maxSize           : 250000,
    //             cacheGroups       : {
    //                 vendor: {
    //                     test              : /[\\/]node_modules[\\/]/,
    //                     name(module) {
    //                         const packageName = module.context.match(/[\\/]node_modules[\\/](.*?)([\\/]|$)/)[1];
    //
    //                         return `npm.${packageName.replace('@', '')}`;
    //                     },
    //                     priority          : -20,
    //                     chunks            : 'initial',
    //                     minChunks         : 2,
    //                     reuseExistingChunk: true,
    //                     enforce           : true,
    //                 },
    //             },
    //         },
    //     },
    // },
};