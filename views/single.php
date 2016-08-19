<html>
    <head>
        <meta charset="utf-8"/>
        <title><?php echo $comic->sourceName; ?> - <?php echo $comic->date->format('Y-m-d'); ?></title>
    </head>
    <body>
        <article>
            <h1><?php echo $comic->sourceName; ?> - <?php echo $comic->date->format('Y-m-d'); ?></h1>
            <?php if (!empty($comic->title)) { ?>
            <h2><?php echo $comic->title; ?></h2>
            <?php } ?>
            <img src="<?php echo $comic->url; ?>" alt=""/>
            <p>
            <?php
                if (!empty($comic->description)) {
                    echo $comic->description;
                } else {
                    echo 'Comic id ' . $comic->id;
                }
            ?>
            </p>
        </article>
    </body>
</html>
