/**
 * External dependencies.
 */
import { Component, Fragment } from '@wordpress/element';
import CityPicker from 'react-city-picker';
import data from '../node_modules/china-area-data/data';

class CitySelectorField extends Component {
  /**
   * Handles the change of the input.
   *
   * @return {void}
   * @param location
   */
  handleChange = (location) => {
    const { id, value, onChange, } = this.props;

    onChange(id, {
      ...value,
      ...location
    });
  };


  /**
   * Render a number input field.
   *
   * @return {Object}
   */
  render() {
    const { id, name, value, } = this.props;


    return (
      <Fragment>
        <CityPicker
          id={id}
          name={name}
          value={value}
          source={data}
          selectedProvince={value.province}
          selectedCity={value.city}
          selectedDistrict={value.district}
          noDistrict
          onOptionChange={this.handleChange} />

        <input
          type="hidden"
          name={`${name}[province]`}
          value={value.province}
        />

        <input
          type="hidden"
          name={`${name}[city]`}
          value={value.city}
          readOnly
        />

        <input
          type="hidden"
          name={`${name}[district]`}
          value={value.district}
          readOnly
        />
      </Fragment >
    );
  }
}

export default CitySelectorField;
