<?php
$api_key = get_option( WP_DISABILITAS_KEY );
$login = false;
if(is_user_logged_in()){
    $current_user = wp_get_current_user();
    if($this->functions->user_has_role($current_user->ID, 'administrator')){
        $login = true;
    }
}
?>
<h1 class="text-center">Cek Data Disabilitas</h1>
<form id="formid" style="width: 500px; margin: auto;" class="text-center">
    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="<?php echo get_option('_crb_disabilitas_captcha_public'); ?>" style="margin: 10px auto; width: 300px;"></div>
    </div>
    <div class="form-group">
        <label for="nik">Masukan NIK / Nama</label>
        <div class="input-group">
            <input type="text" class="form-control" id="nik" placeholder="xxxxxxxxxxx">
            <div class="input-group-append">
                <span class="btn btn-primary" type="button" id="cari" style="display: flex; align-items: center;">Cari Data</span>
            </div>
        </div>
    </div>
</form>
<div style="padding: 10px; margin: auto; overflow: auto;" id="pesan">

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
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript">
jQuery('document').ready(function(){
    jQuery('#formid').on('keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            get_data(e);
        }
    });
    jQuery('#cari').on('click', function(e){
        get_data(e);
    });
});

function get_data(e){
    e.preventDefault();
    var captcha = jQuery('textarea[name="g-recaptcha-response"]').val();
    if(captcha == ''){
        return alert('Captcha harus dichecklist!');
    }
    var nik = jQuery('#nik').val();
    if(nik == ''){
        return alert('NIK/nama harus diisi!');
    }
    jQuery('#wrap-loading').show();
    jQuery('#pesan').html('');
    new Promise(function(resolve, reduce){
        var data = {
            action: 'get_data_disabilitas',
            api_key: '<?php echo $api_key; ?>',
            nik: nik,
            'g-recaptcha-response': captcha
        };
        jQuery.ajax({
            url: ajax.url,
            type: 'post',
            dataType: "json",
            data: data,
            success: function(res){
                resolve(res);
            }
        });
    }).then(function(res){
        grecaptcha.reset();
        console.log(res);
        if(res.status == 'error'){
            alert(res.message);
        }else if(res.data.length == 0){
            alert('Data dengan nomor NIK '+nik+' tidak ditemukan!');
        }else{
            var data_all = '';
        <?php if($login == false): ?>
            res.data.map(function(b, i){
                data_all += ''
                    +'<tr>'
                        +'<td class="text-center">'+(i+1)+'</td>'
                        +'<td>'+b.nama+'</td>'
                        +'<td>'+b.gender+'</td>'
                        +'<td>'+b.desa+'</td>'
                        +'<td>'+b.rt_rw+'</td>'
                        +'<td>'+b.jenis_disabilitas+'</td>'
                        +'<td>'+b.keterangan_disabilitas+'</td>'
                        +'<td>'+b.sebab_disabilitas+'</td>'
                        +'<td>'+b.diagnosa_medis+'</td>'
                        +'<td>'+b.penyakit_lain+'</td>'
                    +'</tr>';
            });
            var pesan = ''
                +'<table class="table table-bordered">'
                    +'<thead>'
                        +'<tr>'
                            +'<th class="text-center" style="width: 20px;">No</th>'
                            +'<th class="text-center">Nama</th>'
                            +'<th class="text-center">Gender</th>'
                            +'<th class="text-center">Desa</th>'
                            +'<th class="text-center">Alamat</th>'
                            +'<th class="text-center">Jenis Disabilitas</th>'
                            +'<th class="text-center">Keterangan Disabilitas</th>'
                            +'<th class="text-center">Sebab Disabilitas</th>'
                            +'<th class="text-center">Diagnosa Medis</th>'
                            +'<th class="text-center">Penyakit Lain</th>'
                        +'</tr>'
                    +'</thead>'
                    +'<tbody>'
                        +data_all
                    +'</tbody>'
                +'</table>';
        <?php else: ?>
            res.data.map(function(b, i){
                data_all += ''
                    +'<tr>'
                        +'<td class="text-center">'+(i+1)+'</td>'
                        +'<td>'+b.nama+'</td>'
                        +'<td>'+b.gender+'</td>'
                        +'<td>'+b.tempat_lahir+'</td>'
                        +'<td>'+b.tanggal_lahir+'</td>'
                        +'<td>'+b.status+'</td>'
                        +'<td>'+b.dokumen_kewarganegaraan+'</td>'
                        +'<td>'+b.nik+'</td>'
                        +'<td>'+b.nomor_kk+'</td>'
                        +'<td>'+b.rt_rw+'</td>'
                        +'<td>'+b.desa+'</td>'
                        +'<td>'+b.no_hp+'</td>'
                        +'<td>'+b.pendidikan_terakhir+'</td>'
                        +'<td>'+b.nama_sekolah+'</td>'
                        +'<td>'+b.keterangan_lulus+'</td>'
                        +'<td>'+b.jenis_disabilitas+'</td>'
                        +'<td>'+b.keterangan_disabilitas+'</td>'
                        +'<td>'+b.sebab_disabilitas+'</td>'
                        +'<td>'+b.diagnosa_medis+'</td>'
                        +'<td>'+b.penyakit_lain+'</td>'
                        +'<td>'+b.tempat_pengobatan+'</td>'
                        +'<td>'+b.perawat+'</td>'
                        +'<td>'+b.aktivitas+'</td>'
                        +'<td>'+b.aktivitas_bantuan+'</td>'
                        +'<td>'+b.perlu_bantu+'</td>'
                        +'<td>'+b.alat_bantu+'</td>'
                        +'<td>'+b.alat_yang_dimiliki+'</td>'
                        +'<td>'+b.kondisi_alat+'</td>'
                        +'<td>'+b.jaminan_kesehatan+'</td>'
                        +'<td>'+b.cara_menggunakan_jamkes+'</td>'
                        +'<td>'+b.jaminan_sosial+'</td>'
                        +'<td>'+b.pekerjaan+'</td>'
                        +'<td>'+b.lokasi_bekerja+'</td>'
                        +'<td>'+b.alasan_tidak_bekerja+'</td>'
                        +'<td>'+b.pendapatan_bulan+'</td>'
                        +'<td>'+b.pengeluaran_bulan+'</td>'
                        +'<td>'+b.pendapatan_lain+'</td>'
                        +'<td>'+b.minat_kerja+'</td>'
                        +'<td>'+b.keterampilan+'</td>'
                        +'<td>'+b.pelatihan_yang_diikuti+'</td>'
                        +'<td>'+b.pelatihan_yang_diminat+'</td>'
                        +'<td>'+b.status_rumah+'</td>'
                        +'<td>'+b.lantai+'</td>'
                        +'<td>'+b.kamar_mandi+'</td>'
                        +'<td>'+b.wc+'</td>'
                        +'<td>'+b.akses_ke_lingkungan+'</td>'
                        +'<td>'+b.dinding+'</td>'
                        +'<td>'+b.sarana_air+'</td>'
                        +'<td>'+b.penerangan+'</td>'
                        +'<td>'+b.desa_paud+'</td>'
                        +'<td>'+b.tk_di_desa+'</td>'
                        +'<td>'+b.kecamatan_slb+'</td>'
                        +'<td>'+b.sd_menerima_abk+'</td>'
                        +'<td>'+b.smp_menerima_abk+'</td>'
                        +'<td>'+b.jumlah_posyandu+'</td>'
                        +'<td>'+b.kader_posyandu+'</td>'
                        +'<td>'+b.layanan_kesehatan+'</td>'
                        +'<td>'+b.sosialitas_ke_tetangga+'</td>'
                        +'<td>'+b.keterlibatan_berorganisasi+'</td>'
                        +'<td>'+b.kegiatan_kemasyarakatan+'</td>'
                        +'<td>'+b.keterlibatan_musrembang+'</td>'
                        +'<td>'+b.alat_bantu_bantuan+'</td>'
                        +'<td>'+b.asal_alat_bantu+'</td>'
                        +'<td>'+b.tahun_pemberian+'</td>'
                        +'<td>'+b.bantuan_uep+'</td>'
                        +'<td>'+b.asal_uep+'</td>'
                        +'<td>'+b.tahun+'</td>'
                        +'<td>'+b.lainnya+'</td>'
                        +'<td>'+b.rehabilitas+'</td>'
                        +'<td>'+b.lokasi_rehabilitas+'</td>'
                        +'<td>'+b.tahun_rehabilitas+'</td>'
                        +'<td>'+b.keahlian_khusus+'</td>'
                        +'<td>'+b.prestasi+'</td>'
                        +'<td>'+b.nama_perawat+'</td>'
                        +'<td>'+b.hubungan_dengan_pd+'</td>'
                        +'<td>'+b.nomor_hp+'</td>'
                    +'</tr>';
            });
            var pesan = ''
                +'<table class="table table-bordered">'
                    +'<thead>'
                        +'<tr>'
                            +'<th class="text-center" style="width: 20px;">No</th>'
                            +'<th class="text-center">Nama</th>'
                            +'<th class="text-center">Gender</th>'
                            +'<th class="text-center">Tempat Lahir</th>'
                            +'<th class="text-center">Tanggal Lahir</th>'
                            +'<th class="text-center">Status</th>'
                            +'<th class="text-center">Dokumen Kewarganegaraan</th>'
                            +'<th class="text-center">NIK</th>'
                            +'<th class="text-center">Nomor KK</th>'
                            +'<th class="text-center">RT/RW</th>'
                            +'<th class="text-center">Desa</th>'
                            +'<th class="text-center">No HP</th>'
                            +'<th class="text-center">Pendidikan Terakhir</th>'
                            +'<th class="text-center">Nama Sekolah</th>'
                            +'<th class="text-center">Keterangan Lulus</th>'
                            +'<th class="text-center">Jenis Disabilitas</th>'
                            +'<th class="text-center">Keterangan Disabilitas</th>'
                            +'<th class="text-center">Sebab Disabilitas</th>'
                            +'<th class="text-center">Diagnosa Medis</th>'
                            +'<th class="text-center">penyakit Lain</th>'
                            +'<th class="text-center">Tempat Pengobatan</th>'
                            +'<th class="text-center">Perawat</th>'
                            +'<th class="text-center">Aktivitas</th>'
                            +'<th class="text-center">Aktivitas Bantuan</th>'
                            +'<th class="text-center">Perlu Bantu</th>'
                            +'<th class="text-center">Alat Bantu</th>'
                            +'<th class="text-center">Alat Yang Dimiliki</th>'
                            +'<th class="text-center">Kondisi Alat</th>'
                            +'<th class="text-center">Jaminan Kesehatan</th>'
                            +'<th class="text-center">Cara Menggunakan Jamkes</th>'
                            +'<th class="text-center">Jaminan Sosial</th>'
                            +'<th class="text-center">Pekerjaan</th>'
                            +'<th class="text-center">Lokasi Bekerja</th>'
                            +'<th class="text-center">Alasan Tidak Bekerja</th>'
                            +'<th class="text-center">Pendapatan Bulan</th>'
                            +'<th class="text-center">Pengeluaran Bulan</th>'
                            +'<th class="text-center">Pendapatan Lain</th>'
                            +'<th class="text-center">Minat Kerja</th>'
                            +'<th class="text-center">Keterampilan</th>'
                            +'<th class="text-center">Pelatihan Yang Diikuti</th>'
                            +'<th class="text-center">Pelatihan Yang Diminat</th>'
                            +'<th class="text-center">Status Rumah</th>'
                            +'<th class="text-center">Lantai</th>'
                            +'<th class="text-center">Kamar Mandi</th>'
                            +'<th class="text-center">WC</th>'
                            +'<th class="text-center">Akses ke Lingkungan</th>'
                            +'<th class="text-center">Dinding</th>'
                            +'<th class="text-center">Sarana Air</th>'
                            +'<th class="text-center">Penerangan</th>'
                            +'<th class="text-center">Desa Paud</th>'
                            +'<th class="text-center">TK di Desa</th>'
                            +'<th class="text-center">Kecamatan SLB</th>'
                            +'<th class="text-center">SD Menerima ABK</th>'
                            +'<th class="text-center">SMP Menerima ABK</th>'
                            +'<th class="text-center">Jumlah Posyandu</th>'
                            +'<th class="text-center">Kader Posyandu</th>'
                            +'<th class="text-center">Layanan Kesehatan</th>'
                            +'<th class="text-center">Sosialitas ke Tetangga</th>'
                            +'<th class="text-center">Keterlibatan Berorganisasi</th>'
                            +'<th class="text-center">Kegiatan Kemasyarakatan</th>'
                            +'<th class="text-center">Keterlibatan Musrembang</th>'
                            +'<th class="text-center">Alat Bantu Bantuan</th>'
                            +'<th class="text-center">Asal Alat Bantu</th>'
                            +'<th class="text-center">Tahun Pemberian</th>'
                            +'<th class="text-center">Bantuan UEP</th>'
                            +'<th class="text-center">Asal UEP</th>'
                            +'<th class="text-center">Tahun</th>'
                            +'<th class="text-center">Lainnya</th>'
                            +'<th class="text-center">Rehabilitas</th>'
                            +'<th class="text-center">Lokasi Rehabilitas</th>'
                            +'<th class="text-center">Tahun Rehabilitas</th>'
                            +'<th class="text-center">Keahlian Khusus</th>'
                            +'<th class="text-center">Prestasi</th>'
                            +'<th class="text-center">Nama Perawat</th>'
                            +'<th class="text-center">Hubungan Dengan Penyandang Disabilitas</th>'
                            +'<th class="text-center">Nomor HP</th>'
                        +'</tr>'
                    +'</thead>'
                    +'<tbody>'
                        +data_all
                    +'</tbody>'
                +'</table>';
        <?php endif; ?>
            jQuery('#pesan').html(pesan);
        }
        jQuery('#wrap-loading').hide();
    });
}

function en(e){
    return e;
}

function de(e){
    return e;
}
</script>