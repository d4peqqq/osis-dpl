<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\QrCodeServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\StrukturOrganisasi;
use Barryvdh\DomPDF\Facade\Pdf;

class KartuAnggotaController extends Controller
{
    /**
     * DIP: Controller bergantung pada abstraksi QrCodeServiceInterface,
     * bukan langsung pada library chillerlan\QRCode.
     * Library QR code dapat diganti tanpa menyentuh controller ini.
     */
    public function __construct(
        private QrCodeServiceInterface $qrCodeService
    ) {}

    public function index()
    {
        $anggota = StrukturOrganisasi::where('is_active', true)->orderBy('order')->get();
        return view('admin.kartu-anggota.index', compact('anggota'));
    }

    /**
     * SRP: Method ini memusatkan pengambilan data kartu anggota.
     * Menghilangkan duplikasi yang sebelumnya ada di preview(), pdf(), dan print().
     */
    private function buildCardData(int $id): array
    {
        $anggota  = StrukturOrganisasi::findOrFail($id);
        $settings = Pengaturan::pluck('value', 'key');
        $qrUrl    = url('/anggota/' . $anggota->slug);
        // DIP: menggunakan service, bukan new QRCode() langsung.
        $qrCode   = $this->qrCodeService->generate($qrUrl);

        return compact('anggota', 'settings', 'qrUrl', 'qrCode');
    }

    public function preview($id)
    {
        // SRP: data disiapkan oleh buildCardData(), method ini hanya return view.
        $data = $this->buildCardData($id);
        return view('admin.kartu-anggota.preview', $data);
    }

    public function pdf($id)
    {
        // SRP: data disiapkan oleh buildCardData(), method ini hanya render PDF.
        $data = $this->buildCardData($id);

        $pdf = Pdf::loadView('admin.kartu-anggota.pdf', $data)
            ->setPaper([0, 0, 241.89, 153.07], 'landscape');

        return $pdf->stream('kartu-' . $data['anggota']->slug . '.pdf');
    }

    public function print($id)
    {
        // SRP: data disiapkan oleh buildCardData(), method ini hanya return view print.
        $data = $this->buildCardData($id);
        return view('admin.kartu-anggota.print', $data);
    }
}
