<?php

namespace App\Http\Controllers;

use App\Models\FooterConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FooterConfigController extends Controller
{
    public function edit()
    {
        $footer = FooterConfig::config();
        return view('admin.footer_config', compact('footer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo'                    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'redes_sociais.facebook'  => 'nullable|url|max:300',
            'redes_sociais.instagram' => 'nullable|url|max:300',
            'redes_sociais.youtube'   => 'nullable|url|max:300',
            'fale_conosco.*.setor'    => 'nullable|string|max:100',
            'fale_conosco.*.telefone' => 'nullable|string|max:100',
            'sede_telefone'           => 'nullable|string|max:100',
            'sede_email'              => 'nullable|email|max:150',
            'sede_endereco'           => 'nullable|string|max:500',
            'subsede_telefone'        => 'nullable|string|max:100',
            'subsede_endereco'        => 'nullable|string|max:500',
            'copyright'               => 'nullable|string|max:150',
        ], [
            'logo.image'              => 'O arquivo deve ser uma imagem.',
            'logo.mimes'              => 'Formatos aceitos: JPEG, PNG, JPG, GIF ou WEBP.',
            'logo.max'                => 'O logo não pode ter mais de 2MB.',
            'sede_email.email'        => 'Informe um e-mail válido.',
            'redes_sociais.*.url'     => 'Informe uma URL válida (ex: https://...).',
        ]);

        $footer = FooterConfig::config();

        // Upload do logo
        $logoPath = $footer->logo_path;
        if ($request->hasFile('logo')) {
            // Remove o logo antigo se existir
            if ($logoPath && Storage::disk('public')->exists('footer/' . $logoPath)) {
                Storage::disk('public')->delete('footer/' . $logoPath);
            }
            $file = $request->file('logo');
            $logoPath = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('footer', $logoPath, 'public');
        }

        // Processar "Fale Conosco": filtrar linhas vazias
        $faleConosco = [];
        if ($request->has('fale_conosco')) {
            foreach ($request->fale_conosco as $item) {
                if (!empty($item['setor']) || !empty($item['telefone'])) {
                    $faleConosco[] = [
                        'setor'    => trim($item['setor'] ?? ''),
                        'telefone' => trim($item['telefone'] ?? ''),
                    ];
                }
            }
        }

        $footer->update([
            'logo_path'        => $logoPath,
            'redes_sociais'    => $request->redes_sociais ?? [],
            'fale_conosco'     => $faleConosco,
            'sede_telefone'    => $request->sede_telefone,
            'sede_email'       => $request->sede_email,
            'sede_endereco'    => $request->sede_endereco,
            'subsede_telefone' => $request->subsede_telefone,
            'subsede_endereco' => $request->subsede_endereco,
            'copyright'        => $request->copyright,
        ]);

        return redirect()->route('footer-config.edit')
            ->with('success', 'Configurações do rodapé atualizadas com sucesso!');
    }
}
