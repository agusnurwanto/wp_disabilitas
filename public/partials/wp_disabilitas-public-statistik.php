<?php
global $wpdb;

$login = false;
if(is_user_logged_in()){
    $current_user = wp_get_current_user();
    if($this->functions->user_has_role($current_user->ID, 'administrator')){
        $login = true;
    }
}

if(true == $login){
    $data_disabilitas_admin = $this->functions->generatePage(array(
        'nama_page' => 'Data Disabilitas Admin', 
        'content' => '[data_disabilitas_admin]',
        'show_header' => 1,
        'no_key' => 1,
    ));
    $link_data_admin = $data_disabilitas_admin['url'];
}else{
    $link_data_admin = '';
}

function link_detail($link_admin, $jenis){
    return "<a target='_blank' href='".$link_admin."?".$jenis['key']."=".$jenis['value']."'>".$jenis['label']."</a>";
}

function generateRandomColor($k){
    $color = array('#f44336', '#9c27b0', '#2196f3', '#009688', '#4caf50', '#cddc39', '#ff9800', '#795548', '#9e9e9e', '#607d8b');
    return $color[$k%10];
}
function hitung_umur($tanggal_lahir){
    if(empty($tanggal_lahir)){
        return "Tidak diketahui";
    }
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime("today");
    if ($birthDate > $today) { 
        return "0";
    }
    $y = $today->diff($birthDate)->y;
    return $y."";
}
$data = $wpdb->get_results("select * from data_disabilitas", ARRAY_A);
$total_data = count($data);
$gender = array();
$usia = array();
$jenis_disabilitas = array();
$desa = array();
foreach($data as $k => $v){
    if(empty($gender[$v['gender']])){
        $gender[$v['gender']] = array();
    }
    $gender[$v['gender']][] = $v;

    $current_usia = hitung_umur($v['tanggal_lahir']);
    if(empty($usia[$current_usia])){
        $usia[$current_usia] = array();
    }
    $usia[$current_usia][] = $v;

    if(empty($jenis_disabilitas[$v["jenis_disabilitas"]])){
        $jenis_disabilitas[$v["jenis_disabilitas"]] = array();
    }
    $jenis_disabilitas[$v["jenis_disabilitas"]][] = $v;
    
    if(empty($desa[$v["desa"]])){
        $desa[$v["desa"]] = array();
    }
    $desa[$v["desa"]][] = $v;
    

}
ksort($usia);
ksort($jenis_disabilitas);
ksort($desa);
// print_r($gender); die();

// grafik gender
$chart_gender = array(
    'label' => array(),
    'data'  => array(),
    'color' => array()
);
$body_gender = "";
$total_gender = 0;
foreach($gender as $k => $v){
    $jumlah = count($v);
    $total_gender += $jumlah;
    if($k == 'P'){
        $jenis = "Perempuan";
        $color = "rgba(54, 162, 235, 1)";
    }else if($k == "L"){
        $jenis = "Laki-laki";
        $color = "rgba(255, 99, 132, 1)";
    }else{
        $jenis = "Tidak diketahui";
        $color = "rgba(255, 206, 86, 1)";
    }
    $chart_gender['label'][] = $jenis;
    $chart_gender['data'][] = $jumlah;
    $chart_gender['color'][] = $color;
    if(true == $login){
        $jenis = link_detail($link_data_admin, array('key' => 'gender', 'value' => $k, 'label' => $jenis ));
    }
    $body_gender .= "
        <tr>
            <td>$jenis</td>
            <td class='text-right'>$jumlah</td>
        </tr>
    ";
}

