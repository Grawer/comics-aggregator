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
            <?php
                if (!empty($comic->description)) {
            ?>
            <p>
            <?php
                    echo $comic->description;
            ?>
            </p>
            <?php
                }
            ?>
            <p>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
            </p>
            <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.            
            </p>
        </article>
    </body>
</html>
