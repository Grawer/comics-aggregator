<html>
    <head>
        <meta charset="utf-8"/>
        <title><?php echo $comic->sourceName; ?> - <?php echo $comic->date->format('Y-m-d'); ?></title>
    </head>
    <body>
        <article>
            <h1><?php echo $comic->sourceName; ?> - <?php echo $comic->date->format('Y-m-d'); ?></h1>
            <h2><?php echo $comic->title; ?></h2>
            <img src="<?php echo $comic->url; ?>" alt=""/>
            <p><?php echo $comic->description; ?></p>
        </article>
    </body>
</html>
