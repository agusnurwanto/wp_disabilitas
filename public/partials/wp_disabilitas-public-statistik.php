<?php
global $wpdb;
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

}
ksort($usia);
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
foreach($usia as $k => $v){
    $jumlah = count($v);
    $total_usia += $jumlah;
    if($k == 'Tidak diketahui'){
        $jenis = $k;
    }else{
        $jenis = $k.' tahun';
    }
    $chart_usia['label'][] = $jenis;
    $chart_usia['data'][] = $jumlah;
    $chart_usia['color'][] = "";
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
foreach($jenis_disabilitas as $k => $v){
    $jumlah = count($v);
    $total_jenis += $jumlah;
    $jenis = $k;
    $chart_jenis['label'][] = $jenis;
    $chart_jenis['data'][] = $jumlah;
    $chart_jenis['color'][] = "";
    $body_jenis .= "
        <tr>
            <td>$jenis</td>
            <td class='text-right'>$jumlah</td>
        </tr>
    ";
}
?>
<div class="cetak">
    <div style="padding: 10px;">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Data Statistik Disabilitas</h1>
                <h2 class="text-center">Total Disabilitas = <?php echo $total_data; ?> Orang</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-center">Grafik Disabilitas berdasarkan Gender</h2>
                <div class="container counting-inner">
                    <div class="row counting-box title-row" style="margin-bottom: 55px;">
                        <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                            data-animation-delay="200">
                            <div style="width: 300px; margin:auto;">
                                <canvas id="chart_per_gender"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Jumlah</th>
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
            <div class="col-md-6">
                <h2 class="text-center">Grafik Disabilitas berdasarkan Usia</h2>
                <div class="container counting-inner">
                    <div class="row counting-box title-row" style="margin-bottom: 55px;">
                        <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                            data-animation-delay="200">
                            <div style="width: 300px; margin:auto;">
                                <canvas id="chart_per_usia"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Usia</th>
                            <th class="text-center">Jumlah</th>
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
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Grafik Disabilitas berdasarkan Jenis Disabilitas</h2>
                <div class="container counting-inner">
                    <div class="row counting-box title-row" style="margin-bottom: 55px;">
                        <div class="col-md-12 text-center animated" data-animation="fadeInBottom"
                            data-animation-delay="200">
                            <div style="width: 300px; margin:auto;">
                                <canvas id="chart_per_jenis"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Jenis Disabilitas</th>
                            <th class="text-center">Jumlah</th>
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
<script type="text/javascript" src="<?php echo WP_DISABILITAS_PLUGIN_URL; ?>/public/js/chart.min.js"></script>
<script type="text/javascript">
window.chart_gender = <?php echo json_encode($chart_gender); ?>;
window.pieChart = new Chart(document.getElementById('chart_per_gender'), {
    type: 'pie',
    data: {
        labels: chart_jenis_disabilitas.label,
        datasets: [
            {
                label: '',
                data: chart_jenis_disabilitas.data,
                backgroundColor: chart_jenis_disabilitas.color
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
</script>