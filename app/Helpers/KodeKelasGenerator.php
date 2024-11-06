<?php

namespace App\Helpers;

class KodeKelasGenerator
{
    public static function generate($program, $tipe, $nomor, $level, $banyakPertemuan, $tanggalMulai): string
    {
        $kodeKelasArray = [
            $program,
            $tipe . '.' . $nomor,
            $level,
            $banyakPertemuan,
            self::toRoman($tanggalMulai->month),
            $tanggalMulai->year,
        ];

        $kodeKelasArray = array_filter($kodeKelasArray, function ($value) {
            return $value != null;
        });

        return implode('/', $kodeKelasArray);
    }

    public static function slug(string $kodeKelas): string
    {   
        $slug = str_replace('/', '-', $kodeKelas);
        $slug = strtolower($slug);
        return $slug;
    }

    private static function toRoman(int $monthInt): string
    {
        $array = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        return $array[$monthInt - 1];
    }
}