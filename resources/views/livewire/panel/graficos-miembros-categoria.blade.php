<div class="card">
    <div class="card-header">Miembros por Categoría {{ $sexo }}</div>
    <div class="card-body">
        <form>
            <input type="radio" name="sexo" wire:click.defer='$set("sexo","F")'>Femenino
            <input type="radio" name="sexo" wire:click.defer='$set("sexo","M")'>Masculino
            <button type="button">Aplicar</button>
        </form>
        <div>
            <canvas id='grafico-miembros-categoria'></canvas>
        </div>
    </div>
</div>
<script>
    const cData2 = @json($dataPerfilEdad);
    // console.log(cData);
    const ctx2 = document.getElementById('grafico-miembros-categoria').getContext('2d');
    const myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: cData2.label,
            datasets: [{
                label: 'Miembros',
                data: cData2.value,
                backgroundColor: [
                    "#D7FF33",
                    "#33FF39",
                    '#33B5FF',
                    '#6133FF',
                    '#FF33CA',
                    '#FF3333',
                    '#A8FF33',
                    '#138D75',
                    '#273746'




                ],
                borderWidth: 1
            }]

        },
        options: {
            responsive: true,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }

        }

    });
    window.addEventListener('actualizar', event => {
        // console.log(myChart2.config.data.labels);
        // console.log(myChart2.config.data.datasets[0].data); 
        myChart2.config.data.labels=event.detail.data2.label;
        myChart2.config.data.datasets[0].data=event.detail.data2.value
        myChart2.update();
        // myChart2.update({
        //     labels: [event.detail.data.label],
        //     data: [event.detail.data.value],

        // });
    })
</script>