// grafik usia
$chart_usia = array(
    'label' => array(),
    'data'  => array(),
    'color' => array()
);
$total_usia = 0;
$body_usia = "";
$usia_baru = array();
foreach($usia as $k => $v){
    if($k == 'Tidak diketahui'){
        $jenis = $k;
    }else if($k <= 5){
        $jenis = '0 - 5 tahun';
    }else if($k <= 17){
        $jenis = '6 - 17 tahun';
    }else if($k <= 50){
        $jenis = '18 - 50 tahun';
    }else{
        $jenis = '51 tahun - lansia';
    }
    if(empty($usia_baru[$jenis])){
        $usia_baru[$jenis] = $v;
    }else{
        $usia_baru[$jenis] = array_merge($usia_baru[$jenis], $v);
    }
}
$no = 0;
foreach($usia_baru as $k => $v){
    $no++;
    $jumlah = count($v);
    $total_usia += $jumlah;
    $jenis = $k;
    $chart_usia['label'][] = $jenis;
    $chart_usia['data'][] = $jumlah;
    $chart_usia['color'][] = generateRandomColor($no);
    $body_usia .= "
        <tr>
            <td>$jenis</td>
            <td class='text-right'>$jumlah</td>
        </tr>
    ";
}

// grafik jenis
$chart_jenis = array(
    'label' => array(),
    'data'  => array(),
    'color' => array()
);
$total_jenis = 0;
$body_jenis = "";
$no = 0;
foreach($jenis_disabilitas as $k => $v){
    $no++;
    $jumlah = count($v);
    $total_jenis += $jumlah;
    $jenis = $k;
    if(empty($jenis)){
        $jenis = 'Tidak diketahui';
    }
    $chart_jenis['label'][] = $jenis;
    $chart_jenis['data'][] = $jumlah;
    $chart_jenis['color'][] = generateRandomColor($no);
    if(true == $login){
        $jenis = link_detail($link_data_admin, array('key' => 'jenis_disabilitas', 'value' => $jenis, 'label' => $jenis ));
    }
    $body_jenis .= "
        <tr>
            <td>$jenis</td>
            <td class='text-right'>$jumlah</td>
        </tr>
    ";
}

// grafik desa
$chart_desa = array(
    'label' => array(),
    'data'  => array(),
    'color' => array()
);
$total_desa = 0;
$body_desa = "";
$no = 0;
foreach($desa as $k => $v){
    $no++;
    $jumlah = count($v);
    $total_desa += $jumlah;
    $nama_desa = $k;
    if(empty($nama_desa)){
        $nama_desa = 'Tidak diketahui';
    }
    $chart_desa['label'][] = $nama_desa;
    $chart_desa['data'][] = $jumlah;
    $chart_desa['color'][] = generateRandomColor($no);
    if(true == $login){
        $nama_desa = link_detail($link_data_admin, array('key' => 'desa', 'value' => $nama_desa, 'label' => $nama_desa ));
    }
    $body_desa .= "
        <tr>
            <td>$nama_desa</td>
            <td class='text-right'>$jumlah</td>
        </tr>
    ";
}
?>
<style type="text/css">
    .card {
        margin-top: 20px;
    }
