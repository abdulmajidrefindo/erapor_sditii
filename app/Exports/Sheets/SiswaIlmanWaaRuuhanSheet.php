<?php

namespace App\Exports\Sheets;

use App\Mpdels\IlmanWaaRuuhan;
use App\Models\SiswaIlmanWaaRuuhan;
use App\Models\Periode;
use App\Models\SubKelas;

use Illuminate\Contracts\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Style\Protection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class SiswaIlmanWaaRuuhanSheet implements FromView, WithStyles, WithTitle
{
    /**
    * @return \Illuminate\Support\View
    */

    private $row_lenght, $column_length;
    private $sub_kelas_id;
    private $judul;
    private $nama_kelas;
    private $wali_kelas;
    private $tahun_ajaran;
    private $semester;
    private $tanggal;
    private $file_identifier;

    private $mapel_id;

    public function __construct($sub_kelas_id, $informasi, $mapel_id)
    {
        $this->sub_kelas_id = $sub_kelas_id;
        $this->judul = $informasi['judul'];
        $this->nama_kelas = $informasi['nama_kelas'];
        $this->wali_kelas = $informasi['wali_kelas'];
        $this->tahun_ajaran = $informasi['tahun_ajaran'];
        $this->semester = $informasi['semester'];
        $this->tanggal = $informasi['tanggal'];
        $this->file_identifier = $informasi['file_identifier'];
        $this->nama_mapel = $informasi['nama_mapel'];
        $this->mapel_id = $mapel_id;

        $this->column_length = 3;
    }

    public function view(): View
    {
        
        $sub_kelas_id = $this->sub_kelas_id;
        $Ilman_waa_ruuhan_id = $this->mapel_id;

        $siswa_iwr = SiswaIlmanWaaRuuhan::with('siswa','ilman_waa_ruuhan','penilaian_huruf_angka')->where('ilman_waa_ruuhan_id',$Ilman_waa_ruuhan_id)->whereHas('siswa', function ($query) use ($sub_kelas_id) {
            $query->where('sub_kelas_id', $sub_kelas_id);
        })->get();

        $this->row_lenght = count($siswa_iwr);

        return view('siswaIWR.export_excel', [
            'siswa_iwr' => $siswa_iwr,
            'judul' => $this->judul,
            'nama_kelas' => $this->nama_kelas,
            'wali_kelas' => $this->wali_kelas,
            'tahun_ajaran' => $this->tahun_ajaran,
            'semester' => $this->semester,
            'tanggal' => $this->tanggal,
            'file_identifier' => $this->file_identifier,
            'column_length' => $this->column_length,
            'nama_mapel' => $this->nama_mapel,
            'nilai_id' => $this->mapel_id,
        ]);
    }

    public function title(): string
    {
        return $this->nama_mapel;
    }

    public function styles(Worksheet $sheet)
    {

        

        $sheet->getStyle('D10:' . $this->getColumnIndex($this->column_length + 3) .'10')->getAlignment()->setWrapText(true);
        $sheet->getStyle('D10:' . $this->getColumnIndex($this->column_length + 3) .'10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D10:' . $this->getColumnIndex($this->column_length + 3) .'10')->getAlignment()->setVertical('center');
        $sheet->getStyle('D10:' . $this->getColumnIndex($this->column_length + 3) .'10')->getAlignment()->setShrinkToFit(true);
        $sheet->getStyle('A9:' . $this->getColumnIndex($this->column_length + 3) .'10')->getFont()->setBold(true);
        // Set Last Row to Bold
        $sheet->getStyle('A' . ($this->row_lenght + 11) . ':' . $this->getColumnIndex($this->column_length + 3) . ($this->row_lenght + 11))->getFont()->setBold(true);
        
        // Enable worksheet protection
        $sheet->getParent()->getActiveSheet()->getProtection()->setSheet(true);
        //Unprotect nilai cell
        $sheet->getStyle('D11:' . $this->getColumnIndex($this->column_length + 3) . $this->row_lenght + 10)->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);

        // Add border to range
        $sheet->getStyle('A9:' . $this->getColumnIndex($this->column_length + 3) . $this->row_lenght + 11)->getBorders()->getAllBorders()->setBorderStyle('thin');

        //validation rule for nilai cell as integer between 0-100 and not empty only
        $startCell = 'D11'; // Starting cell for validation
        $endCell = $this->getColumnIndex($this->column_length + 3) . ($this->row_lenght + 10); // Ending cell for validation
        $validationRange = $startCell . ':' . $endCell;
        $validation = $sheet->getCell($startCell)->getDataValidation();
        $validation->setType(DataValidation::TYPE_WHOLE);
        $validation->setOperator(DataValidation::OPERATOR_BETWEEN);
        $validation->setAllowBlank(false); 
        $validation->setFormula1(0);
        $validation->setFormula2(100);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setShowErrorMessage(true);
        $validation->setErrorTitle('Input Salah');
        $validation->setError('Nilai harus berupa angka antara 0-100');
        $validation->setShowInputMessage(true);
        $validation->setPromptTitle('Atur Penilaian');
        $validation->setPrompt('Masukkan nilai antara 0-100');
        $sheet->setDataValidation($validationRange, $validation);

        //A2-A6 Auto width cell
        $sheet->getColumnDimension('A')->setAutoSize(true);

    }

    private function getColumnIndex($index)
    {
        return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index);
    }
}
