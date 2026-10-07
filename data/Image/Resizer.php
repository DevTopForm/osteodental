<?php

namespace App\Image;

use App\Image;
use App\Registry;
use Exception;

class Resizer
{

    private static $sizes = [];

    public $d_w = 0;
    public $d_h = 0;
    public $transparency = true;
    public $source;
    public $folder;

    public $x1 = 0;
    public $y1 = 0;
    public $x2 = 100;
    public $y2 = 100;

    public $set_wmark = 0;

    public function __construct()
    {
    }

    public function run()
    {
        if (empty($this->source) || empty($this->folder) || !is_file($this->source)) {
            return;
        }
        $pathParts = explode('.', basename($this->source));
        $ext = array_pop($pathParts);
        if (($ext == 'jpeg') || ($ext == 'jpg')) {
            $img = @imagecreatefromjpeg($this->source);
        } elseif ($ext == 'png') {
            $img = @imagecreatefrompng($this->source);
        } elseif ($ext == 'gif') {
            $img = @imagecreatefromgif($this->source);
        } elseif ($ext == 'webp') {
            $img = imagecreatefromwebp($this->source);
        } elseif ($ext == 'svg') {
            $img = file_get_contents($this->source);
            file_put_contents($this->folder . basename($this->source), $img);
            return [];
        } else {
            throw new Exception("Wrong image extension: ." . $ext);
        }
        if (!$img) {
            throw new Exception("Image creation problem");
        }

        $s_w = imageSX($img); //original
        $s_h = imageSY($img);
        $d_w = ($this->d_w > $s_w) ? $s_w : $this->d_w;
        $d_h = ($this->d_h > $s_h) ? $s_h : $this->d_h;


        if (empty($d_w) && empty($d_h)) {
            $d_w = $s_w;
            $d_h = $d_h;
        }

        // коеффициент пропорциональности (отношение ширины к высоте) исходного изображения
        $k_s = $s_w / $s_h;
        // множитель по ширине (если ширина превью не указана, то такой же как и по высоте)
        $k_w = empty($d_w) ? ($s_h / $d_h) : ($s_w / $d_w);
        // множитель по высоте (если высота превью не указана, то такой же как и по ширине)
        $k_h = empty($d_h) ? ($s_w / $d_w) : ($s_h / $d_h);

        $new_d_w = empty($d_w) ? round($s_w / $k_w) : $d_w;
        $new_d_h = empty($d_h) ? round($s_h / $k_h) : $d_h;

        // коеффициент пропорциональности (отношение ширины к высоте) превью
        $k_d = $new_d_w / $new_d_h;


        if (($k_w < 1) && ($k_h < 1)) { //исходное изображение меньше превью
            $from_x1 = 0;
            $from_y1 = 0;
            $from_x2 = $s_w;
            $from_y2 = $s_h;
            $to_x1 = 0;
            $to_y1 = 0;
            $to_x2 = $s_w;
            $to_y2 = $s_h;
        } elseif (($k_w < 1) && ($d_w == 0)) { //ширина исходного изображения меньше ширины превью
            $from_x1 = 0;
            $from_y1 = 0;
            $from_x2 = $s_w;
            $from_y2 = $s_h;
            $to_x1 = 0;
            $to_y1 = 0;
            $to_x2 = round($s_w / $k_h);
            $to_y2 = $new_d_h;
        } elseif (($k_h < 1) && ($d_h == 0)) {//высота исходного изображения меньше высоты превью
            $from_x1 = 0;
            $from_y1 = 0;
            $from_x2 = $s_w;
            $from_y2 = $s_h;
            $to_x1 = 0;
            $to_y1 = 0;
            $to_x2 = $new_d_w;
            $to_y2 = round($s_h / $k_w);
        } elseif ($k_s == $k_d) { //пропорции исходного изображения и превью полностью совпадают
            $from_x1 = 0;
            $from_y1 = 0;
            $from_x2 = $s_w;
            $from_y2 = $s_h;
            $to_x1 = 0;
            $to_y1 = 0;
            $to_x2 = $new_d_w;
            $to_y2 = $new_d_h;
        } elseif ($k_s > $k_d) { //лишнее по ширине
            $from_w = round($new_d_w * $k_h);
            $w_dif = floor(($s_w - $from_w) / 2);
            $from_x1 = $w_dif;
            $from_y1 = 0;
            $from_x2 = $from_w; // берем множитель высоты и высчитываем ширину
            $from_y2 = $s_h;
            $to_x1 = 0;
            $to_y1 = 0;
            $to_x2 = $new_d_w;
            $to_y2 = $new_d_h;
        } else { //лишнее по высоте
            $from_h = round($new_d_h * $k_w);
            $h_dif = floor(($s_h - $from_h) / 2);
            $from_x1 = 0;
            $from_y1 = $h_dif;
            $from_x2 = $s_w;
            $from_y2 = $from_h; // берем множитель ширины и высчитываем высоту
            $to_x1 = 0;
            $to_y1 = 0;
            $to_x2 = $new_d_w;
            $to_y2 = $new_d_h;
        }

        $new_img = imagecreatetruecolor($to_x2, $to_y2);

        if ($this->transparency) {
            if ($ext == 'png') {
                imagealphablending($new_img, false);
                $colorTransparent = imagecolorallocatealpha($new_img, 0, 0, 0, 127);
                imagefill($new_img, 0, 0, $colorTransparent);
                imagesavealpha($new_img, true);
            } elseif ($ext == 'gif') {
                $trnprt_indx = imagecolortransparent($img);

                if ($trnprt_indx >= 0) {
                    $trnprt_color = imagecolorsforindex($img, $trnprt_indx);
                    $trnprt_indx = imagecolorallocate(
                        $new_img,
                        $trnprt_color['red'],
                        $trnprt_color['green'],
                        $trnprt_color['blue']
                    );
                    imagefill($new_img, 0, 0, $trnprt_indx);
                    imagecolortransparent($new_img, $trnprt_indx);
                }
            }
        } else {
            imagefill($new_img, 0, 0, imagecolorallocate($new_img, 255, 255, 255));
        }

        imagecopyresampled($new_img, $img, 0, 0, $from_x1, $from_y1, $to_x2, $to_y2, $from_x2, $from_y2);

        $site_params = Registry::get('settings')->getSiteParams();

        if ($this->set_wmark == 1 && $this->wmark_image) {
            $wmark_image = new Image($this->wmark_image);
            $wmark_image_path = $wmark_image->getUploadPath() . $wmark_image->name;
            $info_w = @getImageSize($wmark_image_path);
            if ($info_w) {
                $watermark = @imageCreateFromString(file_get_contents($wmark_image_path));
                $w_h = $to_x2 / $info_w[0] * $info_w[1];
                $y_w = ($to_y2 / 2) - ($w_h / 2);
                imagecopyresampled($new_img, $watermark, 0, $y_w, 0, 0, $to_x2, $w_h, $info_w[0], $info_w[1]);
                imageDestroy($watermark);
            }
        } elseif ($this->set_wmark == 1 && !empty($this->wmark_text)) {
            $this->wmark_text;
            $max_font = 60;
            [$strWidth, $fontsize] = $this->getFontsize($this->wmark_text, $max_font, $to_x2);
            $color = imagecolorallocatealpha($new_img, 255, 255, 255, 76);
            $mask_y = round($to_y2 * 0.9);
            $mask_x = $to_x2 - $fontsize / 2;
            $mask_y = $to_y2 / 2 + $strWidth / 2;
            imagettftext(
                $new_img,
                $fontsize,
                90,
                $mask_x,
                $mask_y,
                $color,
                dirname(__FILE__) . '/GaramondPremrPro.otf',
                $this->wmark_text
            );
        }
        if (!empty($this->bw)) {
            imagefilter($new_img, IMG_FILTER_GRAYSCALE);
        }

        if (($ext == 'jpeg') || ($ext == 'jpg')) {
            imagejpeg($new_img, $this->folder . basename($this->source), 70);
        } elseif ($ext == 'webp') {
            imagewebp($new_img, $this->folder . basename($this->source), 100);
        } elseif ($ext == 'png') {
            imagepng($new_img, $this->folder . basename($this->source), 7);
        } elseif ($ext == 'gif') {
            imagegif($new_img, $this->folder . basename($this->source));
        }
        imagedestroy($new_img);
        imagedestroy($img);
        return [$from_x1, $from_y1, $from_x1 + $from_x2, $from_y1 + $from_y2];
    }

