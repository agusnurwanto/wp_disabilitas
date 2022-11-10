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

		$sql_migrate = $this->functions->generatePage(array(
			'nama_page' => 'Monitoring SQL migrate WP Disabilitas', 
			'content' => '[monitoring_sql_migrate_disabilitas]',
        	'show_header' => 1,
        	'no_key' => 1
		));

		$basic_options_container = Container::make( 'theme_options', __( 'Disabilitas Options' ) )
			->set_page_menu_position( 4 )
	        ->add_fields( array(
				Field::make( 'html', 'crb_disabilitas_halaman_terkait' )
		        	->set_html( '
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="'.$data_disabilitas['url'].'">'.$data_disabilitas['title'].'</a></li>
	            		<li><a target="_blank" href="'.$statistik_disabilitas['url'].'">'.$statistik_disabilitas['title'].'</a></li>
	            		<li><a target="_blank" href="'.$sql_migrate['url'].'">SQL Migrate'.$sql_migrate['title'].'</a></li>
	            	</ol>
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
			$ret['data'] = array(
				'insert' => 0, 
				'update' => 0,
				'error' => array()
			);
			foreach ($_POST['data'] as $k => $data) {
				$newData = array();
				foreach($data as $kk => $vv){
					$newData[trim($kk)] = $vv;
				}
				$data_db = array(
					'nama' => $newData['nama'],
					'gender' => $newData['gender'],
					'tempat_lahir' => $newData['tempat_lahir'],
					'tanggal_lahir' => $newData['tanggal_lahir'],
					'status' => $newData['status'],
					'dokumen_kewarganegaraan' => $newData['dokumen_kewarganegaraan'],
					'nik' => $newData['nik'],
					'nomor_kk' => $newData['nomor_kk'],
					'rt_rw' => $newData['rt_rw'],
					'desa' => $newData['desa'],
					'no_hp' => $newData['no_hp'],
					'pendidikan_terakhir' => $newData['pendidikan_terakhir'],
					'nama_sekolah' => $newData['nama_sekolah'],
					'keterangan_lulus' => $newData['keterangan_lulus'],
					'jenis_disabilitas' => $newData['jenis_disabilitas'],
					'keterangan_disabilitas' => $newData['keterangan_disabilitas'],
					'sebab_disabilitas' => $newData['sebab_disabilitas'],
					'diagnosa_medis' => $newData['diagnosa_medis'],
					'penyakit_lain' => $newData['penyakit_lain'],
					'tempat_pengobatan' => $newData['tempat_pengobatan'],
					'perawat' => $newData['perawat'],
					'aktivitas' => $newData['aktivitas'],
					'aktivitas_bantuan' => $newData['aktivitas_bantuan'],
					'perlu_bantu' => $newData['perlu_bantu'],
					'alat_bantu' => $newData['alat_bantu'],
					'alat_yang_dimiliki' => $newData['alat_yang_dimiliki'],
					'kondisi_alat' => $newData['kondisi_alat'],
					'jaminan_kesehatan' => $newData['jaminan_kesehatan'],
					'cara_menggunakan_jamkes' => $newData['cara_menggunakan_jamkes'],
					'jaminan_sosial' => $newData['jaminan_sosial'],
					'pekerjaan' => $newData['pekerjaan'],
					'lokasi_bekerja' => $newData['lokasi_bekerja'],
					'alasan_tidak_bekerja' => $newData['alasan_tidak_bekerja'],
					'pendapatan_bulan' => $newData['pendapatan_bulan'],
					'pengeluaran_bulan' => $newData['pengeluaran_bulan'],
					'pendapatan_lain' => $newData['pendapatan_lain'],
					'minat_kerja' => $newData['minat_kerja'],
					'keterampilan' => $newData['keterampilan'],
					'pelatihan_yang_diikuti' => $newData['pelatihan_yang_diikuti'],
					'pelatihan_yang_diminat' => $newData['pelatihan_yang_diminat'],
					'status_rumah' => $newData['status_rumah'],
					'lantai' => $newData['lantai'],
					'kamar_mandi' => $newData['kamar_mandi'],
					'wc' => $newData['wc'],
					'akses_ke_lingkungan' => $newData['akses_ke_lingkungan'],
					'dinding' => $newData['dinding'],
					'sarana_air' => $newData['sarana_air'],
					'penerangan' => $newData['penerangan'],
					'desa_paud' => $newData['desa_paud'],
					'tk_di_desa' => $newData['tk_di_desa'],
					'kecamatan_slb' => $newData['kecamatan_slb'],
					'sd_menerima_abk' => $newData['sd_menerima_abk'],
					'smp_menerima_abk' => $newData['smp_menerima_abk'],
					'jumlah_posyandu' => $newData['jumlah_posyandu'],
					'kader_posyandu' => $newData['kader_posyandu'],
					'layanan_kesehatan' => $newData['layanan_kesehatan'],
					'sosialitas_ke_tetangga' => $newData['sosialitas_ke_tetangga'],
					'keterlibatan_berorganisasi' => $newData['keterlibatan_berorganisasi'],
					'kegiatan_kemasyarakatan' => $newData['kegiatan_kemasyarakatan'],
					'keterlibatan_musrembang' => $newData['keterlibatan_musrembang'],
					'alat_bantu_bantuan' => $newData['alat_bantu_bantuan'],
					'asal_alat_bantu' => $newData['asal_alat_bantu'],
					'tahun_pemberian' => $newData['tahun_pemberian'],
					'bantuan_uep' => $newData['bantuan_uep'],
					'asal_uep' => $newData['asal_uep'],
					'tahun' => $newData['tahun'],
					'lainnya' => $newData['lainnya'],
					'rehabilitas' => $newData['rehabilitas'],
					'lokasi_rehabilitas' => $newData['lokasi_rehabilitas'],
					'tahun_rehabilitas' => $newData['tahun_rehabilitas'],
					'keahlian_khusus' => $newData['keahlian_khusus'],
					'prestasi' => $newData['prestasi'],
					'nama_perawat' => $newData['nama_perawat'],
					'hubungan_dengan_pd' => $newData['hubungan_dengan_pd'],
					'nomor_hp' => $newData['nomor_hp']
				);
				$wpdb->last_error = "";
				$cek_id = $wpdb->get_var($wpdb->prepare("SELECT id from data_disabilitas where nama=%s and nik=%s", $newData['nama'], $newData['nik']));
				if(empty($cek_id)){
					$wpdb->insert("data_disabilitas", $data_db);
					$ret['data']['insert']++;
				}else{
					$wpdb->update("data_disabilitas", $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}
				if(!empty($wpdb->last_error)){
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};

			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function wp_disabilitas_admin_notice(){
        $versi = get_option('_wp_disabilitas_db_version');
        if($versi !== $this->version){
			$sql_migrate = $this->functions->generatePage(array(
				'nama_page' => 'Monitoring SQL migrate WP Disabilitas', 
				'content' => '[monitoring_sql_migrate_disabilitas]',
	        	'show_header' => 1,
	        	'no_key' => 1
			));
        	echo '
        		<div class="notice notice-warning is-dismissible">
	        		<p>Versi database WP Disabilitas tidak sesuai! harap dimutakhirkan. Versi saat ini=<b>'.$this->version.'</b> dan versi WP Disabilitas kamu=<b>'.$versi.'</b>. Silahkan update di halaman <a href="'.$sql_migrate['url'].'" class="button button-primary button-large">'.$sql_migrate['title'].'</a></p>
	         	</div>
	         ';
        }
	}

}
