'use strict';

import {library} from '@fortawesome/fontawesome-svg-core';

import {
    faChalkboardTeacher as fasChalkboardTeacher,
    faUser as fasUser,
    faUserCog as fasUserCog,
    faUserGraduate as fasUserGraduate,
} from '@fortawesome/free-solid-svg-icons';

import {faAddressCard as farAddressCard} from '@fortawesome/free-regular-svg-icons';

library.add(
    fasChalkboardTeacher,
    fasUser,
    fasUserGraduate,
    fasUserCog,
);

library.add(farAddressCard);