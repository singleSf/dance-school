'use strict';

const path    = require('path');
const aliases = require('./alias.config');

const moduleNameMapper = {};
for (const [alias, path] of Object.entries(aliases)) {
    moduleNameMapper['^' + alias + '(.*)$'] = path + '$1';
}

module.exports = {
    preset              : 'ts-jest',
    globals             : {},
    testEnvironment     : 'jsdom',
    transform           : {
        '^.+\\.vue$': 'vue-jest',
        '^.+\\js$'  : 'babel-jest',
    },
    moduleFileExtensions: ['vue', 'js', 'json'],
    reporters           : [
        'default',
        [
            'jest-html-reporter',
            {
                pageTitle : 'Test Report Summary',
                outputPath: path.resolve(__dirname, './coverage/summary.html'),
            },
        ],
    ],
    moduleNameMapper,
    moduleDirectories   : [
        path.resolve(__dirname, './node_modules'),
    ],
};
