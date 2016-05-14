<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
        }
        #table_content {
            font-family: Arial;
            font-size: 14px;
            width:100%;
            background-color: #232659;
            color: #ffffff;
        }

        #table {
            width: 800px;
            margin: 20px 0 50px;
        }

        #table th,
        #table td {
            background-color: #424b7a;
            border: 1px solid #1a1a55;
            text-align: left;
        }
        table {
            border-collapse: collapse;
            color: #ffffff;
        }
        table.one {
            width: 100%;
        }


    </style>

    <table id="table_content">
        <tr>
            <td align="center">

                <br><br>
                <table id="table">
                    <tr>
                        <td>

                            <p style="margin: 4px">
                                Daca acest email nu se afiseaza corect va rugam sa-l vizualizati in fereastra de browser accesand <a style="color: #fff; text-decoration: underline" href="<?=$base_url?>">acest link</a>
                            </p>

                            <h1 style="margin: 10px 10px">Weekly GoC Progress</h1>


                            <table class="one">
                                <tr>
                                    <td colspan="2" style="background-color: #EEBF42; color: #000; font-size: 20px;">Best projects</td>
                                </tr>
                                <?php foreach ( $projectsEvolution as $project ){ ?>
                                <tr>
                                    <td colspan="2">
                                        <h2><?=$project['Name']?> (<?=$project['points']?> pts)</h2>
                                        <p><?=$project['Description']?></p>
                                    </td>
                                </tr>

                                <?php } ?>
                            </table>
                            <br>
                            <br>



                            <table class="one">
                                <tr>
                                    <td colspan="4" style="background-color: #EEBF42; color: #000; font-size: 20px;">All time ladderboard</td>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Points</th>
                                    <th>Rank</th>
                                </tr>
                                <?php foreach ( $allTime as $key => $user ){ ?>
                                    <tr>
                                        <td><?=$key+1?></td>
                                        <td><?=$user['Name']?></td>
                                        <td><?=$user['XpPoints']?></td>
                                        <td><?=$user['Rank']?></td>
                                    </tr>

                                <?php } ?>
                            </table>

                        </td>
                    </tr>

                </table>
                <br><br><br>
            </td>
        </tr>


    </table>


</body>
</html>
<?php

