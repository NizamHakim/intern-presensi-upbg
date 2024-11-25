<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Ruangan;
use App\Helpers\RouteGraph;
use Illuminate\Http\Request;
use App\Models\PertemuanKelas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PertemuanKelasController extends Controller
{
    public function detail($slug, $id)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $pertemuan = $kelas->pertemuan()->findOrFail($id);

        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', $kelas->slug),
            "Pertemuan - $pertemuan->pertemuan_ke" => null,
        ];
        
        $pertemuan->load('presensi.peserta');

        $pengajarOptions = $kelas->pengajar()->get()->map->only(['text', 'value'])->prepend(['text' => 'Pilih pengajar', 'value' => null]); // ?pengajarOptions
        $pengajarSelected = $pengajarOptions->first();
        
        $tambahPesertaOptions = $kelas->peserta()->whereNotIn('peserta.id', $pertemuan->presensi->pluck('peserta_id'))->get();
        $tambahPesertaSelected = null;

        $ruanganOptions = Ruangan::all();
        $ruanganSelected = $ruanganOptions->where('id', $pertemuan->ruangan_id)->first();

        return view('kelas.pertemuan.detail-pertemuan', [
            'kelas' => $kelas,
            'pertemuan' => $pertemuan,
            'breadcrumbs' => $breadcrumbs,
            'pengajarOptions' => $pengajarOptions,
            'pengajarSelected' => $pengajarSelected,
            'tambahPesertaOptions' => $tambahPesertaOptions,
            'tambahPesertaSelected' => $tambahPesertaSelected,
            'ruanganOptions' => $ruanganOptions,
            'ruanganSelected' => $ruanganSelected,
        ]);
    }

    public function edit($slug, $id)
    {
        $kelas = Kelas::where('slug', $slug)->firstOrFail();
        $pertemuan = $kelas->pertemuan()->findOrFail($id);

        $pengajarOptions = $kelas->pengajar()->get();
        $pengajarSelected = $pengajarOptions->where('id', $pertemuan->pengajar_id)->first();

        $terlaksanaOptions = collect([['text' => 'Tidak Terlaksana', 'value' => 0], ['text' => 'Terlaksana', 'value' => 1]]);
        $terlaksanaSelected = $terlaksanaOptions->where('value', $pertemuan->terlaksana)->first();

        $ruanganOptions = Ruangan::all();
        $ruanganSelected = $ruanganOptions->where('id', $pertemuan->ruangan_id)->first();

        $breadcrumbs = [
            'Kelas' => route('kelas.index'),
            "$kelas->kode" => route('kelas.detail', $kelas->slug),
            "Pertemuan - $pertemuan->pertemuan_ke" => route('kelas.pertemuan.detail', [$kelas->slug, $pertemuan->id]),
            'Edit' => null,
        ];

        return view('kelas.pertemuan.edit-pertemuan', [
            'kelas' => $kelas,
            'pertemuan' => $pertemuan,
            'breadcrumbs' => $breadcrumbs,
            'pengajarOptions' => $pengajarOptions,
            'pengajarSelected' => $pengajarSelected,
            'terlaksanaOptions' => $terlaksanaOptions,
            'terlaksanaSelected' => $terlaksanaSelected,
            'ruanganOptions' => $ruanganOptions,
            'ruanganSelected' => $ruanganSelected,
        ]);
    }

    public function updateDetail($slug, $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'terlaksana' => 'required|boolean',
            'pengajar-id' => 'nullable|required_if:terlaksana,1|prohibited_if:terlaksana,0|exists:pengajar_kelas,id',
            'tanggal' => 'required|date',
            'waktu-mulai' => 'required|date_format:H:i',
            'waktu-selesai' => 'required|date_format:H:i',
            'ruangan-kode' => 'required|exists:ruangan,kode',
        ], [
            'terlaksana.required' => 'Status pertemuan tidak boleh kosong',
            'terlaksana.boolean' => 'Status pertemuan tidak valid',
            'pengajar-id.required_if' => 'Pengajar tidak boleh kosong untuk pertemuan terlaksana',
            'pengajar-id.prohibited_if' => 'Pengajar tidak boleh diisi untuk pertemuan tidak terlaksana',
            'pengajar-id.exists' => 'Pengajar tidak valid',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'tanggal.date' => 'Tanggal tidak valid',
            'waktu-mulai.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.date_format' => 'Waktu mulai tidak valid',
            'waktu-selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu-selesai.date_format' => 'Waktu selesai tidak valid',
            'ruangan-kode.required' => 'Ruangan tidak boleh kosong',
            'ruangan-kode.exists' => 'Ruangan tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }else{
            try{
                $kelas = Kelas::where('slug', $slug)->firstOrFail();
                $pertemuan = $kelas->pertemuan()->findOrFail($id);

                $pertemuan->update([
                    'terlaksana' => $request['terlaksana'],
                    'pengajar_id' => $request['pengajar-id'],
                    'tanggal' => $request['tanggal'],
                    'waktu_mulai' => $request['waktu-mulai'],
                    'waktu_selesai' => $request['waktu-selesai'],
                    'ruangan_id' => Ruangan::where('kode', $request['ruangan-kode'])->first()->id,
                ]);
            }catch(ModelNotFoundException $e){
                return response('Pertemuan kelas tidak ditemukan', 404);
            }
        }

        if($request['terlaksana'] == 1){
            $this->generatePresensi($kelas, $pertemuan);
        }else if($request['terlaksana'] == 0){
            $this->deletePresensi($pertemuan);
        }

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Pertemuan berhasil diupdate'
        ]);

        return response(['redirect' => route('kelas.pertemuan.detail', [$kelas->slug, $pertemuan->id])], 200);
    }

    public function updateTopikCatatan($slug, $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topik' => 'nullable|string',
            'catatan' => 'nullable|string',
        ], [
            'topik.string' => 'Topik tidak valid',
            'catatan.string' => 'Catatan tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }else{
            try{
                $kelas = Kelas::where('slug', $slug)->firstOrFail();
                $pertemuan = $kelas->pertemuan()->findOrFail($id);

                $pertemuan->update([
                    'topik' => $request['topik'],
                    'catatan' => $request['catatan'],
                ]);
            }catch(ModelNotFoundException $e){
                return response('Pertemuan kelas tidak ditemukan', 404);
            }
        }

        return response([
            'message' => 'Pertemuan berhasil diupdate',
            'topik' => $pertemuan->topik,
            'catatan' => $pertemuan->catatan,
        ], 200);
    }

    public function reschedule($slug, $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'waktu-mulai' => 'required|date_format:H:i',
            'waktu-selesai' => 'required|date_format:H:i',
            'ruangan-kode' => 'required|exists:ruangan,kode',
        ], [
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'tanggal.date' => 'Tanggal tidak valid',
            'waktu-mulai.required' => 'Waktu mulai tidak boleh kosong',
            'waktu-mulai.date_format' => 'Waktu mulai tidak valid',
            'waktu-selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu-selesai.date_format' => 'Waktu selesai tidak valid',
            'ruangan-kode.required' => 'Ruangan tidak boleh kosong',
            'ruangan-kode.exists' => 'Ruangan tidak valid',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }else{
            try{
                $kelas = Kelas::where('slug', $slug)->firstOrFail();
                $pertemuan = $kelas->pertemuan()->findOrFail($id);

                $pertemuan->update([
                    'tanggal' => $request['tanggal'],
                    'waktu_mulai' => $request['waktu-mulai'],
                    'waktu_selesai' => $request['waktu-selesai'],
                    'ruangan_id' => Ruangan::where('kode', $request['ruangan-kode'])->first()->id,
                ]);
            }catch(ModelNotFoundException $e){
                return response('Pertemuan kelas tidak ditemukan', 404);
            }
        }

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Pertemuan berhasil diupdate'
        ]);

        return response(['redirect' => route('kelas.pertemuan.detail', [$kelas->slug, $pertemuan->id])], 200);
    }

    public function updateStatusPertemuan($slug, $id, Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        $kelas = Kelas::where('slug', $request['kelas-slug'])->first();
        if (!$kelas) {
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Gagal menghapus, kelas tidak valid'
            ]);
            return redirect()->route('kelas.index');
        }

        $pertemuan = $kelas->pertemuan()->find($request['pertemuan-id']);
        if(!$pertemuan) {
            session()->flash('toast', [
                'type' => 'error',
                'message' => 'Gagal menghapus, pertemuan tidak valid'
            ]);
            return redirect()->route('kelas.detail', $kelas->slug);
        }

        $pertemuan->delete();

        $this->reorder($kelas);

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Pertemuan berhasil dihapus'
        ]);
   
        return redirect()->route('kelas.detail', $kelas->slug);
    }

    private function reorder($kelas)
    {
        $pertemuan = $kelas->pertemuan()->orderBy('pertemuan_ke')->get();
        $pertemuan->each(function($pertemuan, $index) {
            $pertemuan->update(['pertemuan_ke' => $index + 1]);
        });
    }

    private function generatePresensi($kelas, $pertemuan)
    {
        $peserta = $kelas->peserta()->get();

        $pertemuan->presensi()->createMany(
            $peserta->map(function($peserta) {
                return ['peserta_id' => $peserta->id];
            })->toArray()
        );
    }

    private function deletePresensi($pertemuan)
    {
        $pertemuan->presensi()->delete();
    }
}
