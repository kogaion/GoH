<html>
<head>
    <title>3rd party app</title>

</head>
<body>
    <p>3rd party app cu metrici si nebunii</p>
    <script type="text/javascript" src="https://secure.avangate.com/cpanel/js/third-party-apps/avangate.js"></script>
    <div id="avangate-hero" class="hide"></div>
    <script type="text/javascript">
        var app = {
            cPanel  : false,
            appID   : '573600B517FB8',

            init : function()
            {
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