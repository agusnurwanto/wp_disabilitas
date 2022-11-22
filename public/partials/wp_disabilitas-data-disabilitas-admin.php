<?php
$api_key = get_option( WP_DISABILITAS_KEY );
$filter = array();
$judul_filter = '';
if(!empty($_GET)){
    if(!empty($_GET['gender'])){
        $filter[] = array('key' => 'gender', 'val' => $_GET['gender']);
        $gender = 'Tidak Diketahui';
        if($_GET['gender'] == 'P'){
            $gender = 'Perempuan';
        }else if($_GET['gender'] == 'L'){
            $gender = 'Laki-Laki';
        }
        $judul_filter .= '<h2 class="text-center">Dengan Pengelompokan Jenis Kelamin '.$gender.'</h2>';
    }
    if(!empty($_GET['usia'])){
        $filter[] = array('key' => 'tanggal_lahir', 'val' => $_GET['usia']);
        $usia = 'Tidak Diketahui';
        if($_GET['usia'] == 1){
            $usia = 'Tidak Diketahui';
        }else if($_GET['usia'] == 2){
            $usia = '0 - 5 Tahun';
        }else if($_GET['usia'] == 3){
            $usia = '6 - 17 Tahun';
        }else if($_GET['usia'] == 4){
            $usia = '18 - 50 Tahun';
        }else if($_GET['usia'] == 5){
            $usia = '51 - Lansia';
        }
        $judul_filter .= '<h2 class="text-center">Dengan Pengelompokan Usia '.$usia.'</h2>';
    }
    if(!empty($_GET['jenis_disabilitas'])){
        $filter[] = array('key' => 'jenis_disabilitas', 'val' => $_GET['jenis_disabilitas']);
        $judul_filter .= '<h2 class="text-center">Dengan Pengelompokan Jenis Disabilitas '.$_GET['jenis_disabilitas'].'</h2>';
    }
    if(!empty($_GET['desa'])){
        $filter[] = array('key' => 'desa', 'val' => $_GET['desa']);
        $judul_filter .= '<h2 class="text-center">Dengan Pengelompokan Desa '.$_GET['desa'].'</h2>';
    }
}
?>
<h1 class="text-center">Data Disabilitas</h1>
<h2 class="text-center"><?php echo $this->get_judul(); ?></h2>
<?php echo $judul_filter; ?>
<div style="padding: 10px; margin: auto; overflow: auto;" id="pesan">
    <table class="table table-bordered" id="data-table">
        <thead>
            <tr>
                <th class="text-center">Nama</th>
                <th class="text-center">Gender</th>
                <th class="text-center">Tempat Lahir</th>
                <th class="text-center">Tanggal Lahir</th>
                <th class="text-center">Status</th>
                <th class="text-center">Dokumen Kewarganegaraan</th>
                <th class="text-center">NIK</th>
                <th class="text-center">Nomor KK</th>
                <th class="text-center">RT/RW</th>
                <th class="text-center">Desa</th>
                <th class="text-center">No HP</th>
                <th class="text-center">Pendidikan Terakhir</th>
                <th class="text-center">Nama Sekolah</th>
                <th class="text-center">Keterangan Lulus</th>
                <th class="text-center">Jenis Disabilitas</th>
                <th class="text-center">Keterangan Disabilitas</th>
                <th class="text-center">Sebab Disabilitas</th>
                <th class="text-center">Diagnosa Medis</th>
                <th class="text-center">penyakit Lain</th>
                <th class="text-center">Tempat Pengobatan</th>
                <th class="text-center">Perawat</th>
                <th class="text-center">Aktivitas</th>
                <th class="text-center">Aktivitas Bantuan</th>
                <th class="text-center">Perlu Bantu</th>
                <th class="text-center">Alat Bantu</th>
                <th class="text-center">Alat Yang Dimiliki</th>
                <th class="text-center">Kondisi Alat</th>
                <th class="text-center">Jaminan Kesehatan</th>
                <th class="text-center">Cara Menggunakan Jamkes</th>
                <th class="text-center">Jaminan Sosial</th>
                <th class="text-center">Pekerjaan</th>
                <th class="text-center">Lokasi Bekerja</th>
                <th class="text-center">Alasan Tidak Bekerja</th>
                <th class="text-center">Pendapatan Bulan</th>
                <th class="text-center">Pengeluaran Bulan</th>
                <th class="text-center">Pendapatan Lain</th>
                <th class="text-center">Minat Kerja</th>
                <th class="text-center">Keterampilan</th>
                <th class="text-center">Pelatihan Yang Diikuti</th>
                <th class="text-center">Pelatihan Yang Diminat</th>
                <th class="text-center">Status Rumah</th>
                <th class="text-center">Lantai</th>
                <th class="text-center">Kamar Mandi</th>
                <th class="text-center">WC</th>
                <th class="text-center">Akses ke Lingkungan</th>
                <th class="text-center">Dinding</th>
                <th class="text-center">Sarana Air</th>
                <th class="text-center">Penerangan</th>
                <th class="text-center">Desa Paud</th>
                <th class="text-center">TK di Desa</th>
                <th class="text-center">Kecamatan SLB</th>
                <th class="text-center">SD Menerima ABK</th>
                <th class="text-center">SMP Menerima ABK</th>
                <th class="text-center">Jumlah Posyandu</th>
                <th class="text-center">Kader Posyandu</th>
                <th class="text-center">Layanan Kesehatan</th>
                <th class="text-center">Sosialitas ke Tetangga</th>
                <th class="text-center">Keterlibatan Berorganisasi</th>
                <th class="text-center">Kegiatan Kemasyarakatan</th>
                <th class="text-center">Keterlibatan Musrembang</th>
                <th class="text-center">Alat Bantu Bantuan</th>
                <th class="text-center">Asal Alat Bantu</th>
                <th class="text-center">Tahun Pemberian</th>
                <th class="text-center">Bantuan UEP</th>
                <th class="text-center">Asal UEP</th>
                <th class="text-center">Tahun</th>
                <th class="text-center">Lainnya</th>
                <th class="text-center">Rehabilitas</th>
                <th class="text-center">Lokasi Rehabilitas</th>
                <th class="text-center">Tahun Rehabilitas</th>
                <th class="text-center">Keahlian Khusus</th>
                <th class="text-center">Prestasi</th>
                <th class="text-center">Nama Perawat</th>
                <th class="text-center">Hubungan Dengan Penyandang Disabilitas</th>
                <th class="text-center">Nomor HP</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div style="max-width: 1000px; margin: auto;">
    <h4>Keterangan:</h4>
    <ul>
        <li><b>Disabilitas</b> Dalam Undang-undang Republik Indonesia Nomor 8 Tahun 2016 Tentang Penyandang Disabilitas, dijelaskan bahwa disabilitas adalah setiap orang yang mengalami keterbatasan fisik, intelektual, mental, dan/atau sensorik dalam jangka waktu lama yang dalam berinteraksi dengan lingkungan dapat mengalami hambatan dan kesulitan untuk berpartisipasi secara penuh dan efektif dengan warga negara lainnya berdasarkan kesamaan hak.</li>
        <li><b>SLB</b> Sekolah Luar Biasa adalah sebuah lembaga pendidikan yang khusus diperuntukan bagi anak berkebutuhan khusus agar mendapatkan layanan pendidikan yang sesuai dengan kekhususannya.</li>
        <li><b>ABK</b> Anak Berkebutuhan Khusus adalah anak yang memiliki keterbatasan fisik, intelektual, emosi, dan sosial.</li>
        <li><b>UEP</b> Usaha Ekonomi Produktif adalah bantuan sosial yang diberikan kepada kelompok usaha bersama untuk meningkatkan pendapatan dan kesejahteraan sosial keluarga.</li>
    </ul>
