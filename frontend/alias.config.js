'use strict';

const path = require('path');

module.exports = {
    '@@root'     : path.resolve(__dirname, './node_modules/sf-mvc-frontend/src'),
    '@root'      : path.resolve(__dirname, './src'),
    '@@component': path.resolve(__dirname, './node_modules/sf-mvc-frontend/src/component'),
    '@component' : path.resolve(__dirname, './src/component'),
    '@@service'  : path.resolve(__dirname, './node_modules/sf-mvc-frontend/src/service'),
    '@service'   : path.resolve(__dirname, './src/service'),
    '@@storage'  : path.resolve(__dirname, './node_modules/sf-mvc-frontend/src/storage'),
    '@storage'   : path.resolve(__dirname, './src/storage'),
    '@@util'     : path.resolve(__dirname, './node_modules/sf-mvc-frontend/src/util'),
    '@util'      : path.resolve(__dirname, './src/util'),
};