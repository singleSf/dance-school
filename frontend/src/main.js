'use strict';

import CreateApp from 'sf-mvc-frontend';

import RouterRoute from './router/route';
import RouterUri   from './router/uri';

import './font-awesome-icon';

export default (async () => {
    const {app, router} = await CreateApp;

    router.addRouteList(RouterRoute);
    router.addUriList(RouterUri);

    app.run('#sf-mvc-frontend');
})();