<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Http\Requests\StoreMediaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $media = Media::latest()->paginate(20);

        if ($request->wantsJson()) {
            return response()->json($media);
        }

        return view('admin.media.index', compact('media'));
    }

    /**
     * Sync files from public/images and storage/app/public to database
     */
    public function sync()
    {
        $count = 0;
        
        // 1. Scan public/images
        $publicImagesPath = public_path('images');
        if (File::exists($publicImagesPath)) {
            $files = File::allFiles($publicImagesPath);
            foreach ($files as $file) {
                $relativePath = 'images/' . $file->getRelativePathname();
                $count += $this->registerMedia($file, $relativePath);
            }
        }

        // 2. Scan storage/app/public
        $storagePath = storage_path('app/public');
        if (File::exists($storagePath)) {
            $files = File::allFiles($storagePath);
            foreach ($files as $file) {
                // Skip hidden files
                if (str_starts_with($file->getFilename(), '.')) {
                    continue;
                }
                
                $relativePath = 'storage/' . $file->getRelativePathname();
                $count += $this->registerMedia($file, $relativePath);
            }
        }

        return redirect()->back()->with('sucesso', "Sincronização concluída! $count novas imagens encontradas.");
    }

    private function registerMedia($file, $relativePath)
    {
        // Normalize slashes for consistency
        $relativePath = str_replace('\\', '/', $relativePath);

        // Check if exists in DB
        if (Media::where('path', $relativePath)->exists()) {
            return 0;
        }

        Media::create([
            'filename' => $file->getFilename(),
            'title' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
            'path' => $relativePath,
            'mime_type' => mime_content_type($file->getPathname()) ?: 'application/octet-stream',
            'size' => $file->getSize(),
            'alt_text' => pathinfo($file->getFilename(), PATHINFO_FILENAME), // Default alt text
        ]);

        return 1;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMediaRequest $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $path = $file->store('media', 'public');
            $mime_type = $file->getMimeType();
            $size = $file->getSize();

            Media::create([
                'filename' => $filename,
                'title' => $request->input('title', pathinfo($filename, PATHINFO_FILENAME)),
                'path' => 'storage/' . $path,
                'mime_type' => $mime_type,
                'size' => $size,
                'alt_text' => $request->input('alt_text'),
                'description' => $request->input('description'),
            ]);

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Upload realizado com sucesso!']);
            }

            return redirect()->back()->with('sucesso', 'Upload realizado com sucesso!');
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Nenhum arquivo enviado.'], 400);
        }

        return redirect()->back()->with('erro', 'Nenhum arquivo enviado.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $medium)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $medium->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Imagem atualizada com sucesso!', 'data' => $medium]);
        }

        return redirect()->back()->with('sucesso', 'Imagem atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Media $medium)
    {
        // Remove file from storage
        $path = str_replace('storage/', '', $medium->path);
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $medium->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Imagem excluída.']);
        }

        return redirect()->back()->with('sucesso', 'Imagem excluída com sucesso.');
    }
}