</style>
<div class="cetak">
    <div style="padding: 10px;">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Data Statistik Disabilitas</h1>
                <h2 class="text-center"><?php echo $this->get_judul(); ?></h2>
                <h2 class="text-center">Total Disabilitas = <?php echo $total_data; ?> Orang</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h2 class="text-center text-white">Grafik Disabilitas berdasarkan Gender</h2>
                    </div>
                    <div class="card-body">
                        <div class="container counting-inner">
                            <div class="row counting-box title-row" style="margin-bottom: 55px;">
                                <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                                    data-animation-delay="200">
                                    <div style="max-width: 500px; margin:auto;">
                                        <canvas id="chart_per_gender"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center" style="width: 200px;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $body_gender; ?>
                            </tbody>
                            <tfoot>
                                <th class="text-center">Total</th>
                                <th class="text-right"><?php echo $total_gender; ?></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h2 class="text-center text-white">Grafik Disabilitas berdasarkan Usia</h2>
                    </div>
                    <div class="card-body">
                        <div class="container counting-inner">
                            <div class="row counting-box title-row" style="margin-bottom: 55px;">
                                <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                                    data-animation-delay="200">
                                    <div style="max-width: 500px; margin:auto;">
                                        <canvas id="chart_per_usia"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Usia</th>
                                    <th class="text-center" style="width: 200px;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $body_usia; ?>
                            </tbody>
                            <tfoot>
                                <th class="text-center">Total</th>
                                <th class="text-right"><?php echo $total_usia; ?></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success">
                        <h2 class="text-center text-white">Grafik Disabilitas berdasarkan Jenis Disabilitas</h2>
                    </div>
                    <div class="card-body">
                        <div class="container counting-inner">
                            <div class="row counting-box title-row" style="margin-bottom: 55px;">
                                <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                                    data-animation-delay="200">
                                    <div style="width: 100%; margin:auto;">
                                        <canvas id="chart_per_jenis"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Jenis Disabilitas</th>
                                    <th class="text-center" style="width: 200px;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $body_jenis; ?>
                            </tbody>
                            <tfoot>
                                <th class="text-center">Total</th>
                                <th class="text-right"><?php echo $total_jenis; ?></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h2 class="text-center text-white">Grafik Disabilitas berdasarkan Lokasi Desa</h2>
                    </div>
                    <div class="card-body">
                        <div class="container counting-inner">
                            <div class="row counting-box title-row" style="margin-bottom: 55px;">
                                <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                                    data-animation-delay="200">
                                    <div style="width: 100%; margin:auto;">
                                        <canvas id="chart_per_desa"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Desa</th>
                                    <th class="text-center" style="width: 200px;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $body_desa; ?>
                            </tbody>
                            <tfoot>
                                <th class="text-center">Total</th>
                                <th class="text-right"><?php echo $total_desa; ?></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo WP_DISABILITAS_PLUGIN_URL; ?>/public/js/chart.min.js"></script>
<script type="text/javascript">
window.chart_gender = <?php echo json_encode($chart_gender); ?>;
window.pieChartGender = new Chart(document.getElementById('chart_per_gender'), {
    type: 'pie',
    data: {
        labels: chart_gender.label,
        datasets: [
            {
                label: '',
                data: chart_gender.data,
                backgroundColor: chart_gender.color
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 16
                    }
                }
            },
            tooltip: {
                bodyFont: {
                    size: 16
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                boxPadding: 5
            },
        }
    }
});
window.chart_usia = <?php echo json_encode($chart_usia); ?>;
window.pieChartUsia = new Chart(document.getElementById('chart_per_usia'), {
    type: 'pie',
    data: {
        labels: chart_usia.label,
        datasets: [
            {
                label: '',
                data: chart_usia.data,
                backgroundColor: chart_usia.color
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 16
                    }
                }
            },
            tooltip: {
                bodyFont: {
                    size: 16
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                boxPadding: 5
            },
        }
    }
});
window.chart_jenis = <?php echo json_encode($chart_jenis); ?>;
window.pieChartJenis = new Chart(document.getElementById('chart_per_jenis'), {
    type: 'bar',
    data: {
        labels: chart_jenis.label,
        datasets: [
            {
                label: '',
                data: chart_jenis.data,
                backgroundColor: chart_jenis.color
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 0
                    }
                }
            },
            tooltip: {
                bodyFont: {
                    size: 16
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                boxPadding: 5
            },
        }
    }
});
window.desa = <?php echo json_encode($chart_desa); ?>;
window.pieChartDesa = new Chart(document.getElementById('chart_per_desa'), {
    type: 'bar',
    data: {
        labels: desa.label,
        datasets: [
            {
                label: '',
                data: desa.data,
                backgroundColor: desa.color
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 0
                    }
                }
            },
            tooltip: {
                bodyFont: {
                    size: 16
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                boxPadding: 5
            },
        }
    }
});
</script>