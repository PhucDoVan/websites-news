<?php

if ( ! function_exists('format_date')) {

    /**
     * Format a date
     *
     * @param null $date
     * @param string $format
     * @return string
     */
    function format_date($date = null, $format = DATE_FORMAT_Y_M_D)
    {
        if (is_null($date) || empty($date)) {
            return "";
        }
        return date($format, strtotime($date));
    }

}

if ( ! function_exists('sort_info')) {

    /**
     * Get last updated of record
     *
     * @param $column
     * @param $sort_column
     * @param $sort_direction
     * @return string
     */
    function sort_info($column, $sort_column, $sort_direction)
    {
        return 'class=sorting' . ($column === $sort_column ? ($sort_direction === 'asc' ? '_desc' : '_asc') : '')
            . ' aria-field=' . $column . ' aria-sort=' . (($column === $sort_column && $sort_direction === 'asc') ? 'desc' : 'asc');
    }

}

if ( ! function_exists('get_address')) {

    /**
     * Get address
     *
     * @param $postalCode
     * @param $pref
     * @param $city
     * @param $town
     * @param $building
     * @return string
     */
    function get_address($postalCode, $pref, $city, $town, $building)
    {
        $address = [];
        if ( ! empty($postalCode)) {
            $postalCode = substr_replace($postalCode, '-', 3, 0);
            $address[]   = '〒' . $postalCode;
        }
        $address[] = $pref . $city . $town;
        if ( ! empty($building)) {
            $address[] = $building;
        }
        return implode(' ', $address);
    }

}

if ( ! function_exists('get_contact')) {

    /**
     * Get contact information
     *
     * @param $tel
     * @param $fax
     * @return string
     */
    function get_contact($tel, $fax)
    {
        $contact = '';
        if ( ! empty($tel)) {
            $contact = 'TEL：' . $tel;
        }
        if ( ! empty($fax)) {
            if ( ! empty($contact)) {
                $contact .= ' / ';
            }
            $contact .= 'FAX：' . $fax;
        }
        return $contact;
    }

}
