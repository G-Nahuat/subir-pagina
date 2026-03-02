<?php

namespace App\Exports;

use App\Models\AsistenteCurso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AsistenciaGrupoExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $grupo, $curso, $periodo;

    public function __construct($curso, $grupo)
    {
        $this->curso = $curso;
        $this->grupo = $grupo;

        $this->periodo = collect(); // default vacío

        // Validar fechas y construir el periodo si es válido
        if (!empty($curso->fecha) && str_contains($curso->fecha, ' - ')) {
            [$inicioStr, $finStr] = explode(' - ', $curso->fecha);

            try {
                $inicio = Carbon::createFromFormat('Y-m-d', trim($inicioStr));
                $fin = Carbon::createFromFormat('Y-m-d', trim($finStr));

                if ($inicio && $fin && $inicio->lessThanOrEqualTo($fin)) {
                    $this->periodo = CarbonPeriod::create($inicio, $fin);
                }
            } catch (\Exception $e) {
                // Si hay error de formato, simplemente se deja vacío
                $this->periodo = collect();
            }
        }
    }

    public function collection()
    {
        $asistentes = AsistenteCurso::where('id_curso', $this->curso->id)
            ->where('grupo', $this->grupo)
            ->with('diasAsistidos')
            ->get();

        $data = [];

        foreach ($asistentes as $a) {
            $fila = [$a->nombre];
            $total = 0;

            foreach ($this->periodo as $dia) {
                $presente = $a->diasAsistidos->contains('fecha', $dia->format('Y-m-d'));
                $fila[] = $presente ? '✔' : '';
                if ($presente) $total++;
            }

            $fila[] = $total;
            $data[] = $fila;
        }

        return collect($data);
    }

    public function headings(): array
    {
        $cabeceras = ['Nombre'];
        foreach ($this->periodo as $dia) {
            $cabeceras[] = $dia->format('d/m');
        }
        $cabeceras[] = 'Total';
        return $cabeceras;
    }

    public function styles(Worksheet $sheet)
    {
        $columnCount = $this->periodo->count() + 2;
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnCount);

        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9E1F2'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()
                    ->getStyle(
                        $event->sheet->calculateWorksheetDimension()
                    )
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);
            }
        ];
    }
}
