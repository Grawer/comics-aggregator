<html>
    <head>
        <title><?php echo $comic->sourceName; ?> - <?php echo $comic->date->format('Y-m-d'); ?></title>
    </head>
    <body>
        <h2><?php echo $comic->title; ?></h2>
        <img src="<?php echo $comic->url; ?>" alt=""/>
        <p><?php echo $comic->description; ?></p>
    </body>
</html>
