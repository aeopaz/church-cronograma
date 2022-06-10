<div class="card">
    <div class="card-header">Miembros por Sexo</div>
    <div class="card-body">
        <div>
            <canvas id='grafico-miembros'></canvas>
        </div>
    </div>
</div>
<script>
    const cData = @json($dataSexo);
    // console.log(cData);
    const ctx = document.getElementById('grafico-miembros').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: cData.label,
            datasets: [{
                label: 'Miembros',
                data: cData.value,
                backgroundColor: [
                    "#4C2882",
                    "#3B83BD",
                ],
                borderWidth: 1
            }]

        },
        // options:{
        //     responsive: true,
        //     scales:{
        //         yAxes:[{
        //             ticks:{
        //                 beginAtZero:true
        //             }
        //         }]
        //     }

        // }

    });
    console.log(myChart.canvas);
    estilos = myChart.canvas.style;
    window.addEventListener('actualizar', event => {

        // console.log(myChart2.config.data.labels);
        // console.log(myChart2.config.data.datasets[0].data); 
        myChart.config.data.labels = event.detail.data1.label;
        myChart.config.data.datasets[0].data = event.detail.data1.value
        // myChart.chartArea.top=32
        // myChart.chartArea.right=604
        // myChart.chartArea.bottom=302
        // myChart.chartArea.left=0

        // myChart.canvas.style='display: block; width:auto; height:auto;';
        // myChart.canvas.classList.add("chartjs-render-monitor");
        myChart.update();
        console.log(myChart.canvas);
        canvas = document.getElementById('grafico-miembros');
        // ctx = canvas.getContext('2d');
        canvas.style.width = '1000px'; // explicitly setting its unit 'px'
        canvas.style.height = '260px';
        // myChart2.update({
        //     labels: [event.detail.data.label],
        //     data: [event.detail.data.value],

        // });
    })
</script>
