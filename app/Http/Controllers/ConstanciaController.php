<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCPDF;
use Illuminate\Support\Str;
use ZipArchive;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\AsistenteCurso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Curso;

class ConstanciaController extends Controller
{
    public function generar($id)
{
    $asistente = DB::table('asistentes_cursos')
        ->join('cursos', 'asistentes_cursos.id_curso', '=', 'cursos.id')
        ->select(
            'asistentes_cursos.id',
            'asistentes_cursos.nombre as nombre_participante',
            'cursos.descripcion',
            'cursos.tipo'
        )
        ->where('asistentes_cursos.id', $id)
        ->first();

    if (!$asistente) {
        abort(404, 'Participante no encontrado.');
    }

    $tipo = strtolower($asistente->tipo);
    switch ($tipo) {
        case 'constancia':
            $plantilla = public_path('plantillas/cba5687eb36affdc0132a13ec37898ba_t.png');
            break;
        case 'reconocimiento':
            $plantilla = public_path('plantillas/d50ea895a4d40af03adbb2e4bd753a25_t.png');
            break;
        case 'nombramiento':
            $plantilla = public_path('plantillas/nombramiento.png');
            break;
        default:
            abort(400, 'Tipo de documento no válido.');
    }

    if (!file_exists($plantilla)) {
        abort(500, "No se encontró la plantilla: {$plantilla}");
    }

    $pdf = new \TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();

    $pdf->Image($plantilla, 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'PNG');

    $pdf->SetFont('helvetica', 'B', 22);
    $htmlNombre = '<div style="text-align:center;">
        <span style="color:#3D3935;"><strong>A: </strong></span>
        <span style="color:#AB0A3D;">' . mb_strtoupper($asistente->nombre_participante) . '</span>
    </div>';
    $pdf->SetY(110);
    $pdf->writeHTMLCell(200, 0, 15, '', $htmlNombre, 0, 1, true, true, 'C');

    // ==== Texto justificado sin sangría invisible ====
    $pdf->SetFont('helvetica', '', 13);
    $descripcion = $asistente->descripcion;

   $htmlDesc = <<<EOD
<table cellpadding="0" cellspacing="0" style="margin:0; padding:0; width:100%;">
  <tr>
    <td style="margin:0; padding:0; text-align:justify; font-size:13.5px; color:#3D3935; line-height:1.5;">
      <span style="margin:0; padding:0;">{$descripcion}</span>
    </td>
  </tr>
</table>
EOD;


    // Posición y tamaño del cuadro
    $posX = 50;
    $posY = 135;
    $ancho = 150;
    $alto = 30;

    $pdf->writeHTMLCell($ancho, $alto, $posX, $posY, $htmlDesc, 0, 1, true, true, 'J');

    $nombreArchivo = Str::slug($asistente->nombre_participante) . '_' . $tipo . '.pdf';
    return response($pdf->Output($nombreArchivo, 'S'), 200, [
        'Content-Type' => 'application/pdf'
    ]);
}






