<?=$this->include('Layout/Header');?>
<div id="chart"></div>


<!-- online -->
<!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->

<!-- offline -->
<script src="<?=base_url('asset/js/jquery-3.6.1.min.js')?>"></script>
<script src="<?=base_url('asset/js/apexcharts.js')?>"></script>

<script>
  var options = {
    //series: [44, 55, 41, 17, 15],
    series: [<?php foreach ($list as $row):?><?= $row['stok']?>,<?php endforeach ?>],
    chart: {
      type: 'donut',
      width: '50%',
    },
    //labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],    
    labels: [<?php foreach ($list as $row):?>"<?= $row['judul']?>",<?php endforeach ?>],
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();

  //chart statis contoh 
  var options = {
        series: [{
            name: "Buku Merah",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        },
        {
            name: "Buku Biru",
            data: [20, 29, 37, 36, 44, 45, 50, 58, 200]
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Product Trends by Month',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


//chart dinamis buku
debugger;
var options = {
        series: [
        {name:"Buku",
          data:[<?php foreach ($list as $row):?><?= $row['stok']?>,<?php endforeach ?>]
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: 'Product Trends by Month',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: [<?php foreach ($list as $row):?>'<?= $row['judul']?>',<?php endforeach ?>],
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
</script>
<?= $this->endSection('content'); ?>


<?=$this->include('Layout/Modal');?>
<?=$this->include('Layout/Footer');?>