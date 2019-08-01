<?php

namespace Carbon_Field_City_Selector;

use Carbon_Fields\Field\Field;
use Carbon_Fields\Value_Set\Value_Set;

class City_Selector_Field extends Field
{

	/**
	 * {@inheritDoc}
	 */
	protected $default_value = array(
		'province' => '',
		'city' => '',
		'district' => '',
	);

	/**
	 * Create a field from a certain type with the specified label.
	 *
	 * @param string $type  Field type
	 * @param string $name  Field name
	 * @param string $label Field label
	 */
	public function __construct($type, $name, $label)
	{
		$this->set_value_set(new Value_Set(Value_Set::TYPE_MULTIPLE_PROPERTIES, array('province' => '', 'city' => '', 'district' => '')));
		parent::__construct($type, $name, $label);
	}

	/**
	 * Prepare the field type for use
	 * Called once per field type when activated
	 */
	public static function field_type_activated()
	{
		$dir = \Carbon_Field_City_Selector\DIR . '/languages/';
		$locale = get_locale();
		$path = $dir . $locale . '.mo';
		load_textdomain('carbon-field-city-selector', $path);
	}

	/**
	 * Enqueue scripts and styles in admin
	 * Called once per field type
	 */
	public static function admin_enqueue_scripts()
	{
		$root_uri = \Carbon_Fields\Carbon_Fields::directory_to_url(\Carbon_Field_City_Selector\DIR);

		// Enqueue field styles.
		wp_enqueue_style(
			'carbon-field-city-selector',
			$root_uri . '/build/bundle' . ((defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min') . '.css'
		);

		// Enqueue field scripts.
		wp_enqueue_script(
			'carbon-field-city-selector',
			$root_uri . '/build/bundle' . ((defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min') . '.js',
			array('carbon-fields-core')
		);
	}

	/**
	 * Load the field value from an input array based on its name
	 *
	 * @param array $input Array of field names and values.
	 */
	public function set_value_from_input($input)
	{
		if (!isset($input[$this->get_name()])) {
			$this->set_value(null);
			return $this;
		}

		$value_set = array(
			'province' => '',
			'city' => '',
			'district' => '',
		);

		foreach ($value_set as $key => $v) {
			if (isset($input[$this->get_name()][$key])) {
				$value_set[$key] = $input[$this->get_name()][$key];
			}
		}

		$value_set['province'] = (string) $value_set['province'];
		$value_set['city'] = (string) $value_set['city'];
		$value_set['district'] = (string) $value_set['district'];

		$this->set_value($value_set);

		return $this;
	}

	/**
	 * Returns an array that holds the field data, suitable for JSON representation.
	 *
	 * @param bool $load  Should the value be loaded from the database or use the value from the current instance.
	 * @return array
	 */
	public function to_json($load)
	{
		$field_data = parent::to_json($load);
		$value_set = $this->get_value();

		$field_data = array_merge($field_data, array(
			'value' => array(
				'province' => $value_set['province'],
				'city' => $value_set['city'],
				'district' => $value_set['district'],
			),
		));

		return $field_data;
	}

	/**
	 * Set the coords and zoom of this field.
	 *
	 * @param  string $lat  Latitude
	 * @param  string $lng  Longitude
	 * @param  int    $zoom Zoom level
	 * @return $this
	 */
	public function set_position($province, $city, $district)
	{
		return $this->set_default_value(array_merge(
			$this->get_default_value(),
			array(
				'province' => $province,
				'city' => $city,
				'district' => $district,
			)
		));
	}
}
