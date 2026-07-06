<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HandlesBlockContent
{
    /**
     * Memproses upload file untuk komponen Block-Based Builder.
     * Dapat digunakan saat Create maupun Update.
     *
     * @param Request $request
     * @param array|null $oldBlocks (Opsional) Data blok lama saat proses Update
     * @return array
     */
    protected function processBlockContent(Request $request, $oldBlocks = [])
    {
        $validatedBlocks = $request->input('content_blocks', []);
        
        if (empty($validatedBlocks)) {
            return [];
        }

        foreach ($validatedBlocks as $index => &$block) {
            // 1. Handle tipe 'gambar' dan 'file'
            if (in_array($block['type'], ['gambar', 'file'])) {
                if ($request->hasFile("content_blocks.{$index}.content")) {
                    $block['content'] = $request->file("content_blocks.{$index}.content")->store('blocks', 'public');
                } elseif (isset($oldBlocks[$index]['content'])) {
                    // Pertahankan path lama jika metode adalah update
                    $block['content'] = $oldBlocks[$index]['content'];
                }
            }

            // 2. Handle tipe 'video'
            if ($block['type'] === 'video') {
                if ($request->hasFile("content_blocks.{$index}.content")) {
                    $file = $request->file("content_blocks.{$index}.content");
                    if ($file->getSize() > 20 * 1024 * 1024) {
                        // Jika gagal, kembalikan response exception (atau lempar exception khusus)
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'content_blocks' => 'Ukuran video pada blok ke-'.($index+1).' tidak boleh melebihi 20MB.'
                        ]);
                    }
                    $block['content'] = $file->store('blocks', 'public');
                } elseif (isset($oldBlocks[$index]['content'])) {
                    $block['content'] = $oldBlocks[$index]['content'];
                }
            }

            // 3. Handle tipe 'grup_teks_gambar'
            if ($block['type'] === 'grup_teks_gambar') {
                if ($request->hasFile("content_blocks.{$index}.content.gambar")) {
                    $block['content']['gambar'] = $request->file("content_blocks.{$index}.content.gambar")->store('blocks', 'public');
                } elseif (isset($oldBlocks[$index]['content']['gambar'])) {
                    $block['content']['gambar'] = $oldBlocks[$index]['content']['gambar'];
                }
            }

            // 4. Handle tipe 'slider' dan 'grup_gambar'
            if (in_array($block['type'], ['slider', 'grup_gambar'])) {
                if ($request->hasFile("content_blocks.{$index}.content")) {
                    $sliderFiles = $request->file("content_blocks.{$index}.content");
                    $paths = [];
                    foreach ($sliderFiles as $sliderFile) {
                        $paths[] = $sliderFile->store('blocks', 'public');
                    }
                    $block['content'] = $paths;
                } elseif (isset($oldBlocks[$index]['content']) && is_array($oldBlocks[$index]['content'])) {
                    $block['content'] = $oldBlocks[$index]['content'];
                } else {
                    $block['content'] = [];
                }
            }
        }

        return $validatedBlocks;
    }
}
