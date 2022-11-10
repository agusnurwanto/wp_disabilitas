<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_disabilitas
 * @subpackage Wp_disabilitas/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_disabilitas
 * @subpackage Wp_disabilitas/includes
 * @author     Bakti Negara <agusnurwantomuslim@gmail.com>
 */
class Wp_disabilitas_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $path = WP_DISABILITAS_PLUGIN_PATH.'/tabel.sql';
        $sql = file_get_contents($path);
        dbDelta($sql);
	}

}
