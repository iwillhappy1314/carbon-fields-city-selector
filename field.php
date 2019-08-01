<?php
use Carbon_Fields\Carbon_Fields;
use Carbon_Field_City_Selector\City_Selector_Field;

define( 'Carbon_Field_City_Selector\\DIR', __DIR__ );

Carbon_Fields::extend( City_Selector_Field::class, function( $container ) {
	return new City_Selector_Field( $container['arguments']['type'], $container['arguments']['name'], $container['arguments']['label'] );
} );