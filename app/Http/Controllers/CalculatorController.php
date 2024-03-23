<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculation;

// kelas yang mendefinisikan controller
class CalculatorController extends Controller
{
    public function calculate(Request $request)
    {
        $operasi = $request->input('operasi');
        $bil_pertama = (int) $request->input('bil_1');
        $bil_kedua = (int) $request->input('bil_2');
        $result = 0;

        if ($operasi == "tambah") {
            $result = $bil_pertama + $bil_kedua;
        } else if ($operasi == "kurang") {
            $result = $bil_pertama - $bil_kedua;
        } else if ($operasi == "bagi") {
            $result = $bil_pertama / $bil_kedua;
        } else if ($operasi == "kali") {
            $result = $bil_pertama * $bil_kedua;
        } else if ($operasi == "mod") {
            $result = $bil_pertama % $bil_kedua;
        } else {
            $result = 0;
        }

        // Buat instance baru dari model Calculation dan simpan data
        $calculation = new Calculation;
        $calculation->operation = $operasi;
        $calculation->operand1 = $bil_pertama;
        $calculation->operand2 = $bil_kedua;
        $calculation->result = $result;
        $calculation->save(); // Menyimpan data ke database


        return redirect('/')->with('info', 'hasil nya adalah : ' . $result);
    }

    public function destroy($id)
    {
        // Cari kalkulasi berdasarkan ID dan hapus
        $calculation = Calculation::findOrFail($id);
        $calculation->delete();

        // Kembali ke halaman utama dengan pesan
        return back()->with('info', 'Kalkulasi berhasil dihapus');
    }

    public function showCalculator()
    {
        $calculations = Calculation::all(); // Mengambil semua data kalkulasi
        return view('calculator', compact('calculations')); // Mengirim data ke view
    }
}
