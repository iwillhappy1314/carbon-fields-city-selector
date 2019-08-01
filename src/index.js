/**
 * External dependencies.
 */
import { registerFieldType } from '@carbon-fields/core';

/**
 * Internal dependencies.
 */
//import './style.scss';
import CitySelectorField from './main';

registerFieldType( 'city_selector', CitySelectorField );
