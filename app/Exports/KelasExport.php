<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\SubKelas;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Guru;
use App\Models\Periode;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class KelasExport implements FromView, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    private $row_lenght, $column_length;
    private $judul;
    private $tahun_ajaran;
    private $semester;
    private $tanggal;
    private $file_identifier;
    
    
    public function __construct($informasi)
    {
        $this->judul = $informasi['judul'];
        $this->tahun_ajaran = $informasi['tahun_ajaran'];
        $this->semester = $informasi['semester'];
        $this->tanggal = $informasi['tanggal'];
        $this->file_identifier = $informasi['file_identifier'];
    }
    
    public function view(): View
    {
        $periode_id = Periode::where('status','aktif')->value('id');
        $kelas_d = SubKelas::all()->where('periode_id',$periode_id);
        
        $nilai_id = [];
        $modified_kelas_d = $kelas_d->groupBy(['id'])->map(function ($item) use (&$nilai_id) {
            $result = [];
            $result['id'] = $item[0]->id;
            $result['nama_sub_kelas'] = $item[0]->nama_sub_kelas;
            $result['tingkat_kelas'] = Kelas::where('id', $item[0]->kelas_id)->value('nama_kelas');
            $user_id = Guru::where('id', $item[0]->guru_id)->value('user_id');
            $result['guru'] = User::where('id', $user_id)->value('user_name');
            return $result;
        });
        // dd($modified_kelas_d);
        
        $this->row_lenght = count($modified_kelas_d) + 51;
        
        return view('dataKelas.export_excel', [
            'kelas_d' => $modified_kelas_d,
            'judul' => $this->judul,
            'tahun_ajaran' => $this->tahun_ajaran,
            'semester' => $this->semester,
            'tanggal' => $this->tanggal,
            'file_identifier' => $this->file_identifier,
        ]);
    }
    
    //style overflow column
    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getStyle('A8:D8')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A8:D8')->getAlignment()->setVertical('center');
        // $sheet->getStyle('E4:'. $this->getColumnIndex(5) . $this->row_lenght + 3)->getAlignment()->setShrinkToFit(true);
        $sheet->getStyle('A8:D8')->getFont()->setBold(true);
        // Add border to range
        $sheet->getStyle('A8:' . $this->getColumnIndex(4) . $this->row_lenght + 8)->getBorders()->getAllBorders()->setBorderStyle('thin');
        
        // Enable worksheet protection
        $sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);
        //Unprotect nilai cell
        $sheet->getStyle('B9:' . $this->getColumnIndex(4) . $this->row_lenght + 8)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
        
        // prompt id column
        $startCellA = 'A9'; // Starting cell for validation
        $endCellA = $this->getColumnIndex(1) . ($this->row_lenght + 8); // Ending cell for validation
        $validationRangeA = $startCellA . ':' . $endCellA;
        $validationA = $sheet->getCell($startCellA)->getDataValidation();
        $validationA->setType(DataValidation::TYPE_WHOLE);
        $validationA->setShowInputMessage(true);
        $validationA->setPromptTitle('ID Jangan Diubah');
        $validationA->setPrompt('ID akan dibuat otomatis oleh sistem');
        $sheet->setDataValidation($validationRangeA, $validationA);
        
        // Validation rule for column B
        $startCellB = 'B9'; // Starting cell for validation
        $endCellB = $this->getColumnIndex(2) . ($this->row_lenght + 8); // Ending cell for validation
        $validationRangeB = $startCellB . ':' . $endCellB;
        $validationB = $sheet->getCell($startCellB)->getDataValidation();
        $validationB->setType(DataValidation::TYPE_LIST);
        $validationB->setAllowBlank(false);
        $validationB->setShowInputMessage(true);
        $validationB->setShowErrorMessage(true);
        $validationB->setShowDropDown(true);
        $validationB->setErrorTitle('Tingkat kelas tidak valid');
        $validationB->setError('Tingkat kelas harus dipilih dari yang sudah ada!');
        $validationB->setPrompt('Pilih tingkat kelas');
        $validationB->setFormula1('"Kelas 1,Kelas 2,Kelas 3,Kelas 4,Kelas 5,Kelas 6"');
        $sheet->setDataValidation($validationRangeB, $validationB);
        
        // Validation rule for column D
        $startCellD = 'D9'; // Starting cell for validation
        $endCellD = $this->getColumnIndex(4) . ($this->row_lenght + 8); // Ending cell for validation
        $validationRangeD = $startCellD . ':' . $endCellD;
        $validationD = $sheet->getCell($startCellD)->getDataValidation();
        $validationD->setType(DataValidation::TYPE_LIST);
        $validationD->setAllowBlank(true);
        $validationD->setShowInputMessage(true);
        $validationD->setShowErrorMessage(true);
        $validationD->setShowDropDown(true);
        $validationD->setErrorTitle('Wali Kelas tidak valid');
        $validationD->setError('Wali Kelas harus dipilih dari guru yang sudah ada. Jika belum ada, silakan buat terlebih dahulu di menu Data Guru!');
        $validationD->setPromptTitle('Wali Kelas');
        $validationD->setPrompt('Pilih dari guru-guru yang ada');
        $user_id_guru = Guru::pluck('user_id');
        $panjangArray = count($user_id_guru);
        // dd($panjangArray, $user_id_guru);
        $array_guru = [];
        for ($i = 0; $i < $panjangArray; $i++) {
            $list_guru = User::where('id',$user_id_guru[$i])->pluck('user_name')->toArray();
            $array_guru = array_merge($array_guru,$list_guru);
        }
        // dd($array_guru);
        $validationD->setFormula1('"' . implode(',', $array_guru) . '"');
        $sheet->setDataValidation($validationRangeD, $validationD);
        
        //A2-A6 Auto width cell
        // $sheet->getColumnDimension('A')->setAutoSize(true);
        
    }
    
    private function getColumnIndex($index)
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index);
    }
    
    
}
