<?php

namespace App\Http\Controllers;

use App\Models\GaleriaImagem;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download($id)
    {
        $file = GaleriaImagem::findOrFail($id);

        $filePath = $file->path;

        // Verificar se o arquivo existe
        if (!Storage::disk("posts_files")->exists($filePath)) {
            abort(404);
        }

        // Fornecer o arquivo como resposta de download
        //return Storage::disk('posts_files')->download($filePath);

        // Obter o conteúdo do arquivo
        $fileContents = Storage::disk('posts_files')->get($filePath);

        // Obter a extensão do arquivo para definir o tipo de conteúdo
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Mapear a extensão para o tipo de conteúdo MIME
        $mimeType = $this->getMimeType($extension);

        // Retornar o conteúdo do arquivo como resposta
        return response($fileContents, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline');
    }

    // Função para mapear extensões de arquivos para tipos MIME
    private function getMimeType($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            // Adicione mais tipos conforme necessário
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
