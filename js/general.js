$(document).ready(function () {
    $('.js-add-file').on('change', function (event, files, label) {
        const file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '');

        $(this).siblings('label').empty().text(file_name);
    });

    $('#form').submit((e) => {
        e.preventDefault();
        let file_data;
        let form_data = new FormData();

        $('.js-add-file').map(function (value, index) {
            file_data = $(this).prop('files')[0];
            form_data.append('file_' + value, file_data);
            form_data.append('action', 'calcInnovativePotential');
        })

        $.ajax({
            type: "POST",
            url: my_ajax_object.ajax_url,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            data: form_data,
            complete: function (responce) {
                const currentStr = responce.responseText.replace(/INF\W/g,"0"); 
                const allCoordinate = currentStr.split('Array');
                const date = [];
            
                for(let i = 1; allCoordinate.length > i; i++) {
                    window['graph'+i] = allCoordinate[i].split(/[^\d\.]/g).filter(element => element !== "");
                }

                for(let i = 0; window.graph1.length > i; i++) {
                    if(i%2 === 0) {
                        date.push(window.graph1[i])
                    }
                }

                const coordinateIPSmall = createArrayCoordinates(graph1);
                const coordinateIPAverage = createArrayCoordinates(graph2);
                const coordinateIPBig = createArrayCoordinates(graph3);

                create(coordinateIPSmall,coordinateIPAverage,coordinateIPBig,date)
            }
        });
    });

    function createArrayCoordinates(graph) {
        const coordinate = [];

        for(let i = 0; graph.length > i; i++) {
            if(i%2 !== 0) {
                coordinate.push(graph[i])
            } 
        }

        return coordinate;
    }

    function create (coordinateIPSmall, coordinateIPAverage, coordinateIPBig,date) {
         speedCanvas = document.getElementById("innovativePotential");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;

        var dataFirst = {
            label: "Иновационный потенциал малых предприятий",
            data: coordinateIPSmall,
            lineTension: 0,
            fill: false,
            pointStyle: 'rectRounded',
            backgroundColor: 'red',
            borderColor: 'red'
        };

        var dataSecond = {
            label: "Иновационный потенциал средних предприятий",
            data: coordinateIPAverage,
            lineTension: 0,
            fill: false,
            backgroundColor: 'blue',
            borderColor: 'blue'
        };

        var dataThird = {
            label: "Иновационный потенциал крупных предприятий",
            data: coordinateIPBig,
            lineTension: 0,
            fill: false,
            backgroundColor: 'green',
            borderColor: 'green'
        };

        var speedData = {
        labels: date,
        datasets: [dataFirst, dataSecond, dataThird]
        };

        var chartOptions = {
        legend: {
            display: true,
            position: 'top',
            labels: {
            boxWidth: 20,
            fontColor: 'black'
            }
        }
        };

        var lineChart = new Chart(speedCanvas, {
        type: 'line',
        data: speedData,
        options: chartOptions
        });
    }
});