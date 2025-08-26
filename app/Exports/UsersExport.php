<?php

namespace App\Exports;

use App\Models\FormUser;
use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Log;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    protected $questions;

    public function __construct()
    {
        // Get all questions to use as column headers, ordered by ID
        $this->questions = Question::with('options')->orderBy('id')->get();
    }
    
    /**
     * Set column formats
     *
     * @return array
     */
    public function columnFormats(): array
    {
        // Set specific formats for different columns
        $formats = [
            'A' => '@', // Nama
            'B' => 'dd/mm/yyyy', // Tanggal
            'C' => '@', // Alamat
            'D' => '0', // Umur
            'E' => '@', // Jenis Kelamin
            'F' => '@', // No HP
            'G' => '@', // Pendidikan
            'H' => '@', // Pekerjaan
            'I' => '@', // Jenis Layanan
            'J' => '@', // Saran
        ];
        
        // Set text format for question columns
        $questionCount = count($this->questions);
        for ($i = 0; $i < $questionCount; $i++) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(10 + $i);
            $formats[$column] = '@'; // Text format for answers
        }
        
        return $formats;
    }
    
    public function styles(Worksheet $sheet)
    {
        $lastColumn = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();
        
        // Style for header row (row 1)
        $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '005EB8'], // Dark blue
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '003366'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);
        
        // Style for data rows
        $sheet->getStyle('A2:' . $lastColumn . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'wrapText' => true,
            ],
        ]);
        
        // Alternating row colors
        for ($row = 2; $row <= $lastRow; $row++) {
            $color = $row % 2 == 0 ? 'FFFFFF' : 'F5F9FF'; // White and light blue
            $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB($color);
        }
        
        // Auto-size all columns
        foreach (range('A', $lastColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);
        
        // Freeze the header row
        $sheet->freezePane('A2');
    }

    public function collection()
    {
        // Get all questions with their options
        $questions = Question::with('options')->orderBy('id')->get();

        // Get all form users with their answers
        $formUsers = FormUser::with(['personalData', 'questionnaireAnswers.selectedOption'])->get();

        // Create a mapping of question IDs to their text
        $questionMap = [];
        foreach ($questions as $question) {
            $questionMap[$question->id] = $question->text;
        }

        return $formUsers->map(function ($user) use ($questions, $questionMap) {
            // Start with basic user data
            $data = [
                'Nama'          => $user->personalData->full_name ?? 'Tanpa Nama',
                'Tanggal'       => $user->created_at->format('d/m/Y'),
                'Alamat'        => $user->personalData->address ?? '-',
                'Umur'          => $user->personalData->age ?? '-',
                'Jenis Kelamin' => $user->personalData->gender ?? '-',
                'No HP'         => $user->personalData->phone_number ?? '-',
                'Pendidikan'    => $user->personalData->education ?? '-',
                'Pekerjaan'     => $user->personalData->occupation ?? '-',
                'Jenis Layanan' => $user->personalData->service_type ?? '-',
                'Saran'         => $user->suggestion ?? '-',
            ];

            // Add questionnaire answers using question text as key
            foreach ($questions as $question) {
                $answer = $user->questionnaireAnswers->firstWhere('question_id', $question->id);
                $data[$question->text] = $answer && $answer->selectedOption
                    ? $answer->selectedOption->option_text
                    : 'Tidak diisi';
            }

            return $data;
        });
    }

    public function headings(): array
    {
        // Start with basic headers
        $headings = [
            'Nama',
            'Tanggal',
            'Alamat',
            'Umur',
            'Jenis Kelamin',
            'No HP',
            'Pendidikan',
            'Pekerjaan',
            'Jenis Layanan',
            'Saran',
        ];

        // Add question texts as headers
        $questions = Question::orderBy('id')->get();
        foreach ($questions as $question) {
            // Add each question as a separate column
            $headings[] = $question->text;
        }

        return $headings;
    }
}
