<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_disabilitas
 * @subpackage Wp_disabilitas/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_disabilitas
 * @subpackage Wp_disabilitas/admin
 * @author     Bakti Negara <agusnurwantomuslim@gmail.com>
 */
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Wp_disabilitas_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	private $functions;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_disabilitas_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_disabilitas_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp_disabilitas-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_disabilitas_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_disabilitas_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'jszip', plugin_dir_url( __FILE__ ) . 'js/jszip.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'xlsx', plugin_dir_url( __FILE__ ) . 'js/xlsx.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp_disabilitas-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function crb_attach_disabilitas_options(){
		global $wpdb;

		$data_disabilitas = $this->functions->generatePage(array(
			'nama_page' => 'Data Disabilitas', 
			'content' => '[data_disabilitas]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));

		$statistik_disabilitas = $this->functions->generatePage(array(
			'nama_page' => 'Statistik Disabilitas', 
			'content' => '[statistik_disabilitas]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));

		$basic_options_container = Container::make( 'theme_options', __( 'Disabilitas Options' ) )
			->set_page_menu_position( 4 )
	        ->add_fields( array(
				Field::make( 'html', 'crb_disabilitas_halaman_terkait' )
		        	->set_html( '
					<h5>HALAMAN TERKAIT</h5>
	            	<ul>
	            		<li><a target="_blank" href="'.$data_disabilitas['url'].'">'.$data_disabilitas['title'].'</a></li>
	            		<li><a target="_blank" href="'.$statistik_disabilitas['url'].'">'.$statistik_disabilitas['title'].'</a></li>
	            	</ul>
		        	' ),
	            Field::make( 'text', 'crb_apikey_disabilitas', 'API KEY' )
	            	->set_default_value($this->functions->generateRandomString())
	            	->set_help_text('Wajib diisi. API KEY digunakan untuk integrasi data.'),
	            Field::make( 'text', 'crb_disabilitas_prop', 'Nama Provinsi' ),
	            Field::make( 'text', 'crb_disabilitas_kab', 'Nama Kabupaten' ),
	            Field::make( 'text', 'crb_disabilitas_kec', 'Nama Kecamatan' ),
	            Field::make( 'text', 'crb_disabilitas_captcha_public', 'Recaptcha public key' )
	            	->set_help_text('Bisa dilihat di <a href="https://www.google.com/recaptcha/admin/site/" target="_blank">https://www.google.com/recaptcha/admin/site/</a>.'),
	            Field::make( 'text', 'crb_disabilitas_captcha_private', 'Recaptcha private key' )
	            	->set_help_text('Bisa dilihat di <a href="https://www.google.com/recaptcha/admin/site/" target="_blank">https://www.google.com/recaptcha/admin/site/</a>.')
	        ) );

	    Container::make( 'theme_options', __( 'Import Data Excel Disabilitas' ) )
		    ->set_page_parent( $basic_options_container )
		    ->add_fields( array(
		    	Field::make( 'html', 'crb_disabilitas_hide_sidebar' )
		        	->set_html( '
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	' ),
		        Field::make( 'html', 'crb_disabilitas_upload_html' )
	            	->set_html( 'Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePicked(event);"><br>Contoh format file excel bisa <a target="_blank" href="'.plugin_dir_url( __FILE__ ) . 'excel/contoh.xlsx">download di sini</a>. Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.' ),
		        Field::make( 'html', 'crb_disabilitas_textarea_html' )
	            	->set_html( 'Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>' ),
		        Field::make( 'html', 'crb_disabilitas_save_button' )
	            	->set_html( '<a onclick="import_excel(); return false" href="javascript:void(0);" class="button button-primary">Import WP</a>' )
		    ) );
	}

	function import_excel_disabilitas(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);
		if (!empty($_POST)) {
			$ret['data'] = array();
			foreach ($_POST['data'] as $k => $data) {

			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

}
