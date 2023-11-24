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

            <?php
            $images = $comic->url;
            if (!is_array($images)) {
                $images = array($images);
            }

            foreach ($images as $imageUrl) {
            ?>
            <img src="<?php echo $imageUrl; ?>" alt=""/>
            <?php
            }

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
            Plastic engine crypto-marketing bridge otaku rain assassin soul-delay garage range-rover singularity vehicle beef noodles shrine DIY Legba. Skyscraper-space narrative crypto-soul-delay paranoid kanji futurity euro-pop claymore mine nodality spook boat computer shrine monofilament. Neural assault footage neon knife savant dome. Boy assassin advert-ware augmented reality city refrigerator tube Shibuya footage. Assassin sentient hotdog Legba systema bridge shoes table advert silent man. Sub-orbital modem euro-pop boat Legba crypto-tattoo realism disposable woman.
            </p>
        </article>
    </body>
</html>
