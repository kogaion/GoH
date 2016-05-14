<!doctype HTML>
<html>
    <head>
        <title>Game of Codes - Avangate Ladderboard</title>

        <meta charset="UTF-8">

        <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic' rel='stylesheet' type='text/css'>

        <?php echo css_asset('bootstrap.min.css') . PHP_EOL;?>
        <?php echo css_asset('goc-theme.css') . PHP_EOL;?>
        <?php echo css_asset('defaults.css') . PHP_EOL;?>
        <?php echo css_asset('top/top.css') . PHP_EOL;?>

    </head>
    <body>
    <div class="container-fluid">

        <table class="table table-striped">
            <tr>
                <th>Rank</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Score</th>
                <th>Progress</th>
            </tr>
            <tr>
                <?php foreach ( $people as $key => $person ) { ?>
                    <td><?=$key?></td>
                    <td><?=image_asset('gravatars/' . $person['image'], "", array('width' => '100px'))?></td>
                    <td><?=$person['name']?></td>
                    <td><?=$person['score']?></td>
                    <td><?=$person['progress']?></td>
                <?php } ?>

            </tr>

        </table>


    </div>
        <?php echo js_asset('jquery-2.2.3.min.js') . PHP_EOL;?>
        <?php echo js_asset('bootstrap.min.js') . PHP_EOL;?>
        <?php echo js_asset('top/top.js') . PHP_EOL;?>
    </body>
</html>