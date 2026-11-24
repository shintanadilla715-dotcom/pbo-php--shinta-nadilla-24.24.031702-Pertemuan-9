<?php
// LAB 9 — Exception (bagian PHPUnit dikerjakan lokal, kirim tautan repositori)
// Spesifikasi:
//  - NilaiTidakValidException & SaldoTidakCukupException extends Exception
//  - Siswa(): setNilai(int) melempar NilaiTidakValidException jika di luar 0–100
//  - Rekening(float $saldo): tarik(float) melempar SaldoTidakCukupException; getSaldo(): float

// TODO: dua custom exception
class NilaiTidakValidException extends Exception {}
class SaldoTidakCukupException extends Exception {}

class Siswa
{
    private int $nilai = 0;
        
    public function setNilai(int $nilai): void
    {
        if ($nilai < 0 || $nilai > 100) {
            throw new NilaiTidakValidException("Nilai harus berada di antara 0 dan 100, diberikan: {$nilai}");
        }
        $this->nilai = $nilai;
    }
    
    public function getNilai(): int
    {
        return $this->nilai;
    }
}

class Rekening
{
    private float $saldo;

    public function __construct(float $saldo = 0)
    {
        $this->saldo = $saldo;
    }

    public function tarik(float $jumlah): void
    {
        if ($jumlah > $this->saldo) {
            throw new SaldoTidakCukupException("Saldo tidak cukup");
        }
        $this->saldo -= $jumlah;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }
}


//CONTOH PENGUJIAN EXCEPTION, SISWA, DAN REKENING

// 1. Uji Siswa dengan nilai valid dan tidak valid
try {
    $siswa = new Siswa();
    $siswa->setNilai(85);
    echo "Nilai siswa valid: " . $siswa->getNilai() . "\n";

    // Ini NilaiTidakValidException
    $siswa->setNilai(150);
} catch (NilaiTidakValidException $e) {
    echo "Tertangkap NilaiTidakValidException: " . $e->getMessage() . "\n";
}

// 2. Uji Rekening dengan penarikan valid dan melebihi saldo
try {
    $rekening = new Rekening(100000);
    $rekening->tarik(40000);
    echo "Sisa saldo setelah tarik 40000: " . $rekening->getSaldo() . "\n";

    // Ini SaldoTidakCukupException
    $rekening->tarik(80000);
} catch (SaldoTidakCukupException $e) {
    echo "Tertangkap SaldoTidakCukupException: " . $e->getMessage() . "\n";
}

// Coba setelah selesai (hapus tanda komentar):
// try {
//     (new Siswa())->setNilai(150);
// } catch (NilaiTidakValidException $e) {
//     echo 'Tertangkap: ' . $e->getMessage();
// }
