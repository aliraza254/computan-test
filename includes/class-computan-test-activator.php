<?php
/**
 * Fired during plugin activation
 *
 * @link       https://#
 * @since      1.0.0
 *
 * @package    Computan_Test
 * @subpackage Computan_Test/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Computan_Test
 * @subpackage Computan_Test/includes
 * @author     Sahib Bilal <itsbilalmahmood@gmail.com>
 */
class Computan_Test_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		wp_schedule_single_event( time(), 'trigger_cron_job' );
	}

}
