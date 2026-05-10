<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use App\Models\Pengaturan;
use Barryvdh\DomPDF\Facade\Pdf;
use chillerlan\QRCode\QRCode;

class KartuAnggotaController extends Controller
{
    public function index()
    {
        $anggota = StrukturOrganisasi::where('is_active', true)->orderBy('order')->get();
        return view('admin.kartu-anggota.index', compact('anggota'));
    }

    public function preview($id)
    {
        $anggota = StrukturOrganisasi::findOrFail($id);
        $settings = Pengaturan::pluck('value', 'key');
        $qrUrl = url('/anggota/' . $anggota->slug);
        $qrCode = (new QRCode())->render($qrUrl);
        return view('admin.kartu-anggota.preview', compact('anggota', 'settings', 'qrCode', 'qrUrl'));
    }

    public function pdf($id)
    {
        $anggota = StrukturOrganisasi::findOrFail($id);
        $settings = Pengaturan::pluck('value', 'key');
        $qrUrl = url('/anggota/' . $anggota->slug);
        $qrCode = (new QRCode())->render($qrUrl);

        $pdf = Pdf::loadView('admin.kartu-anggota.pdf', compact('anggota', 'settings', 'qrCode', 'qrUrl'))
            ->setPaper([0, 0, 241.89, 153.07], 'landscape'); // 85.6mm x 54mm credit card size

        return $pdf->stream('kartu-' . $anggota->slug . '.pdf');
    }

    public function print($id)
    {
        $anggota = StrukturOrganisasi::findOrFail($id);
        $settings = Pengaturan::pluck('value', 'key');
        $qrUrl = url('/anggota/' . $anggota->slug);
        $qrCode = (new QRCode())->render($qrUrl);
        return view('admin.kartu-anggota.print', compact('anggota', 'settings', 'qrCode', 'qrUrl'));
    }
}
