<?php
include_once "library/inc.seslogin.php";

?>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

               <div class="col-lg-12">
                        <div class="card-header">
                            <h4>Jumlah Obat Yang Terjual</h4>
                        </div>
                        <div class="col-8">
                    <div class="card">

                        <div class="card-body">

                                  <canvas id="myChart" width="200" height="200"></canvas>
                                  </div>
                                  </div>
                    </div>
                </div>
        </div>
    </div>

<?php
    // Koneksikan ke database
    $kon = mysqli_connect("localhost","root","","inovaklinik");

    $nama_jurusan= "";
    $jumlah=null;
    //Query SQL
    $sql="select nm_obat,COUNT(*) as 'total' from resep_item join obat on resep_item.kd_obat= obat.kd_obat  GROUP by resep_item.kd_obat";
    $hasil=mysqli_query($kon,$sql);

    while ($data = mysqli_fetch_array($hasil)) {
        //Mengambil nilai jurusan dari database
        $jur=$data['nm_obat'];
        $nama_jurusan .= "'$jur'". ", ";
        //Mengambil nilai total dari database
        $jum=$data['total'];
        $jumlah .= "$jum". ", ";

    }
    ?>

<script src="js/Chart.js"></script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        // The data for our dataset
        data: {
            labels: [<?php echo $nama_jurusan; ?>],
            datasets: [{
                label:'Jumlah Obat Terjual ',
                backgroundColor: ['rgb(255, 99, 132)', 'rgba(56, 86, 255, 0.87)', 'rgb(60, 179, 113)','rgb(175, 238, 239)'],
                borderColor: ['rgb(255, 99, 132)'],
                data: [<?php echo $jumlah; ?>]
            }]
        },

        // Configuration options go here
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>