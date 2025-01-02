<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\PertemuanKelas;
use App\Models\Tes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
      $startOfWeek = Carbon::now()->startOfWeek();
      $endOfWeek = Carbon::now()->endOfWeek();

      $hariList = [];
      for ($i = 1; $i < 6; $i++) {
        $hariList[] = Carbon::now()->startOfWeek()->addDays($i);
      }

      $sesiList = [
        ['start' => '07:30', 'end' => '09:00'],
        ['start' => '09:00', 'end' => '10:30'],
        ['start' => '10:30', 'end' => '12:00'],
        ['start' => '13:00', 'end' => '14:30'],
        ['start' => '14:30', 'end' => '16:00'],
        ['start' => '16:30', 'end' => '17:30'],
        ['start' => '18:30', 'end' => '20:00'],
      ];

      return view('guest.jadwal', [
        'hariList' => $hariList,
        'sesiList' => $sesiList,
      ]);
    }
}
