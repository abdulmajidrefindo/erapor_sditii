<?php

namespace App\Imports;

use Illuminate\Support\Collection;

use App\Models\SiswaBidangStudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithMappedCells;

class SiswaBidangStudiImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $kode_file, $errorFlag = false, $message = '';

    public function __construct($kode_file)
    {
        $this->kode_file = $kode_file;
    }

    public function collection(Collection $rows)
    {
        $file_identifier = '';
        try {
            $file_identifier = $this->getKodeFile($rows);
            if ($file_identifier != $this->kode_file) {
                $pesan = 'File tidak sesuai. File yang diupload: ' . $this->kode_file . '. 
                File yang diharapkan: ' . $file_identifier;
                $this->errorFlag = true;
                $this->message = $this->convertCamelCaseToReadable($pesan);
            }
        } catch (\Throwable $th) {
            $pesan = 'Bukan file yang diharapkan. Pastikan file yang diupload sesuai dengan template yang disediakan.';
            $this->errorFlag = true;
            $this->message = $pesan;
        }
        
        if (!$this->errorFlag) {
            $nilai_id = [];
            try {
                $this->saveData($rows);
                $this->message = 'Data berhasil diimport.';
                // array_push($nilai_id, $this->getNilaiId($rows));
                // dd($nilai_id);
            } catch (\Throwable $th) {
                $this->message = $th->getMessage();
                $this->errorFlag = true;
            }
        }
    }

    function convertCamelCaseToReadable($inputString) {
        $result = preg_replace('/(?<!^)([A-Z])/', ' $1', $inputString);
        return $result;
    }

    public function hasError() : bool
    {
        return $this->errorFlag;
    }

    public function getMessages() : string
    {
        return $this->message;
    }

    public function getLastRowIndex($row) // Mengembalikan index baris terakhir dari table data.
    {
        $lastRow = 0;
        foreach ($row as $key => $value) {
            if ($value != null) {
                $lastRow = $key;
            }
        }
        return $lastRow-3; // Potong 2 baris terakhir, 1 baris kosong, 1 baris kode_file.
    }

    public function getFirstRowIndex($row) // Mengembalikan index baris pertama dari table data.
    {
        
        $firstRow = 0;
        foreach ($row as $key => $value) {
            if ($value[0] == 'ID') { 
                $firstRow = $key;
                break;
            }
        }
        return $firstRow+2; // Lompati baris pertama yang berisi merged row 'ID' header.
    }

    public function getLastColumnIndex($row)
    {
        $lastColumn = 0;
        $row_start = $this->getFirstRowIndex($row);
        foreach ($row[$row_start] as $key => $value) {
            if ($value != null) {
                $lastColumn = $key;
            }
        }
        return $lastColumn;
    }

    public function getNilaiId($rows)
    {
        $lastRow = $this->getLastRowIndex($rows)+1; // Tambah 1 baris, kode nilai ada di akhir tabel data.
        
        $nilai_id = $rows[$lastRow]->toArray(); // Nilai ID ada di baris terakhir dari table data
        $nilai_id = array_slice($nilai_id, 3); // Potong 3 kolom pertama (ID, Nama, NISN)
        $nilai_id = array_filter($nilai_id);

        return $nilai_id;
    }

    public function getData($rows)
    {
        $firstRow = $this->getFirstRowIndex($rows);
        $lastRow = $this->getLastRowIndex($rows);
        $lastColumn = $this->getLastColumnIndex($rows);

        $data = [];
        for ($i=$firstRow; $i <= $lastRow; $i++) { 
            $data[$i] = $rows[$i]->toArray();
        }

        return $data;
    }

    public function getKodeFile($rows)
    {
        $lastRow = $this->getLastRowIndex($rows)+3; // Tambah 3 baris, kode file ada di baris terakhir dari table data.
        $kode_file = $rows[$lastRow][1]; // Kode file ada di baris terakhir dari table data, kolom kedua.
        return decrypt($kode_file);
    }

    public function updateOrCreate(array $condition, array $data)
    {
        $model = SiswaBidangStudi::where($condition)->first();
        if (!$model) {
            //$model = new SiswaBidangStudi();
            return;
        }
        foreach ($data as $key => $value) {
            $model->$key = $this->penilaianHurufAngkaId($value);
        }
        $model->save();
        return $model;
    }

    public function saveData($rows){
        $nilai_id = $this->getNilaiId($rows);
        $data = $this->getData($rows);

        foreach ($data as $key => $value) {
            $id_data = $value[0];
            foreach ($nilai_id as $key => $id) {
                $this->updateOrCreate([
                    'siswa_id' => $id_data,
                    'mapel_id' => $id,
                ], [
                    'nilai_uh_1' => $value[3], // Kolom ke-4
                    'nilai_uh_2' => $value[4], // Kolom ke-5
                    'nilai_uh_3' => $value[5], // Kolom ke-6
                    'nilai_uh_4' => $value[6], // Kolom ke-7
                    'nilai_tugas_1' => $value[7], // Kolom ke-8
                    'nilai_tugas_2' => $value[8], // Kolom ke-9
                    'nilai_uts' => $value[9], // Kolom ke-10
                    'nilai_pas' => $value[10], // Kolom ke-11
                    'nilai_akhir' => $this->nilaiAkhir([
                        $value[3], // nilai_uh_1
                        $value[4], // nilai_uh_2
                        $value[5], // nilai_uh_3
                        $value[6], // nilai_uh_4
                        $value[7], // nilai_tugas_1
                        $value[8], // nilai_tugas_2
                        $value[9], // nilai_uts
                        $value[10],// nilai_pas
                    ]),
                ]);
            }
        }
    }

    public function penilaianHurufAngkaId($nilai)
    {
        $nilai = $nilai == null || $nilai == 0 || $nilai == '' || $nilai == '0' ? 101 : $nilai;
        return $nilai;
    }

    public function nilaiAkhir(array $data)
    {
        $nilai_uh = ($data[0] + $data[1] + $data[2] + $data[3]) / 4;
        $nilai_tugas = ($data[4] + $data[5]) / 2;
        $nilai_uts = $data[6];
        $nilai_pas = $data[7];

        $nilai_akhir = ($nilai_uh + $nilai_tugas + $nilai_uts + $nilai_pas) / 4;
        $nilai_akhir = round($nilai_akhir, 0);
        return $nilai_akhir;
    }
}
