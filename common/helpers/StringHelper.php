<?php 
namespace common\helpers;

use Yii;

/**
* 
*/
class StringHelper extends \yii\helpers\StringHelper
{
    
    //正则匹配一个电话是否为正确的电话号码
    public static function checkMobile($mobile)
    {
        if (preg_match("/^1[3-8]{1}\d{9}$/", $mobile)) {
            return true;
        }
        return false;
    }

    public static function checkjson(&$string)
    {
        $string = json_decode($string);
        if (json_last_error() == JSON_ERROR_NONE) {
            return true;
        }
        return false;
    }

    //正则匹配一个邮箱是否为正确的邮箱
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public static function getRandNum($num)
    {
        return rand(pow(10, $num - 1), pow(10, $num) - 1);
    }

    public static function checkLogin($login)
    {
        if (preg_match("/\w{5,10}/", $login)) {
            return true;
        }
        return false;
    }

    /*
     * 防止单条消息过长
     */
    public static function truncateMsg($msg, $len = 250)
    {
        $arridx = 0;
        $line = '';
        $subidx = 0;
        $count = 0;

        while ($subidx < strlen($msg)) {
            $uch = '';
            if ($count == $len - 2) {
                $line = $line . '...';
                break;
            }
            if ((ord($msg[$subidx]) & 0x80) == 0x00) {
                $uch .= $msg[$subidx];
                $subidx += 1;
                $count += 1;
            } else if ((ord($msg[$subidx]) & 0xc0) == 0x80) {
                $subidx += 1;
                continue;
            } else if ((ord($msg[$subidx]) & 0xe0) == 0xc0) {
                $uch .= $msg[$subidx];
                $subidx += 1;
                $uch .= $msg[$subidx];
                $subidx += 1;
                $count += 1;
            } else if ((ord($msg[$subidx]) & 0xf0) == 0xe0) {
                $uch .= $msg[$subidx];
                $subidx += 1;
                $uch .= $msg[$subidx];
                $subidx += 1;
                $uch .= $msg[$subidx];
                $subidx += 1;
                $count += 1;
            } else if ((ord($msg[$subidx]) & 0xf8) == 0xf0) {
                $uch .= $msg[$subidx];
                $subidx += 1;
                $uch .= $msg[$subidx];
                $subidx += 1;
                $uch .= $msg[$subidx];
                $subidx += 1;
                $uch .= $msg[$subidx];
                $subidx += 1;
                $count += 1;
            }

            $line .= $uch;
        }
        return $line;
    }

    public static function checkPasswdValid($password)
    {
        //判断密码长度
        if (empty($password) || strlen($password) < 6 || strlen($password) > 16) {
            return "密码长度应该在6-16位之间";
        }
        if (in_array($password, self::$password_blacklist)) {
            return '您的密码过于简单';
        }
        return false;
    }

    // 判断ip是否在某个范围内
    // This function takes 2 arguments, an IP address and a "range" in several
    // different formats.
    // Network ranges can be specified as:
    // 1. Wildcard format:     1.2.3.*
    // 2. CIDR format:         1.2.3/24  OR  1.2.3.4/255.255.255.0
    // 3. Start-End IP format: 1.2.3.0-1.2.3.255
    // The function will return true if the supplied IP is within the range.
    // Note little validation is done on the range inputs - it expects you to
    // use one of the above 3 formats.
    public static function isIPInRange($ip, $range)
    {
        if (strpos($range, '/') !== false) {
            // $range is in IP/NETMASK format
            list($range, $netmask) = explode('/', $range, 2);
            if (strpos($netmask, '.') !== false) {
                // $netmask is a 255.255.0.0 format
                $netmask = str_replace('*', '0', $netmask);
                $netmask_dec = ip2long($netmask);
                return ((ip2long($ip) & $netmask_dec) == (ip2long($range) & $netmask_dec));
            } else {
                // $netmask is a CIDR size block
                // fix the range argument
                $x = explode('.', $range);
                while (count($x) < 4)
                    $x[] = '0';
                list($a, $b, $c, $d) = $x;
                $range = sprintf("%u.%u.%u.%u", empty($a) ? '0' : $a, empty($b) ? '0' : $b, empty($c) ? '0' : $c, empty($d) ? '0' : $d);
                $range_dec = ip2long($range);
                $ip_dec = ip2long($ip);

                # Strategy 1 - Create the netmask with 'netmask' 1s and then fill it to 32 with 0s
                #$netmask_dec = bindec(str_pad('', $netmask, '1') . str_pad('', 32-$netmask, '0'));

                # Strategy 2 - Use math to create it
                $wildcard_dec = pow(2, (32 - $netmask)) - 1;
                $netmask_dec = ~$wildcard_dec;

                return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
            }
        } else if (strpos($range, '*') !== false || strpos($range, '-') !== false) {
            // range might be 255.255.*.* or 1.2.3.0-1.2.3.255
            if (strpos($range, '*') !== false) { // a.b.*.* format
                // Just convert to A-B format by setting * to 0 for A and 255 for B
                $lower = str_replace('*', '0', $range);
                $upper = str_replace('*', '255', $range);
                $range = "$lower-$upper";
            }

            if (strpos($range, '-') !== false) { // A-B format
                list($lower, $upper) = explode('-', $range, 2);
                $lower_dec = (float)sprintf("%u", ip2long($lower));
                $upper_dec = (float)sprintf("%u", ip2long($upper));
                $ip_dec = (float)sprintf("%u", ip2long($ip));
                return (($ip_dec >= $lower_dec) && ($ip_dec <= $upper_dec));
            }
            return false;
        } else {
            return $ip == $range;
        }
    }
}