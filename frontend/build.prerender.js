'use strict';

const path               = require('path');
const prerenderSpaPlugin = require('prerender-spa-plugin');

const command = 'build:prerender';

module.exports = (_api, _options) => {
    _api.registerCommand(command, async () => {
        _api.chainWebpack((_config) => {
            const staticDir = path.resolve(__dirname, _options.outputDir);
            const outputDir = path.resolve(staticDir, 'prerender');
            const routes    = [
                '/',
            ];


            _config
                .plugin('prerender')
                .use(new prerenderSpaPlugin({
                    staticDir,
                    outputDir,
                    routes,
                    renderer: new prerenderSpaPlugin.PuppeteerRenderer({
                        renderAfterDocumentEvent: process.env.USER_CONFIG_PRERENDER_DOCOMENT_EVENT,
                    }),
                }));
        });

        await _api.service.run('build');
    });
};

module.exports.defaultModes = {
    [command]: 'production',
};