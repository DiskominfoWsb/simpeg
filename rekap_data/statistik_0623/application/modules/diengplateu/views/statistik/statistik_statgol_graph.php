
<script type="text/javascript">
    var options = {
        chart: {
            renderTo: 'graph-golongan',
            defaultSeriesType: 'column'
        },
        title: {
            text: 'Grafik PNS Berdasarkan Golongan - Juni 2023'
        },
        subtitle: {
            text: 'Source: e-simpeg.bkdwonosobo.go.id'
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            min:0,
            title: {
                text: 'Jumlah'
            }
        },
        legend: {
            /*layout: 'vertical',
            backgroundColor: '#FFFFFF',
            align: 'left',
            verticalAlign: 'top',
            x: 100,
            y: 70,
            floating: true,
            shadow: true*/

            layout: 'horizontal',
            backgroundColor: '#FFFFFF',
            align: 'center',
            verticalAlign: 'bottom',
            /*x: 100,*/
            y: 5,
            floating: false,
            shadow: true,
            enabled: true
        },
        series: []
    };

    $.ajax({
        url:'<?=base_url()?>diengplateu/graphGolongan',
        type:'post',
        data:{'idkategori': $('#idkategori').val(), 'idskpd': $('#idskpd').val()},
        beforeSend:function(){},
        success:function(data){
            var lines = data.split('\n');
            $.each(lines, function(lineNo, line) {
                var items = line.split(',');
                if(line!=''){
                    if (lineNo == 0) {
                        $.each(items, function(itemNo, item) {
                            if (itemNo > 0) options.xAxis.categories.push(item);
                        });
                    }else {
                        var series = {
                            data: []
                        };
                        $.each(items, function(itemNo, item) {
                            if (itemNo == 0) {
                                series.name = item;
                            } else {
                                series.data.push(parseFloat(item));
                            }
                        });
                        options.series.push(series);
                    }
                }
            });

            var chart = new Highcharts.Chart(options);
        }
    });
</script>

<div class="row">
    <div class="span5">
        <div id="graph-golongan" style="width:100%; height: 500px;"></div>
    </div>
</div>
