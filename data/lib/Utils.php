<?php

namespace App;

class Utils
{
    const RUSSIAN_MONTHS = [
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентрябрь',
        'Октябрь',
        'Ноябрь',
        'Декабрь'
    ];


    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function redirect($url = '/')
    {
        header('Location: ' . $url, true, 301);
        exit;
    }

    public static function core_redirect($url = '/')
    {
        self::redirect($url);
    }

    public static function redirectPrevious($ankor = '')
    {
        if (empty($_SERVER['HTTP_REFERER'])) {
            die("hmm... hacker?");
        }
        self::redirect(self::getLocalPath($_SERVER['HTTP_REFERER']) . (empty($ankor) ? '' : '#' . $ankor));
    }

    public static function getLocalPath($url)
    {
        $url = parse_url($url);
        return $url['path'] . (empty($url['query']) ? '' : ('?' . $url['query']));
    }

    public static function translit($text)
    {
        mb_internal_encoding('UTF-8');

        $NpjLettersFrom = 'абвгдезиклмнопрстуфцы';
        $NpjLettersTo = 'abvgdeziklmnoprstufcy';
        $NpjBiLetters = array(
            'й' => 'jj',
            'ё' => 'jo',
            'ж' => 'zh',
            'х' => 'kh',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shh',
            'э' => 'je',
            'ю' => 'ju',
            'я' => 'ja',
            'ъ' => '',
            'ь' => '',
        );

        $text = trim(strip_tags($text));
        $text = preg_replace("/\s+/ms", "-", $text);

        $text = mb_strtolower($text);


        $text = self::mb_strtr($text, $NpjLettersFrom, $NpjLettersTo);
        $text = strtr($text, $NpjBiLetters);

        $text = preg_replace("/[^a-z0-9_\-]+/mi", '', $text);

        return $text;
    }

    private static function mb_strtr($str, $needle, $replacement)
    {
        if (!is_array($needle)) {
            $needle = self::mb_str_split($needle);
            $replacement = self::mb_str_split($replacement);
        }

        foreach ($needle as $k => $v) {
            $str = mb_ereg_replace($v, $replacement[$k], $str);
        }

        return $str;
    }

    private static function mb_str_split($str)
    {
        $tmp = array();
        for ($i = 0; $i < mb_strlen($str); $i++) {
            $tmp[] = mb_substr($str, $i, 1);
        }

        return $tmp;
    }

    public static function detect_cli()
    {
        return isset($GLOBALS['argc']);
    }

    public static function truncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false)
    {
        if ($length == 0) {
            return '';
        }
        if (mb_strlen($string) > $length) {
            $length -= min($length, mb_strlen($etc));
            if (!$break_words && !$middle) {
                $string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length + 1));
            }
            if (!$middle) {
                return mb_substr($string, 0, $length) . $etc;
            } else {
                return mb_substr($string, 0, $length / 2) . $etc . mb_substr($string, -$length / 2);
            }
        } else {
            return $string;
        }
    }

    public static function generateFavicon($source, $dest)
    {
        if (!file_exists($dest)) {
            file_put_contents($dest, '');
            $ico_lib = new \PHP_ICO($source, array(array(64, 64)));
            $ico_lib->save_ico($dest);
        }
    }

    public static function jsonPage(array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public static function datesToStringDate(string $date): string
    {
        $end = strtotime(date('m/d/Y', time()));
        $start = strtotime($date);
        $diffInSeconds = $end - $start;
        $diffInDays = $diffInSeconds / 86400;

        if ($diffInDays >= 365) {
            $years = $diffInDays / 365;
            if ($years < 2) {
                $stringDate = "1 год назад";
            } elseif ($years <= 5) {
                $stringDate = (int)$years . " года назад";
            } else {
                $stringDate = (int)$years . " лет назад";
            }
        } elseif ($diffInDays >= 31) {
            $months = $diffInDays / 31;
            if ($months < 2) {
                $stringDate = "1 месяц назад";
            } elseif ($months <= 5) {
                $stringDate = (int)$months . " месяца назад";
            } else {
                $stringDate = (int)$months . " месяцев назад";
            }
        } elseif ($diffInDays >= 7) {
            $weeks = $diffInDays / 7;
            if ($weeks < 2) {
                $stringDate = "1 неделю назад";
            } else {
                $stringDate = (int)$weeks . " недели назад";
            }
        } else {
            if ($diffInDays === 0) {
                $stringDate = "сегодня";
            } elseif ($diffInDays === 1) {
                $stringDate = $diffInDays . " день назад";
            } elseif ($diffInDays < 5) {
                $stringDate = $diffInDays . " дня назад";
            } else {
                $stringDate = $diffInDays . " дней назад";
            }
        }

        return $stringDate;
    }
}