 public function descargarTodas($cursoId)
{
    $asistentes = DB::table('asistentes_cursos')
        ->join('cursos', 'asistentes_cursos.id_curso', '=', 'cursos.id')
        ->select(
            'asistentes_cursos.id',
            'asistentes_cursos.nombre as nombre_participante',
            'cursos.descripcion',
            'cursos.tipo'
        )
        ->where('asistentes_cursos.asistio', 1)
        ->where('asistentes_cursos.id_curso', $cursoId)
        ->get();

    if ($asistentes->isEmpty()) {
        return back()->with('error', 'No hay asistentes marcados como “Sí” en este curso.');
    }

    $zipPath = storage_path('app/constancias.zip');
    if (file_exists($zipPath)) unlink($zipPath);
    $zip = new \ZipArchive();
    $zip->open($zipPath, \ZipArchive::CREATE);

    foreach ($asistentes as $as) {
        $plantilla = $this->obtenerPlantilla($as->tipo);

        $pdf = new \TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->Image($plantilla, 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'PNG');

        // Nombre
        $pdf->SetFont('helvetica', '', 22);
        $nombre = mb_strtoupper($as->nombre_participante);
        $htmlNombre = <<<EOD
<table style="width:100%;">
  <tr>
    <td style="text-align:center;">
      <span style="color:#3D3935;"><strong>A: </strong></span>
      <span style="color:#AB0A3D; font-weight:bold;">{$nombre}</span>
    </td>
  </tr>
</table>
EOD;
        $pdf->SetY(110);
        $pdf->writeHTMLCell(0, 0, 0, '', $htmlNombre, 0, 1, true, true, 'C');

        // Descripción
        $pdf->SetFont('helvetica', '', 13);
        $htmlDesc = <<<EOD
<div style="text-align: justify; color:#3D3935; font-size:13.5px; line-height:1.5;">{$as->descripcion}</div>
EOD;
        $pdf->writeHTMLCell(150, 30, 48, 135, $htmlDesc, 0, 1, true, true, 'J');

        $pdfData = $pdf->Output('', 'S');
        $fileName = Str::slug($as->nombre_participante) . '_constancia.pdf';
        $zip->addFromString($fileName, $pdfData);
    }

    $zip->close();
    return response()->download($zipPath, 'constancias.zip')->deleteFileAfterSend(true);
}

public function descargarTodasEnPDF($cursoId)
{
    $asistentes = DB::table('asistentes_cursos')
        ->join('cursos', 'asistentes_cursos.id_curso', '=', 'cursos.id')
        ->select(
            'asistentes_cursos.id',
            'asistentes_cursos.nombre as nombre_participante',
            'cursos.descripcion',
            'cursos.tipo'
        )
        ->where('asistentes_cursos.asistio', 1)
        ->where('asistentes_cursos.id_curso', $cursoId)
        ->get();

    if ($asistentes->isEmpty()) {
        return back()->with('error', 'No hay asistentes marcados como “Sí” en este curso.');
    }

    $pdf = new \TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(false);

    foreach ($asistentes as $as) {
        $plantilla = $this->obtenerPlantilla($as->tipo);

        $pdf->AddPage();
        $pdf->Image($plantilla, 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'PNG');

        // Nombre
        $pdf->SetFont('helvetica', '', 22);
        $nombre = mb_strtoupper($as->nombre_participante);
        $htmlNombre = <<<EOD
<table style="width:100%;">
  <tr>
    <td style="text-align:center;">
      <span style="color:#3D3935;"><strong>A: </strong></span>
      <span style="color:#AB0A3D; font-weight:bold;">{$nombre}</span>
    </td>
  </tr>
</table>
EOD;
        $pdf->SetY(110);
        $pdf->writeHTMLCell(0, 0, 0, '', $htmlNombre, 0, 1, true, true, 'C');

        // Descripción
        $pdf->SetFont('helvetica', '', 13);
        $htmlDesc = <<<EOD
<div style="text-align: justify; color:#3D3935; font-size:13.5px; line-height:1.5;">{$as->descripcion}</div>
EOD;
        $pdf->writeHTMLCell(150, 30, 48, 135, $htmlDesc, 0, 1, true, true, 'J');
    }

    return response($pdf->Output('constancias_todas.pdf', 'S'), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="constancias_todas.pdf"'
    ]);
}

private function obtenerPlantilla($tipo)
{
    $tipo = strtolower($tipo);
    switch ($tipo) {
        case 'constancia':
            return public_path('plantillas/cba5687eb36affdc0132a13ec37898ba_t.png');
        case 'reconocimiento':
            return public_path('plantillas/d50ea895a4d40af03adbb2e4bd753a25_t.png');
        case 'nombramiento':
            return public_path('plantillas/nombramiento.png');
        default:
            return public_path('plantillas/cba5687eb36affdc0132a13ec37898ba_t.png');
    }
}

    public function generadorReconocimiento()
{
    return view('admin.constancias.generador');
}

