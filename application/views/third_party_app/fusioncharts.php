

<?php echo js_asset('fusioncharts/fusioncharts.js') . PHP_EOL;?>
<?php echo js_asset('fusioncharts/fusioncharts.widgets.js') . PHP_EOL;?>
<?php echo js_asset('fusioncharts/themes/fusioncharts.theme.fint.js') . PHP_EOL;?>


<script type="text/javascript">

  FusionCharts.ready(function(){
    var fusioncharts = new FusionCharts({
        type: 'angulargauge',
        renderAt: 'chart-container',
        width: '400',
        height: '250',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                //"caption": "Project Quality",
                "subcaption": "Last week evolution - " + <?php echo json_encode($title) ?>,
                "lowerLimit": "0",
                "upperLimit": "500",
                "lowerLimitDisplay": "Bad",
                "upperLimitDisplay": "Good",
                "showValue": "1",
                "valueBelowPivot": "1",
                "theme": "fint",
                'animation':0
            },
            "colorRange": {
                "color": [{
                    "minValue": "0",
                    "maxValue": "150",
                    "code": "#e44a00"
                }, {
                    "minValue": "150",
                    "maxValue": "300",
                    "code": "#f8bd19"
                }, {
                    "minValue": "300",
                    "maxValue": "500",
                    "code": "#6baa01"
                }]
            },
            "dials": {
                "dial": [{
                    "value": "<?php echo $gauge ?>"
                }]
            }
        }
    }
    );
    fusioncharts.render();
});
</script>

<div id="chart-container">FusionCharts XT will load here!</div>



<!--

<html>
<head>
    <title>3rd party app - image</title>

</head>
<body>


<script type="text/javascript" src="/js/fusioncharts/fusioncharts.js"></script>
<script type="text/javascript" src="/js/fusioncharts/fusioncharts.widgets.js"></script>

<div id="<?php echo ($GRAPH_ID) ?>" class="fusionCharts"></div>

<script type="text/javascript">

    FusionCharts.ready(function () {
        var chart = new FusionCharts({
            "type": <?php echo json_encode($GRAPH_PARAMS['type']) ?>,
            "renderAt": <?php echo json_encode($GRAPH_ID) ?>,
            "width": '' + <?php echo json_encode($GRAPH_PARAMS['width']) ?>,
            "height": '' + <?php echo json_encode($GRAPH_PARAMS['height']) ?>, 
            "dataFormat": 'json',
            "dataSource": '' + <?php echo json_encode($GRAPH_PARAMS['data']) ?>
        });
        chart.render();
        $.data( $('#'+ <?php echo json_encode($GRAPH_ID) ?>)[0], 'fusion-charts-graph', chart);
  });
  
</script>
    
</body>
</html>





-->

