<?php
// مسیر فایل عکس
$imagePath = 'Gemini_Generated_Image_weqf2lweqf2lweqf.jpg';

// مسیر فونت فارسی
$fontPath = __DIR__ . '/Vazir.ttf'; // فونت مناسب فارسی

// بررسی وجود فونت
if (!file_exists($fontPath)) {
    die('فایل فونت پیدا نشد: ' . $fontPath);
}

// بررسی نوع فایل و انتخاب تابع مناسب
$fileInfo = getimagesize($imagePath);
if ($fileInfo === false) {
    die('فایل تصویر معتبر نیست');
}

switch ($fileInfo['mime']) {
    case 'image/jpeg':
        $image = imagecreatefromjpeg($imagePath);
        break;
    case 'image/png':
        $image = imagecreatefrompng($imagePath);
        break;
    default:
        die('فرمت تصویر پشتیبانی نمی‌شود (فقط JPEG و PNG)');
}

if ($image === false) {
    die('خطا در بارگذاری تصویر');
}

// تنظیم رنگ متن (قرمز)
$textColor = imagecolorallocate($image, 255, 0, 0);

// متن فارسی
$originalText = 'سلام دنیا';  // متن اصلی بدون تغییر

// تنظیمات فونت
$fontSize = 20;
$angle = 0;

// محاسبه اندازه متن
$bbox = imagettfbbox($fontSize, $angle, $fontPath, $originalText);
$textWidth = abs($bbox[2] - $bbox[0]);
$textHeight = abs($bbox[7] - $bbox[1]);

// مختصات متن (راست‌چین)
$x = imagesx($image) - $textWidth - 50; // از راست با فاصله 50 پیکسل
$y = 50 + $textHeight;

// نوشتن متن روی عکس
$result = imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $fontPath, $originalText);
if ($result === false) {
    die('خطا در نوشتن متن روی تصویر');
}

// تنظیم هدر
header('Content-type: ' . $fileInfo['mime']);

// نمایش تصویر
if ($fileInfo['mime'] == 'image/jpeg') {
    imagejpeg($image);
} elseif ($fileInfo['mime'] == 'image/png') {
    imagepng($image);
}

// آزاد کردن حافظه
imagedestroy($image);
?>
