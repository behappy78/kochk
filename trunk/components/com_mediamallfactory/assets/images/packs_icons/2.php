<?php

header("Content-type: image/png");

$text = "600";
$im     = imagecreatefrompng("gold.png");
imagesavealpha($im, true);
$color = imagecolorallocate($im, 51, 51, 51);
$font = '../../fonts/georgiaz.ttf';
imagettftext($im, 48, 0, 183, 73, $color, $font, $text);
imagepng($im);
imagedestroy($im);

?>