</div>
<script type="text/javascript" src="<?php echo WP_DISABILITAS_PLUGIN_URL; ?>/public/js/datatables.min.js"></script>
<script type="text/javascript">
window.filter = <?php echo json_encode($filter); ?>;
jQuery('document').ready(function(){
    var oTable = jQuery('#data-table').dataTable({
        serverSide: true,
        processing: true,
        ajax: function (data, callback, settings) {
            jQuery('#wrap-loading').show();
            data.action = 'get_data_disabilitas_all';
            data.filter = filter;
            data.api_key = '<?php echo $api_key; ?>';
            jQuery.ajax({
                url: ajax.url,
                type: 'post',
                dataType: "json",
                data: data,
                success: function(res){
                    if(res.status == "error"){
                        return alert(res.message);
                    }
                    return callback(res.data);
                }
            });
        },
        columnDefs: [
            { "width": "100px", "targets": 3 }
        ],
        lengthMenu: [[10, 25, 100, -1], [10, 25, 100, "All"]],
        "columns": [
            {
                data: "nama"
            },
            { 
                data: 'gender',
                className: "text-center"  
            },
            { data: 'tempat_lahir' },
            { data: 'tanggal_lahir' },
            { data: 'status' },
            { data: 'dokumen_kewarganegaraan' },
            { data: 'nik' },
            { data: 'nomor_kk' },
            { data: 'rt_rw' },
            { data: 'desa' },
            { data: 'no_hp' },
            { data: 'pendidikan_terakhir' },
            { data: 'nama_sekolah' },
            { data: 'keterangan_lulus' },
            { data: 'jenis_disabilitas' },
            { data: 'keterangan_disabilitas' },
            { data: 'sebab_disabilitas' },
            { data: 'diagnosa_medis' },
            { data: 'penyakit_lain' },
            { data: 'tempat_pengobatan' },
            { data: 'perawat' },
            { data: 'aktivitas' },
            { data: 'aktivitas_bantuan' },
            { data: 'perlu_bantu' },
            { data: 'alat_bantu' },
            { data: 'alat_yang_dimiliki' },
            { data: 'kondisi_alat' },
            { data: 'jaminan_kesehatan' },
            { data: 'cara_menggunakan_jamkes' },
            { data: 'jaminan_sosial' },
            { data: 'pekerjaan' },
            { data: 'lokasi_bekerja' },
            { data: 'alasan_tidak_bekerja' },
            { data: 'pendapatan_bulan' },
            { data: 'pengeluaran_bulan' },
            { data: 'pendapatan_lain' },
            { data: 'minat_kerja' },
            { data: 'keterampilan' },
            { data: 'pelatihan_yang_diikuti' },
            { data: 'pelatihan_yang_diminat' },
            { data: 'status_rumah' },
            { data: 'lantai' },
            { data: 'kamar_mandi' },
            { data: 'wc' },
            { data: 'akses_ke_lingkungan' },
            { data: 'dinding' },
            { data: 'sarana_air' },
            { data: 'penerangan' },
            { data: 'desa_paud' },
            { data: 'tk_di_desa' },
            { data: 'kecamatan_slb' },
            { data: 'sd_menerima_abk' },
            { data: 'smp_menerima_abk' },
            { data: 'jumlah_posyandu' },
            { data: 'kader_posyandu' },
            { data: 'layanan_kesehatan' },
            { data: 'sosialitas_ke_tetangga' },
            { data: 'keterlibatan_berorganisasi' },
            { data: 'kegiatan_kemasyarakatan' },
            { data: 'keterlibatan_musrembang' },
            { data: 'alat_bantu_bantuan' },
            { data: 'asal_alat_bantu' },
            { data: 'tahun_pemberian' },
            { data: 'bantuan_uep' },
            { data: 'asal_uep' },
            { data: 'tahun' },
            { data: 'lainnya' },
            { data: 'rehabilitas' },
            { data: 'lokasi_rehabilitas' },
            { data: 'tahun_rehabilitas' },
            { data: 'keahlian_khusus' },
            { data: 'prestasi' },
            { data: 'nama_perawat' },
            { data: 'hubungan_dengan_pd' },
            { data: 'nomor_hp' }
        ],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api();
            jQuery('#wrap-loading').hide();
        }
    });
    jQuery('div.dataTables_filter input').unbind();
    jQuery('div.dataTables_filter input').bind('keyup', function(e) {
        if(e.keyCode == 13) {
            oTable.fnFilter(this.value);
        }
    });
});
</script>