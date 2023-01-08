<?= $this->extend('Dashboard') ?>
<?= $this->section('content') ?>
<?=session()->getFlashData('pesan-error');?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
<div class="container">
    <div class="mt-5">
        <div id="GooglePieChart" style="height: 600px; width: 100%"></div>
        <div id="GoogleLineChart" style="height: 600px; width: 100%"></div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('visualization', "1", {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawBarChart);
    
    function drawBarChart() {
        var data = google.visualization.arrayToDataTable([
            ['Nama Kelas', 'count'], 
                <?php 
                    foreach ($siswa as $row){
                        echo "['".$row['nama_kelas']."',".$row['count']."],";
                    }
                ?>
        ]);

        var options = {
            title: ' Pie chart data',
            is3D: true,
        };
        var chart = new google.visualization.PieChart(document.getElementById('GooglePieChart'));
        chart.draw(data, options);
    }


    google.charts.setOnLoadCallback(drawLineChart);
    
    function drawLineChart() {
        var data = google.visualization.arrayToDataTable([
            ['Nama Kelas', 'count'], 
                <?php 
                    foreach ($bayar as $row){
                        echo "['".$row['nominal']."',".$row['count']."],";
                    }
                ?>
        ]);

        var options = {
            title: ' Line chart data',
            is3D: true,
        };
        var chart = new google.visualization.LineChart(document.getElementById('GoogleLineChart'));
        chart.draw(data, options);
    }
</script>

<?=$this->endSection();?>