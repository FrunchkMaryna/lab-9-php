<?php
$width = 800;
$height = 600;
$image = imagecreatetruecolor($width, $height);

// Кольори
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$red   = imagecolorallocate($image, 255, 0, 0);

$font = 'C:/xampp/htdocs/PHP_Labs/lab9/arial/arial.ttf';

if (!file_exists($font)) {
    die("❌ Файл шрифту не знайдено: $font");
}

imagefill($image, 0, 0, $white);

// Центр координат
$centerX = $width / 2;
$centerY = $height / 2;

// Ось X і Y
imageline($image, 0, $centerY, $width, $centerY, $black);
imageline($image, $centerX, 0, $centerX, $height, $black);

// Масштаб (1 радіан = 50px)
$scale = 50;

// Позначки π/2
for ($i = -6; $i <= 6; $i++) {
    $x = ($i * M_PI) / 2;
    $px = $centerX + $x * $scale;

    imageline($image, $px, $centerY - 5, $px, $centerY + 5, $black);

    if ($i == 0) {
        $label = '0';
    } elseif ($i == 1) {
        $label = 'π/2';
    } elseif ($i == -1) {
        $label = '-π/2';
    } elseif ($i % 2 == 0) {
        $label = ($i / 2) . 'π';
    } else {
        $numerator = abs($i);
        $sign = ($i < 0) ? '-' : '';
        $label = $sign . $numerator . 'π/2';
    }

    imagettftext($image, 12, 0, $px - 14, $centerY + 25, $black, $font, $label);
}

// Графік tan(x)
for ($px = 0; $px < $width; $px++) {
    $x = ($px - $centerX) / $scale;

    if (abs(cos($x)) < 0.01) continue;

    $y = tan($x);
    $py = $centerY - $y * $scale;

    if ($py >= 0 && $py < $height) {
        imagesetpixel($image, $px, $py, $red);
    }
}

header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
?>
