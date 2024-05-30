<h1><?php echo $comic->sourceName; ?> - <?php echo $comic->date->format('Y-m-d'); ?></h1>
<?php if (!empty($comic->title)) { ?>
<h2><?php echo $comic->title; ?></h2>
<?php } ?>

<?php

$images = $comic->url;
if (!is_array($images)) {
    $images = array($images);
}

foreach ($images as $i => $imageUrl) {
?>
<img src="cid:image-<?php echo $i; ?>" alt=""/>
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