public function generarReconocimientoManual(Request $request)
{
    $request->validate([
        'nombres' => 'required|array|min:1',
        'descripciones' => 'required|array|min:1',
        'nombres.*' => 'required|string|max:255',
        'descripciones.*' => 'required|string|max:1000',
    ]);

    $nombres = $request->input('nombres');
    $descripciones = $request->input('descripciones');

    $plantilla = public_path('plantillas/d50ea895a4d40af03adbb2e4bd753a25_t.png');
    if (!file_exists($plantilla)) {
        abort(500, "No se encontró la plantilla: {$plantilla}");
    }

    $zipPath = storage_path('app/reconocimientos_generados.zip');
    if (file_exists($zipPath)) unlink($zipPath);

    $zip = new \ZipArchive();
    $zip->open($zipPath, \ZipArchive::CREATE);

    foreach ($nombres as $i => $nombre) {
        $descripcion = $descripciones[$i];

        $pdf = new \TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $pdf->Image($plantilla, 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'PNG');

        // Nombre centrado con salto si es largo
        $pdf->SetFont('helvetica', '', 22);
        $nombreMayus = mb_strtoupper($nombre);
        $htmlNombre = <<<EOD
<table style="width:100%;">
  <tr>
    <td style="text-align:center;">
      <span style="color:#3D3935;"><strong>A: </strong></span>
      <span style="color:#AB0A3D; font-weight:bold;">{$nombreMayus}</span>
    </td>
  </tr>
</table>
EOD;
        $pdf->SetY(110);
        $pdf->writeHTMLCell(0, 0, 0, '', $htmlNombre, 0, 1, true, true, 'C');

        // Descripción justificada
        $pdf->SetFont('helvetica', '', 13);
        $htmlDesc = <<<EOD
<div style="text-align: justify; color:#3D3935; font-size:13.5px; line-height:1.5;">{$descripcion}</div>
EOD;

        $pdf->writeHTMLCell(150, 30, 48, 135, $htmlDesc, 0, 1, true, true, 'J');

        $pdfData = $pdf->Output('', 'S');
        $fileName = \Illuminate\Support\Str::slug($nombre) . '_reconocimiento.pdf';
        $zip->addFromString($fileName, $pdfData);
    }

    $zip->close();

    return response()->download($zipPath, 'reconocimientos.zip')->deleteFileAfterSend(true);
}


public function descargar(Request $request, $id)
{
    // 1) Verifica que el enlace esté firmado
    if (! $request->hasValidSignature()) {
        abort(403, 'Enlace inválido o expirado.');
    }

    // 2) Usuario autenticado
    $usuario = Auth::user();
    if (! $usuario) {
        abort(403, 'No estás autenticado.');
    }

    // 3) Buscar al asistente
    $asistente = AsistenteCurso::findOrFail($id);

    // 4) Verifica que el correo del usuario coincida con el del asistente
    if (strtolower(optional($usuario->datosGenerales)->email) !== strtolower($asistente->correo)) {
        abort(403, 'No tienes permiso para esta constancia.');
    }

    // 5) Datos para el PDF
    $nombre = $asistente->nombre;
    $descripcion = $asistente->curso->descripcion ?? 'Constancia de participación';
    $plantilla = public_path('plantillas/cba5687eb36affdc0132a13ec37898ba_t.png');

    if (!file_exists($plantilla)) {
        abort(500, 'No se encontró la plantilla de la constancia.');
    }

    // 6) Crear PDF con TCPDF
    $pdf = new \TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
    $pdf->SetPrintHeader(false);
    $pdf->SetPrintFooter(false);
    $pdf->SetMargins(0, 0, 0);
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();

    // Fondo
    $pdf->Image($plantilla, 0, 0, $pdf->getPageWidth(), $pdf->getPageHeight(), 'PNG');

    // Nombre centrado con formato
    $pdf->SetFont('helvetica', 'B', 22);
    $nombreMayus = mb_strtoupper($nombre);
    $htmlNombre = <<<EOD
<table style="width:100%;">
  <tr>
    <td style="text-align:center;">
      <span style="color:#3D3935;"><strong>A: </strong></span>
      <span style="color:#AB0A3D; font-weight:bold;">{$nombreMayus}</span>
    </td>
  </tr>
</table>
EOD;
    $pdf->SetY(110);
    $pdf->writeHTMLCell(0, 0, 0, '', $htmlNombre, 0, 1, true, true, 'C');

    // Descripción justificada
    $pdf->SetFont('helvetica', '', 13);
    $htmlDesc = <<<EOD
<div style="text-align: justify; color:#3D3935; font-size:13.5px; line-height:1.5;">{$descripcion}</div>
EOD;
    $pdf->writeHTMLCell(150, 30, 48, 135, $htmlDesc, 0, 1, true, true, 'J');

    // Descargar directamente
    return response($pdf->Output('constancia.pdf', 'S'), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="constancia.pdf"'
    ]);
}


}