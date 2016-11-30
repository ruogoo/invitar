<?php
/**
 * This file is part of ruogu.
 *
 * Created by HyanCat.
 *
 * Copyright (C) HyanCat. All rights reserved.
 */

namespace Ruogu\Invitar;

/**
 * 数字加密算法:
 * 1. 高四位和低四位交换（按 9 位数来算）
 * 2. 最高位（第 10 位）补 1
 * 3. 与 key 做异或运算
 * 4. 末两位互换位置.
 *
 * @comment
 * 这里假定数字最多9位数，暂不需支持10位数及以上，如需支持可再做调整
 * 此算法可保证任何不超过9位数的数字加密后均为10为数字，加密字母为6位
 * @class   NumberConvert
 */
class NumberConvert
{
    // 注意: 需要忽略大小写, 大写优先
    const MAP = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    const MAP_STRING = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * 加密数字.
     *
     * @param int        $num      待加密的数字
     * @param string     $key      密钥
     * @param bool|false $isLetter 是否按字母型加密
     *
     * @return int|string
     */
    public static function encrypt($num, $key, $isLetter = false)
    {
        $helper = new self();
        $shift  = $helper->shift($num);
        $grow   = $helper->grow($shift);
        $xornum = $helper->makeXor($grow, $key);
        $exnum  = $helper->exchange($xornum);
        $code   = $isLetter ? $helper->numToXyz($exnum) : $exnum;

        return $code;
    }

    /**
     * 解密数字.
     *
     * @param int|string $code     需解密的数字或字符串
     * @param string     $key      密钥
     * @param bool|false $isLetter 是否是字母型密码
     *
     * @return int
     */
    public static function decrypt($code, $key, $isLetter = false)
    {
        $helper = new self();
        $num    = $isLetter ? $helper->xyzToNum($code) : $code;
        $exnum  = $helper->exchange($num);
        $xornum = $helper->makeXor($exnum, $key);
        $degrow = $helper->degrow($xornum);
        $origin = $helper->shift($degrow);

        return $origin;
    }

    private function grow($num)
    {
        $num += pow(10, 9); // 补位
        return $num;
    }

    private function degrow($num)
    {
        $num -= pow(10, 9); // 去掉补位
        return $num;
    }

    /**
     * 高四位与低四位交换.
     *
     * @param $num
     *
     * @return int
     */
    private function shift($num)
    {
        $high  = (int)($num / pow(10, 5)); // 高四位
        $low   = $num % pow(10, 4); // 低四位
        $mid   = (int)($num % pow(10, 5) / pow(10, 4));
        $shift = $high + $mid * pow(10, 4) + $low * pow(10, 5);

        return $shift;
    }

    /**
     * 异或操作.
     *
     * @param $num
     * @param $key
     *
     * @return int
     */
    private function makeXor($num, $key)
    {
        $xor = $num ^ $key;

        return $xor;
    }

    /**
     * 末两位互换.
     *
     * @param $num
     *
     * @return int
     */
    private function exchange($num)
    {
        $last       = $num % 10;
        $lastSecond = (int)($num % 100);
        $left       = (int)($num / 100);
        $new        = $left * 100 + $last * 10 + $lastSecond;

        return $new;
    }

    /**
     * 数字转换成 36 进制(0-9A-Z).
     *
     * @param $num
     *
     * @return string
     */
    private function numToXyz($num)
    {
        $str  = '';
        $left = $num;
        while ($left > 0) {
            $last   = $left % 36;
            $letter = array_get(self::MAP, $last);
            $str .= $letter;
            $left = (int)($left / 36);
        }

        return strrev($str);
    }

    /**
     * 36 进制(0-9A-Z)转换成数字.
     *
     * @param $xyz
     *
     * @return int
     */
    private function xyzToNum($xyz)
    {
        $num     = 0;
        $letters = str_split(strrev(strtoupper($xyz)), 1);
        foreach ($letters as $e => $letter) {
            $keys = array_keys(self::MAP, $letter);
            $val  = $keys[0];
            $num += $val * pow(36, $e);
        }

        return $num;
    }
}
