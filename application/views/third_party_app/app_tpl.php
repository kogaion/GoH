<html>
<head>
    <title>3rd party app</title>
    <?php echo css_asset('bootstrap.min.css') . PHP_EOL; ?>
    <?php echo css_asset('fonts.css') . PHP_EOL; ?>
    <?php echo css_asset('bootstrap-theme.css') . PHP_EOL; ?>
    <?php echo js_asset('jquery-2.2.3.min.js') . PHP_EOL; ?>
    <?php echo js_asset('bootstrap.min.js') . PHP_EOL; ?>


    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic' rel='stylesheet' type='text/css'>


</head>
<body>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

    <?php foreach ($projects as $projectIndex => $project) : ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?php echo $projectIndex;?>">
                <h4 class="panel-title">
                    <a class="<?php echo $projectIndex == 0 ? "" : "collapsed"; ?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $projectIndex;?>"
                       aria-expanded="<?php echo $projectIndex == 0 ? "true" : "false"; ?>" aria-controls="collapse<?php echo $projectIndex;?>">
                        <?php echo ucfirst($project['Name']); ?>
                        <span class="label label-<?php echo $project['points'] > 0 ? 'success' : 'info'; ?>" style="float:right; margin:0px 8px">project points  <?php echo $project['points']; ?> <span class="glyphicon glyphicon-star" aria-hidden="true"></span></span>
                        <span class="label label-<?php echo $project['contrib'] > 0 ? 'danger' : 'danger'; ?>" style="float:right"> contributors  <?php echo $project['contrib']; ?> <span aria-hidden="true" class="glyphicon glyphicon-user"></span></span>



                    </a>
                </h4>
            </div>
            <div id="collapse<?php echo $projectIndex;?>" class="panel-collapse collapse <?php echo $projectIndex == 0 ? "in" : ""; ?>" role="tabpanel" aria-labelledby="heading<?php echo $projectIndex;?>">
                <div class="panel-body">
                    <p>
                        <?php echo $project['Description']; ?>
                    </p>

                    <img src="<?php echo image_asset_url('top-images/graph_' . $project['IdProject'] . '.jpg') ;?>" />
                </div>
            </div>
        </div>

    <?php endforeach; ?>


</div>


<script type="text/javascript" src="https://secure.avangate.com/cpanel/js/third-party-apps/avangate.js"></script>
<div id="avangate-hero" class="hide"></div>
<script type="text/javascript">
    var app = {
        cPanel: false,
        appID: '573600B517FB8',

        init: function () {
            this.cPanel = avangateCPanel;
            if (this.cPanel.init(this.appID)) {
                console.log('everything is ready to be used');
            }
        }
    };
    app.init();

    app.cPanel.callParent().setAppStartPoint();
    app.cPanel.callParent().setCanvasHeight();
    app.cPanel.callParent().setScrollTopTo();
</script>
</body>
</html>