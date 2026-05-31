<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		// 1. TANGKAP NILAI FILTER (Bawaan / Default: 'tahun_ini')
		$filter = $request->query('filter', 'tahun_ini');
		$now = Carbon::now();

		// 2. BUAT FUNGSI PENYARING WAKTU GLOBAL
		// Fungsi ini akan kita tempelkan ke semua query perhitungan
		$dateFilter = function ($query) use ($filter, $now) {
			if ($filter == 'bulan_ini') {
				$query->whereMonth('created_at', $now->month)
					->whereYear('created_at', $now->year);
			} elseif ($filter == '3_bulan') {
				$query->where('created_at', '>=', $now->copy()->subMonths(3));
			} elseif ($filter == '6_bulan') {
				$query->where('created_at', '>=', $now->copy()->subMonths(6));
			} elseif ($filter == 'tahun_ini') {
				$query->whereYear('created_at', $now->year);
			}
		};

		// 3. TERAPKAN FILTER KE QUERY UTAMA UMKM
		// Kita gunakan clone agar base query tidak tumpang tindih
		$baseQuery = Umkm::where($dateFilter);

		$totalUmkm = (clone $baseQuery)->count();
		$totalMenunggu = (clone $baseQuery)->where('status_verif', 'menunggu')->count();

		$statusAktif = (clone $baseQuery)->where('status_umkm', 'aktif')->count();
		$statusTidakAktif = $totalUmkm - $statusAktif;

		$verifDisetujui = (clone $baseQuery)->where('status_verif', 'disetujui')->count();
		$verifMenunggu = $totalMenunggu;
		$verifDitolak = (clone $baseQuery)->where('status_verif', 'ditolak')->count();

		// 4. TERAPKAN FILTER KE DATA KELURAHAN (Vertical Bar)
		$dataKelurahan = Kelurahan::withCount(['umkm' => $dateFilter])->get();
		$labelKelurahan = $dataKelurahan->pluck('nama_kelurahan')->toArray();
		$angkaKelurahan = $dataKelurahan->pluck('umkm_count')->toArray();

		// 5. TERAPKAN FILTER KE GRAFIK BULANAN (Horizontal Bar)
		$namaBulan = [];
		$angkaBulan = [];
		$bulanIndo = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

		// Selalu mulai dari tanggal 1 agar aman saat mundur bulan
		$baseDate = Carbon::now()->startOfMonth();

		if ($filter == 'bulan_ini') {
			$namaBulan[] = $bulanIndo[$now->month];
			$angkaBulan[] = Umkm::whereMonth('created_at', $now->month)->whereYear('created_at', $now->year)->count();
		} elseif ($filter == '3_bulan' || $filter == '6_bulan') {
			$limit = ($filter == '3_bulan') ? 3 : 6;
			for ($i = 0; $i < $limit; $i++) {
				// Sekarang aman dari bug karena dihitung dari tanggal 1
				$date = $baseDate->copy()->subMonths($i);
				$namaBulan[] = $bulanIndo[$date->month];
				$angkaBulan[] = Umkm::whereMonth('created_at', $date->month)->whereYear('created_at', $date->year)->count();
			}
		} else { // Jika 'tahun_ini' ATAU 'semua'
			// Kita tetap menampilkan 12 bulan sebagai representasi
			for ($bulan = 12; $bulan >= 1; $bulan--) {
				$namaBulan[] = $bulanIndo[$bulan];

				if ($filter == 'semua') {
					// Hitung akumulasi bulan tersebut dari KESELURUHAN tahun
					$angkaBulan[] = Umkm::whereMonth('created_at', $bulan)->count();
				} else {
					// Hanya hitung untuk tahun ini saja
					$angkaBulan[] = Umkm::whereMonth('created_at', $bulan)->whereYear('created_at', $now->year)->count();
				}
			}
		}

		// 6. TERAPKAN FILTER KE TABEL MINIMALIS
		$umkmMenunggu = (clone $baseQuery)->with(['kategori', 'kelurahan'])
			->where('status_verif', 'menunggu')
			->latest()->take(5)->get();

		return view('admin.umkm.dashboard', compact(
			'totalUmkm',
			'totalMenunggu',
			'statusAktif',
			'statusTidakAktif',
			'verifDisetujui',
			'verifMenunggu',
			'verifDitolak',
			'labelKelurahan',
			'angkaKelurahan',
			'namaBulan',
			'angkaBulan',
			'umkmMenunggu'
		));
	}
}
