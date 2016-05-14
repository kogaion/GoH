<!doctype HTML>
<html>
<head>
    <title>Game of Codes - Avangate Ladderboard</title>

    <meta charset="UTF-8">

    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700,400italic' rel='stylesheet' type='text/css'>

    <?php echo css_asset('bootstrap.min.css') . PHP_EOL; ?>
    <?php echo css_asset('goc-theme.css') . PHP_EOL; ?>
    <?php echo css_asset('defaults.css') . PHP_EOL; ?>
    <?php echo css_asset('top/top.css') . PHP_EOL; ?>

</head>
<body>
<div class="container">

    <table id="rank_table" class="table">
        <tr>
            <th colspan="5">
                <h1>This week's performers</h1>
            </th>
        </tr>
        <tr>
            <th class="right">#</th>
            <th class="">Avatar</th>
            <th class="">Name</th>
            <th>Level</th>
            <?php /* <th>Experience</th> */ ?>
            <th>Progress</th>
        </tr>

        <?php foreach ($best as $key => $person) { ?>
            <?php if ($key < 3) { ?>
                <tr>
                    <td class="right"><?= $key + 1 ?></td>
                    <td><?= image_asset('gravatars/' . $person['image'], "", array('width' => '100px')) ?></td>
                    <td><span class="name"><?= $person['name'] ?></span></td>
                    <td><?= image_asset($person['rank_image'], "", ['height' => '39px']) ?> <?= $person['rank'] ?></td>
                    <?php /* <td><?= $person['score'] ?></td> */ ?>
                    <td><span
                            class="glyphicon glyphicon-chevron-<?= $person['progress_relative'] ?>"></span> <?= $person['progress'] ?>
                    </td>
                </tr>

            <?php } else {
                if ($key > (count($best) - 4)) { ?>
                    <tr>
                        <td class="right"><?= $key + 1 ?></td>
                        <td><?= image_asset('gravatars/' . $person['image'], "", array('width' => '100px')) ?></td>
                        <td><span class="name"><?= $person['name'] ?></span></td>
                        <td><?= image_asset($person['rank_image'], "", ['height' => '39px']) ?> <?= $person['rank'] ?></td>
                        <?php /* <td><?= $person['score'] ?></td> */ ?>
                        <td><span
                                class="glyphicon glyphicon-chevron-<?= $person['progress_relative'] ?>" style="color:red !important; "></span> <?= $person['progress'] ?>
                        </td>
                    </tr>
                <?php } else {
                    if (count($best) > 3 && $key == 3) { ?>
                        <tr>
                            <td class="separator center" colspan="<?= count($best) + 3 ?>">
                                <span class="glyphicon glyphicon-certificate"></span>
                                <span class="glyphicon glyphicon-certificate"></span>
                                <span class="glyphicon glyphicon-certificate"></span>
                            </td>
                        </tr>
                    <?php } else {
                        if (0) { ?>

                        <?php }
                    }
                }
            } ?>
        <?php } ?>


    </table>

</div>
<?php echo js_asset('jquery-2.2.3.min.js') . PHP_EOL; ?>
<?php echo js_asset('bootstrap.min.js') . PHP_EOL; ?>
<?php echo js_asset('top/top.js') . PHP_EOL; ?>
</body>
</html>