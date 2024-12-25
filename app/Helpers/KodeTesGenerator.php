<?php

namespace App\Helpers;

class KodeTesGenerator
{
    public static function generate($tipe, $nomor, $tanggal): string
    {
        $kode = $tipe->kode . '/' . $nomor . '/' . self::toRoman($tanggal->month) . '/' . $tanggal->year;
        return $kode;
    }

    public static function slug(string $kodeTes): string
    {   
        $slug = str_replace('/', '-', $kodeTes);
        $slug = strtolower($slug);
        return $slug;
    }

    private static function toRoman(int $monthInt): string
    {
        $array = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $array[$monthInt - 1];
    }
}