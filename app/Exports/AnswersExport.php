<?php

namespace App\Exports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnswersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithMapping, WithStyles
{
    protected $users;
    protected $questions;
    protected $answerValues;

    public function __construct($users, $questions, $answerValues)
    {
        $this->users = $users;
        $this->questions = $questions;
        $this->answerValues = $answerValues;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'Nama',
            'Tanggal',
        ];

        // Add question numbers as headers (1, 2, 3, ...)
        foreach ($this->questions as $index => $question) {
            $headings[] = (string)($index + 1);
        }

        // Add Saran/Keluhan column
        $headings[] = 'Saran/Keluhan';

        return $headings;
    }

    public function map($user): array
    {
        $row = [
            $user->id,
            $user->name,
            $user->created_at->format('d/m/Y'),
        ];

        // Add answers for each question
        $answersByQuestion = $user->questionnaireAnswers->keyBy('question_id');

        foreach ($this->questions as $question) {
            if (isset($answersByQuestion[$question->id])) {
                $answerText = $answersByQuestion[$question->id]->selectedOption->option_text;
                $row[] = $this->answerValues[$answerText] ?? '-';
            } else {
                $row[] = '-';
            }
        }

        // Add suggestion if exists
        $row[] = $user->suggestion ?? '-';

        return $row;
    }

    public function columnFormats(): array
    {
        $formats = [
            'A' => '0', // No
            'B' => '@', // Nama (text format)
            'C' => 'dd/mm/yyyy', // Tanggal
        ];

        // Set text format for all question columns
        $questionCount = count($this->questions);
        for ($i = 0; $i < $questionCount; $i++) {
            $column = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(4 + $i);
            $formats[$column] = '0'; // Numeric format for answers
        }

        // Set text format for suggestion column
        $suggestionCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(4 + $questionCount);
        $formats[$suggestionCol] = '@';

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
                'startColor' => ['rgb' => '005EB8'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style for data rows (alternating colors)
        for ($row = 2; $row <= $lastRow; $row++) {
            $color = $row % 2 == 0 ? 'EFF3FF' : 'FFFFFF'; // Alternate between light blue and white
            $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
            ]);
        }

        // Auto-size all columns
        foreach (range('A', $lastColumn) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }
}
