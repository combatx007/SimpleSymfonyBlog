<?php
/*
 * This file is part of the FreshCommonBundle
 *
 * (c) Artem Genvald <genvaldartem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Transliteration Service
 *
 * @author Artem Genvald <genvaldartem@gmail.com>
 * @see    http://zakon1.rada.gov.ua/laws/show/55-2010-%D0%BF Resolution #55 of the Cabinet of Ministers of Ukraine
 */
class Transliteration
{
    /**
     * @var array Rules of transliteration from ukrainian to english
     */
    protected $ukrainianToEnglish = [
        'А' => 'A',    'а' => 'a',
        'Б' => 'B',    'б' => 'b',
        'В' => 'V',    'в' => 'v',
        'Г' => 'H',    'г' => 'h',
        'Ґ' => 'G',    'ґ' => 'g',
        'Д' => 'D',    'д' => 'd',
        'Е' => 'E',    'е' => 'e',
        'Є' => 'Ye',   'є' => 'ie',
        'Ж' => 'Zh',   'ж' => 'zh',
        'З' => 'Z',    'з' => 'z',
        'И' => 'Y',    'и' => 'y',
        'І' => 'I',    'і' => 'i',
        'Ї' => 'Yi',   'ї' => 'i',
        'Й' => 'Y',    'й' => 'i',
        'К' => 'K',    'к' => 'k',
        'Л' => 'L',    'л' => 'l',
        'М' => 'M',    'м' => 'm',
        'Н' => 'N',    'н' => 'n',
        'О' => 'O',    'о' => 'o',
        'П' => 'P',    'п' => 'p',
        'Р' => 'R',    'р' => 'r',
        'С' => 'S',    'с' => 's',
        'Т' => 'T',    'т' => 't',
        'У' => 'U',    'у' => 'u',
        'Ф' => 'F',    'ф' => 'f',
        'Х' => 'Kh',   'х' => 'kh',
        'Ц' => 'Ts',   'ц' => 'ts',
        'Ч' => 'Ch',   'ч' => 'ch',
        'Ш' => 'Sh',   'ш' => 'sh',
        'Щ' => 'Shch', 'щ' => 'shch',
        'ь'  => '',     'ъ'  => '',
        'Ы' => 'I',     'ы' => 'i',
        'Э' => 'e',     'э' => 'e',
        'Ю' => 'Yu',    'ю' => 'iu',
        'Я' => 'Ya',   'я' => 'ia',
        '\'' => '',
        '!' => '', '"' => '',
        '#' => '', '$' => '',
        '%' => '', '&' => '',
        '(' => '', ')' => '',
        '*' => '', '+' => '',
        ',' => '', '-' => '',
        '.' => '', '/' => '',
        ':' => '', ';' => '',
        '<' => '', '=' => '',
        '>' => '', '?' => '',
        '@' => '', '[' => '',
        '\\' => '', ']' => '',
        '^' => '', '`' => '',
        '{' => '', '|' => '',
        '}' => '', '~' => '',
        ' ' => '_'
];

    /**
     * Transliterate ukrainian text to english
     *
     * According to the rules of transliteration, that are described in the resolution
     * of the Cabinet of Ministers of Ukraine №55 dated January 27, 2010
     *
     * @param string $ukrainianText
     *
     * @return string
     */
    public function fromUkrainianToEnglish($ukrainianText)
    {
        $result = '';

        if (mb_strlen($ukrainianText) > 0) {
            // If found "Zgh|zgh" exception then replace it
            if ($this->checkForZghException($ukrainianText)) {
                $ukrainianText = str_replace(['Зг', 'зг'], ['Zgh', 'zgh'], $ukrainianText);
            }
            // Transliteration is doing by rendering each letter
            $result = str_replace(
                array_keys($this->ukrainianToEnglish),
                array_values($this->ukrainianToEnglish),
                $ukrainianText
            );
        }

        return $result;
    }

    /**
     * Check text for "Zgh|zgh" exception
     *
     * @param string $ukrainianText
     *
     * @return bool
     */
    protected function checkForZghException($ukrainianText)
    {
        return (bool) mb_substr_count($ukrainianText, 'Зг') || (bool) mb_substr_count($ukrainianText, 'зг');
    }
}