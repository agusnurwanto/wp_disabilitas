<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_disabilitas
 * @subpackage Wp_disabilitas/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_disabilitas
 * @subpackage Wp_disabilitas/public
 * @author     Bakti Negara <agusnurwantomuslim@gmail.com>
 */
class Wp_disabilitas_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp_disabilitas-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp_disabilitas-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax', array(
		    'url' => admin_url( 'admin-ajax.php' )
		));

	}

	function monitoring_sql_migrate_disabilitas(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp_disabilitas-public-monitor-sql-migrate.php';
	}

	function statistik_disabilitas(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp_disabilitas-public-statistik.php';
	}

	function data_disabilitas(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp_disabilitas-data-disabilitas.php';
	}

	function data_disabilitas_admin(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp_disabilitas-data-disabilitas-admin.php';
	}

	public function run_sql_migrate_disabilitas(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil menjalankan SQL migrate!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( WP_DISABILITAS_KEY )) {
				$file = basename($_POST['file']);
				$ret['value'] = $file.' (tgl: '.date('Y-m-d H:i:s').')';
				if($file == 'tabel.sql'){
					$path = WP_DISABILITAS_PLUGIN_PATH.'/'.$file;
				}else{
					$path = WP_DISABILITAS_PLUGIN_PATH.'/sql-migrate/'.$file;
				}
				if(file_exists($path)){
					$sql = file_get_contents($path);
					$ret['sql'] = $sql;
					if($file == 'tabel.sql'){
						require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
						$wpdb->hide_errors();
						$rows_affected = dbDelta($sql);
						if(empty($rows_affected)){
							$ret['status'] = 'error';
							$ret['message'] = $wpdb->last_error;
						}else{
							$ret['message'] = implode(' | ', $rows_affected);
						}
					}else{
						$wpdb->hide_errors();
						$res = $wpdb->query($sql);
						if(empty($res)){
							$ret['status'] = 'error';
							$ret['message'] = $wpdb->last_error;
						}else{
							$ret['message'] = $res;
						}
					}
					if($ret['status'] == 'success'){
						$ret['version'] = $this->version;
						update_option('_last_update_sql_migrate_disabilitas', $ret['value']);
						update_option('_wp_disabilitas_db_version', $this->version);
					}
				}else{
					$ret['status'] = 'error';
					$ret['message'] = 'File '.$file.' tidak ditemukan!';
				}
			}else{
				$ret = array(
					'status' => 'error',
					'message'	=> 'Api Key tidak sesuai!'
				);
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_data_disabilitas(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data!'
		);
		if (!empty($_POST)) {
			if(isset($_POST['g-recaptcha-response'])){
	          	$captcha=$_POST['g-recaptcha-response'];
	        }
	        if(!$captcha){
	        	$ret['status'] = 'error';
	        }
	        $secretKey = get_option('_crb_disabilitas_captcha_private');
	        $ip = $_SERVER['REMOTE_ADDR'];
	        // post request to server
	        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
	        $response = file_get_contents($url);
	        $responseKeys = json_decode($response,true);
	        if(empty($responseKeys["success"])) {
	        	$ret['status'] = 'error';
	        	$ret['message'] = 'Harap selesaikan validasi captcha dulu!';
	        }else {
	        	if(strlen($_POST['nik']) >=3){
					if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( WP_DISABILITAS_KEY )) {
						$data = $wpdb->get_results($wpdb->prepare("
							SELECT
								*
							FROM data_disabilitas
							WHERE nik like %s
								OR nama like %s
						", '%'.$_POST['nik'].'%', '%'.$_POST['nik'].'%'));
						$ret['data'] = $data;
					}else{
						$ret = array(
							'status' => 'error',
							'message'	=> 'Api Key tidak sesuai!'
						);
					}
				}else{
					$ret = array(
						'status' => 'error',
						'message'	=> 'NIK/nama minimal 3 karakter!'
					);
				}
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_data_disabilitas_all(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data all!'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( WP_DISABILITAS_KEY )) {
				$params = $columns = $totalRecords = $data = array();
				$params = $_REQUEST;
				$columns = array( 
					'nama',
					'gender',
					'tempat_lahir',
					'tanggal_lahir',
					'status',
					'dokumen_kewarganegaraan',
					'nik',
					'nomor_kk',
					'rt_rw',
					'desa',
					'no_hp',
					'pendidikan_terakhir',
					'nama_sekolah',
					'keterangan_lulus',
					'jenis_disabilitas',
					'keterangan_disabilitas',
					'sebab_disabilitas',
					'diagnosa_medis',
					'penyakit_lain',
					'tempat_pengobatan',
					'perawat',
					'aktivitas',
					'aktivitas_bantuan',
					'perlu_bantu',
					'alat_bantu',
					'alat_yang_dimiliki',
					'kondisi_alat',
					'jaminan_kesehatan',
					'cara_menggunakan_jamkes',
					'jaminan_sosial',
					'pekerjaan',
					'lokasi_bekerja',
					'alasan_tidak_bekerja',
					'pendapatan_bulan',
					'pengeluaran_bulan',
					'pendapatan_lain',
					'minat_kerja',
					'keterampilan',
					'pelatihan_yang_diikuti',
					'pelatihan_yang_diminat',
					'status_rumah',
					'lantai',
					'kamar_mandi',
					'wc',
					'akses_ke_lingkungan',
					'dinding',
					'sarana_air',
					'penerangan',
					'desa_paud',
					'tk_di_desa',
					'kecamatan_slb',
					'sd_menerima_abk',
					'smp_menerima_abk',
					'jumlah_posyandu',
					'kader_posyandu',
					'layanan_kesehatan',
					'sosialitas_ke_tetangga',
					'keterlibatan_berorganisasi',
					'kegiatan_kemasyarakatan',
					'keterlibatan_musrembang',
					'alat_bantu_bantuan',
					'asal_alat_bantu',
					'tahun_pemberian',
					'bantuan_uep',
					'asal_uep',
					'tahun',
					'lainnya',
					'rehabilitas',
					'lokasi_rehabilitas',
					'tahun_rehabilitas',
					'keahlian_khusus',
					'prestasi',
					'nama_perawat',
					'hubungan_dengan_pd',
					'nomor_hp'
				);
				$where = $sqlTotAll = $sqlTot = $sqlRec = "";

				// check search value exist
				if( !empty($params['search']['value']) ) {
					$where .=" AND ( nama LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");    
					$where .=" OR nik LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%");
					$where .=" OR jenis_disabilitas LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%").")";
				}

				$sql_tot = "SELECT count(id) as jml FROM `data_disabilitas`";
				$sql = "SELECT ".implode(', ', $columns)." FROM `data_disabilitas`";
				$where_first = " WHERE 1=1";
				$sqlTot .= $sql_tot.$where_first;
				$sqlTotAll = $sql_tot;
				$sqlRec .= $sql.$where_first;
				if(isset($where) && $where != '') {
					$sqlTot .= $where;
					$sqlRec .= $where;
				}
				$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".str_replace("'", "", $wpdb->prepare('%s', $params['order'][0]['dir']))."  LIMIT ".$wpdb->prepare('%d', $params['start'])." ,".$wpdb->prepare('%d', $params['length'])." ";

				$totalRecords = $wpdb->get_var($sqlTotAll);
				$recordsFiltered = $wpdb->get_var($sqlTot);
				$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

				$json_data = array(
					"draw"            => $params['draw']++,   
					"recordsTotal"    => $totalRecords,  
					"recordsFiltered" => $recordsFiltered,
					"data"            => $queryRecords
				);
				$ret['data'] = $json_data;
			}else{
				$ret = array(
					'status' => 'error',
					'message'	=> 'Api Key tidak sesuai!'
				);
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

}