    public function setCropData($x1 = 0, $y1 = 0, $x2 = 100, $y2 = 100, $bx = null, $by = null)
    {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
        $this->bx = $bx;
        $this->by = $by;
    }

    public function crop()
    {
        if (empty($this->source) || empty($this->folder) || !is_file($this->source)) {
            return;
        }
        $ext = array_pop(explode('.', basename($this->source)));
        if (($ext == 'jpeg') || ($ext == 'jpg')) {
            $img = @imagecreatefromjpeg($this->source);
        } elseif ($ext == 'png') {
            $img = @imagecreatefrompng($this->source);
        } elseif ($ext == 'gif') {
            $img = @imagecreatefromgif($this->source);
        } elseif ($ext == 'webp') {
            $img = @imagecreatefromwebp($this->source);
        } else {
            throw new Exception("Wrong image extension: ." . $ext);
        }
        if (!$img) {
            throw new Exception("Image creation problem");
        }

        $s_w = imageSX($img); //ширина исходного изображения
        $s_h = imageSY($img); //высота исходного изображения

        if (!empty($this->bx) && !empty($this->by)) {
            $k_w = $s_w / $this->bx;
            $k_h = $s_h / $this->by;
        } else {
            $k_w = $k_h = 1;
        }

        $from_x1 = (int)($this->x1 * $k_w);
        $from_y1 = (int)($this->y1 * $k_h);
        $from_x2 = (int)(($this->x2 - $this->x1) * $k_w);
        $from_y2 = (int)(($this->y2 - $this->y1) * $k_h);


        $new_img = imagecreatetruecolor($this->d_w, $this->d_h);

        if ($this->transparency) {
            if ($ext == 'png') {
                imagealphablending($new_img, false);
                $colorTransparent = imagecolorallocatealpha($new_img, 0, 0, 0, 127);
                imagefill($new_img, 0, 0, $colorTransparent);
                imagesavealpha($new_img, true);
            } elseif ($ext == 'gif') {
                $trnprt_indx = imagecolortransparent($img);

                if ($trnprt_indx >= 0) {
                    $trnprt_color = imagecolorsforindex($img, $trnprt_indx);
                    $trnprt_indx = imagecolorallocate(
                        $new_img,
                        $trnprt_color['red'],
                        $trnprt_color['green'],
                        $trnprt_color['blue']
                    );
                    imagefill($new_img, 0, 0, $trnprt_indx);
                    imagecolortransparent($new_img, $trnprt_indx);
                }
            }
        } else {
            imagefill($new_img, 0, 0, imagecolorallocate($new_img, 255, 255, 255));
        }

        imagecopyresampled($new_img, $img, 0, 0, $from_x1, $from_y1, $this->d_w, $this->d_h, $from_x2, $from_y2);

        if (($ext == 'jpeg') || ($ext == 'jpg')) {
            imagejpeg($new_img, $this->folder . basename($this->source), 70);
        } elseif ($ext == 'png') {
            imagepng($new_img, $this->folder . basename($this->source), 7);
        } elseif ($ext == 'gif') {
            imagegif($new_img, $this->folder . basename($this->source));
        } elseif ($ext == 'webp') {
            imagewepb($new_img, $this->folder . basename($this->source), 100);
        }
        imagedestroy($new_img);
        imagedestroy($img);
        return [$from_x1, $from_y1, (int)$this->x2 * $k_w, (int)$this->y2 * $k_h];
    }

    private function getFontsize($text, $max_font, $img_width)
    {
        $margin_left = round(0.2 * $img_width);
        $margin = $margin_left * 2;
        $newfont = $max_font;
        $str_w = round(strlen($text) * ($newfont / 1.3));
        while (($margin + $str_w) > $img_width) {
            $newfont--;
            $str_w = round(strlen($text) * ($newfont / 1.3));
        }
        $newfont = ($newfont < 0) ? 1 : $newfont;
        $margin_left = round(($img_width - $str_w) / 2);
        return [$str_w, $newfont];
    }
}