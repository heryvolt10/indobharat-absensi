<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;



class IndexExport implements FromCollection, WithHeadings, WithStyles, WithDefaultStyles, WithEvents, ShouldAutoSize, WithProperties, WithCustomStartCell
{
    use Exportable;

    private $filterSearch, $filterStatus, $submenu_id, $title, $papersize, $orientation, $headStandar;

    public function __construct($filterSearch, $filterStatus, $submenu_id, $title, $papersize, $orientation, $headStandar)
    {
        $this->filterSearch = $filterSearch;
        $this->filterStatus = $filterStatus;
        $this->submenu_id = $submenu_id;
        $this->title = $title;
        $this->papersize = $papersize;
        $this->orientation = $orientation;
        $this->headStandar = $headStandar;
    }

    public function collection()
    {
        // =========================== TABLE STANDAR ===================================
        if ($this->submenu_id == 'mt_status') {
            $query = \App\Models\M_mt_status::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.nama) AS row_num, ZZ.nama, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }
        if ($this->submenu_id == 'mt_unit') {
            $query = \App\Models\M_mt_unit::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.nama) AS row_num, ZZ.nama, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }
        if ($this->submenu_id == 'mt_gender') {
            $query = \App\Models\M_mt_gender::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.nama) AS row_num, ZZ.nama, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == 'mt_periode') {
            $query = \App\Models\M_mt_periode::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.tanggal ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.nama) AS row_num, ZZ.tanggal, ZZ.tanggal_mulai, ZZ.status, ZZ.org FROM(" . $query . ") ZZ";
        }


        // =========================== TABLE STANDAR END ===================================
        if ($this->submenu_id == 'mt_ptkp') {
            $query = \App\Models\M_mt_ptkp::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.nama) AS row_num, ZZ.nama, ZZ.ter_grup, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == 'mt_ter_ptkp') {
            $query = \App\Models\M_mt_ter_ptkp::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.grup ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.grup) AS row_num, ZZ.grup, ZZ.nilai, ZZ.persen, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == '3') {
            $query = \App\Models\M_users_role::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.seq, A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.f_org ASC, ZZ.nama) AS row_num, ZZ.nama, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == '4') {
            $query = \App\Models\M_users_menu::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.seq, A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.seq ASC, ZZ.nama) AS row_num, ZZ.nama, ZZ.seq, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == '5') {
            $query = \App\Models\M_users_submenu::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY D.seq, A.seq ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.menu_seq, ZZ.seq) AS row_num, ZZ.nama, ZZ.menu, ZZ.seq, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }


        if ($this->submenu_id == '11') {
            $query = \App\Models\M_mt_org::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY X.i_pusat DESC, X.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.i_pusat DESC, ZZ.nama) AS row_num, ZZ.nama, ZZ.pusat, ZZ.email, ZZ.no_tlp, ZZ.alamat, ZZ.kontak_person, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == '12') {
            $query = \App\Models\M_users::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.name ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.name) AS row_num, ZZ.name, ZZ.role, ZZ.email, ZZ.org, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == '13') {
            $query = \App\Models\M_mt_karyawan::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.f_org ASC, ZZ.nama) AS row_num, ZZ.nama, ZZ.NIK, ZZ.no_npwp, ZZ.no_bpjs, ZZ.nama_bank, ZZ.no_rek, ZZ.nama_rek, 
            ZZ.alamat, ZZ.tgl_bekerja, ZZ.divisi, ZZ.jabatan, ZZ.grade, ZZ.role, ZZ.gender, ZZ.agama, ZZ.ptkp, ZZ.org, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == '14') {
            $query = \App\Models\M_mt_divisi::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.f_org ASC, ZZ.nama) AS row_num, ZZ.nama, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == '15') {
            $query = \App\Models\M_mt_jabatan::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.f_org ASC, ZZ.nama) AS row_num, ZZ.nama, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }

        if ($this->submenu_id == '16') {
            $query = \App\Models\M_mt_grade::detail(null, 1, $this->filterSearch, $this->filterStatus);
            $query .= " ORDER BY A.nama ";
            $queryAll = "SELECT ROW_NUMBER() OVER (ORDER BY ZZ.f_org ASC, ZZ.nama) AS row_num, ZZ.nama, ZZ.no_lembur, ZZ.ket, ZZ.status FROM(" . $query . ") ZZ";
        }

        $result = DB::select($queryAll);

        return new Collection($result);
    }



    public function headings(): array
    {
        if ($this->headStandar == '1') {
            $dataHeader  =  [
                'No',
                'Nama',
                'Keterangan',
                'Status',
            ];
        } else {
            if ($this->submenu_id == 'mt_ptkp') {
                $dataHeader  =  [
                    'No',
                    'Nama',
                    'ter_grup',
                    'Keterangan',
                    'Status',
                ];
            }

            if ($this->submenu_id == 'mt_ter_ptkp') {
                $dataHeader  =  [
                    'No',
                    'grup',
                    'nilai',
                    'persen',
                    'Status',
                ];
            }

            if ($this->submenu_id == 'mt_periode') {
                $dataHeader  =  [
                    'No',
                    'Tanggal',
                    'Tanggal Mulai',
                    'Status',
                    'Org',
                ];
            }

            if ($this->submenu_id == '4') {
                $dataHeader  =  [
                    'No',
                    'Nama',
                    'seq',
                    'Keterangan',
                    'Status',
                ];
            }

            if ($this->submenu_id == '5') {
                $dataHeader  =  [
                    'No',
                    'Menu',
                    'Nama',
                    'seq',
                    'Keterangan',
                    'Status',
                ];
            }

            if ($this->submenu_id == '11') {
                $dataHeader  =  [
                    'No',
                    'Nama',
                    'Status Site',
                    'Email',
                    'No Tlp',
                    'Alamat',
                    'Kontak Person',
                    'Status',
                ];
            }

            if ($this->submenu_id == '12') {
                $dataHeader  =  [
                    'No',
                    'Nama',
                    'Role',
                    'Email',
                    'Org',
                    'Status',
                ];
            }

            if ($this->submenu_id == '13') {
                $dataHeader  =  [
                    'No',
                    'Nama',
                    'NIK',
                    'No NPWP',
                    'No BPJS',
                    'Nama Bank',
                    'No Rek',
                    'Pemilik Rek',
                    'Alamat',
                    'Tanggal Berkerja',
                    'Divisi',
                    'Jabatan',
                    'Grade',
                    'Role',
                    'Gender',
                    'Agama',
                    'PTKP',
                    'Org',
                    'Status',
                ];
            }

            if ($this->submenu_id == '16') {
                $dataHeader  =  [
                    'No',
                    'Nama',
                    'Tidak Ada Lembur',
                    'Keterangan',
                    'Org',
                    'Status',
                ];
            }
        }

        return $dataHeader;
    }

    public function properties(): array
    {
        return [
            'creator'        => session('user_name'),
            'lastModifiedBy' => session('user_name'),
            'title'          => $this->title,
            'description'    => $this->title,
            'subject'        => $this->title,
            'manager'        => session('user_name'),
            'company'        => session('user_sorg'),
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {

        return [
            'font' => ['size' => 11],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getRowDimension(1)->setRowHeight(height: 45);
        $sheet->mergeCells('A1:' . $sheet->getHighestColumn() . '1');
        $sheet->setCellValue('A1', '  ' . session('user_org'));

        $sheet->mergeCells('A2:' . $sheet->getHighestColumn() . '2');
        $sheet->setCellValue('A2', $this->title);

        $cellRange = 'A4:' . $sheet->getHighestColumn() . $sheet->getHighestRow();
        $sheet->setAutoFilter('A4:' . $sheet->getHighestColumn() . '4');
        $sheet->freezePane('A5');

        return [
            1    => [
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                'font' => ['bold' => true, 'size' => 20],
            ],
            2    => [
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                'font' => ['bold' => true, 'size' => 16],
            ],
            4    => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => Color::COLOR_GREEN],
                ],
            ],

            $cellRange => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_HAIR,
                        'color' => ['argb' => Color::COLOR_BLACK], // Optional: set border color
                    ],
                ],
            ]
        ];
    }


    public function startCell(): string
    {
        return 'A4';
    }

    // public function drawings()
    // {
    //     $imgLogo = storage_path('app/public/' . help_setapp('app_logo'));

    //     if ($imgLogo) {
    //         $imgLogoView = $imgLogo;
    //     } else {
    //         $imgLogoView = ENV('DEFAULT_IMG_ORG');
    //     }

    //     $drawing = new Drawing();
    //     $drawing->setName('Company Logo');
    //     $drawing->setDescription(session('user_org'));
    //     $drawing->setPath($imgLogoView);
    //     $drawing->setWidthAndHeight(60, 60);
    //     $drawing->setCoordinates('A1');

    //     return $drawing;
    // }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->getPageMargins()
                    ->setTop(0.25)->setBottom(0.5)
                    ->setLeft(0.25)->setRight(0.25)
                    ->setHeader(0.25)->setFooter(0.25);

                $hf = $sheet->getHeaderFooter();
                $hf->setDifferentFirst(false);
                $hf->setDifferentOddEven(false);
                $hf->setOddFooter('&LPrintBy:' . session('user_name') . ':' . Date('Y-m-d H:i:s') . ' &RPage. &P / &N');

                $sheet->getPageSetup()
                    ->setPaperSize($this->papersize)
                    ->setOrientation($this->orientation)
                    ->setHorizontalCentered(true)
                    ->setRowsToRepeatAtTopByStartAndEnd(1, 3)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0)
                    ->setScale(100);
            },
        ];
    }
}
