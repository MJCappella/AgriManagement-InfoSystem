<?php
header('Content-Type: image/png');

// Create a blank image
$width = 1000;
$height = 600;
$image = imagecreatetruecolor($width, $height);

// Define colors
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$colors = [
    'productA' => imagecolorallocate($image, 70, 130, 180),
    'productB' => imagecolorallocate($image, 34, 139, 34),
    'productC' => imagecolorallocate($image, 255, 69, 0),
];

// Fill background with white
imagefill($image, 0, 0, $white);

// Sample data
$data = [
    ['date' => '2024-01-01', 'productA' => 60 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 90 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 90 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-02-01', 'productA' => 60 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 70 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 130 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-03-01', 'productA' => 45 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 90 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 130 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-04-01', 'productA' => 55 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 90 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 90 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-05-01', 'productA' => 55 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 70 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 130 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-06-01', 'productA' => 60 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 90 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 90 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-07-01', 'productA' => 60 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 90 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 130 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-08-01', 'productA' => 72 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 52 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 78 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-09-01', 'productA' => 65 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 85 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 95 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-10-01', 'productA' => 70 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 75 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 100 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-11-01', 'productA' => 68 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 80 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 110 + mt_rand(0, 20) / mt_getrandmax() * 20],
    ['date' => '2024-12-01', 'productA' => 75 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productB' => 85 + mt_rand(0, 20) / mt_getrandmax() * 20, 'productC' => 120 + mt_rand(0, 20) / mt_getrandmax() * 20],
];

// Compute chart limits
$maxValue = 0;
foreach ($data as $point) {
    foreach ($point as $key => $value) {
        if ($key !== 'date' && $value > $maxValue) {
            $maxValue = $value;
        }
    }
}

// Chart settings
$barWidth = 50;
$barSpacing = 30;
$xOffset = 60;
$yOffset = 50;
$chartWidth = $width - 2 * $xOffset;
$chartHeight = $height - 2 * $yOffset;

// Draw bars
$xPos = $xOffset;
foreach ($data as $index => $point) {
    $barHeightA = ($point['productA'] / $maxValue) * $chartHeight;
    $barHeightB = ($point['productB'] / $maxValue) * $chartHeight;
    $barHeightC = ($point['productC'] / $maxValue) * $chartHeight;

    // Draw bars
    imagefilledrectangle($image, $xPos, $height - $yOffset - $barHeightA, $xPos + $barWidth, $height - $yOffset, $colors['productA']);
    imagefilledrectangle($image, $xPos + $barWidth + $barSpacing, $height - $yOffset - $barHeightB, $xPos + 2 * $barWidth + $barSpacing, $height - $yOffset, $colors['productB']);
    imagefilledrectangle($image, $xPos + 2 * ($barWidth + $barSpacing), $height - $yOffset - $barHeightC, $xPos + 3 * $barWidth + 2 * $barSpacing, $height - $yOffset, $colors['productC']);

    // Draw month labels
    imagestring($image, 3, $xPos + $barWidth / 2 - 10, $height - $yOffset + 10, date('M', strtotime($point['date'])), $black);

    $xPos += 3 * $barWidth + 2 * $barSpacing;
}

// Draw x and y axes
imageline($image, $xOffset, $height - $yOffset, $width - $xOffset, $height - $yOffset, $black);
imageline($image, $xOffset, $height - $yOffset, $xOffset, $yOffset, $black);

// Draw scale labels
$scaleStep = $maxValue / 10;
for ($i = 0; $i <= 10; $i++) {
    $yPos = $height - $yOffset - ($i * ($chartHeight / 10));
    imageline($image, $xOffset - 5, $yPos, $xOffset, $yPos, $black);
    imagestring($image, 3, $xOffset - 40, $yPos - 5, round($scaleStep * $i), $black);
}

// Draw chart title
imagestring($image, 5, $width / 2 - 60, $yOffset / 2 - 10, "Average Product Prices Over Time", $black);

// Draw legends
$legendX = $width - $xOffset + 20;
$legendY = $yOffset;
imagestring($image, 5, $legendX, $legendY, "Product A", $colors['productA']);
imagestring($image, 5, $legendX, $legendY + 20, "Product B", $colors['productB']);
imagestring($image, 5, $legendX, $legendY + 40, "Product C", $colors['productC']);

$legendBarWidth = 15;
$legendBarHeight = 15;
imagefilledrectangle($image, $legendX - 20, $legendY, $legendX - 5, $legendY + $legendBarHeight, $colors['productA']);
imagefilledrectangle($image, $legendX - 20, $legendY + 20, $legendX - 5, $legendY + 20 + $legendBarHeight, $colors['productB']);
imagefilledrectangle($image, $legendX - 20, $legendY + 40, $legendX - 5, $legendY + 40 + $legendBarHeight, $colors['productC']);

// Output the image
imagepng($image);
imagedestroy($image);
?>
