<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Media;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminBlogController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('published_at', 'desc')->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->except('imagem_destaque');
        $data['slug'] = Str::slug($request->titulo);
        
        // Process Tags (comma separated string to array)
        if (!empty($data['tags'])) {
            $data['tags'] = array_map('trim', explode(',', $data['tags']));
        } else {
            $data['tags'] = null;
        }

        // Process Meta Schema (ensure JSON is valid or decode if needed, but here we keep it as array if possible or string)
        // If the input is a JSON string, we should decode it to array because the Model casts it to array.
        // If we save a string to a json column cast as array, Laravel might double encode it.
        if (!empty($data['meta_schema'])) {
            $decoded = json_decode($data['meta_schema'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['meta_schema'] = $decoded;
            }
        }

        // Handle Image Upload
        if ($request->hasFile('imagem_destaque')) {
            $file = $request->file('imagem_destaque');
            
            // Fallbacks inteligentes para SEO
            $seoTitle = $request->imagem_title ?? Str::slug($request->titulo);
            $seoAlt = $request->imagem_alt ?? $request->titulo;

            try {
                $uploadData = $this->optimizeAndUpload($file, $seoTitle);
                $data['imagem_destaque'] = $uploadData['path'];

                // Register in Media Library
                Media::create([
                    'filename' => $uploadData['filename'],
                    'path' => $uploadData['path'],
                    'mime_type' => $uploadData['mime_type'],
                    'size' => $uploadData['size'],
                    'alt_text' => $seoAlt,
                ]);
            } catch (\Exception $e) {
                // Fallback to original if optimization fails
                $path = $file->store('blog', 'public');
                $fullPath = 'storage/' . $path;
                $data['imagem_destaque'] = $fullPath;

                Media::create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $fullPath,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'alt_text' => $seoAlt,
                ]);
            }
        }

        // Set published_at if not provided but published is true, or strictly follow input
        // Defaulting published to false if not present (checkbox behavior)
        $data['publicado'] = $request->has('publicado');
        
        if ($data['publicado'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Post::create($data);

        return redirect()->route('admin.blog.index')->with('sucesso', 'Post criado com sucesso!');
    }

    public function edit(Post $blog)
    {
        return view('admin.blog.edit', ['post' => $blog]);
    }

    public function update(UpdatePostRequest $request, Post $blog)
    {
        $data = $request->except('imagem_destaque');
        $data['slug'] = Str::slug($request->titulo);

        // Process Tags
        if (isset($data['tags'])) {
            if (!empty($data['tags'])) {
                $data['tags'] = array_map('trim', explode(',', $data['tags']));
            } else {
                $data['tags'] = null;
            }
        }

        // Process Meta Schema
        if (!empty($data['meta_schema'])) {
            $decoded = json_decode($data['meta_schema'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['meta_schema'] = $decoded;
            }
        }

        if ($request->hasFile('imagem_destaque')) {
            // Delete old image if exists
            if ($blog->imagem_destaque && file_exists(public_path($blog->imagem_destaque))) {
                // This is a simple check, ideally use Storage facade if paths are relative to storage
            }
            
            $file = $request->file('imagem_destaque');
            
            // Fallbacks inteligentes para SEO
            $seoTitle = $request->imagem_title ?? Str::slug($request->titulo);
            $seoAlt = $request->imagem_alt ?? $request->titulo;

            try {
                $uploadData = $this->optimizeAndUpload($file, $seoTitle);
                $data['imagem_destaque'] = $uploadData['path'];

                // Register in Media Library
                Media::create([
                    'filename' => $uploadData['filename'],
                    'path' => $uploadData['path'],
                    'mime_type' => $uploadData['mime_type'],
                    'size' => $uploadData['size'],
                    'alt_text' => $seoAlt,
                ]);
            } catch (\Exception $e) {
                // Fallback to original if optimization fails
                $path = $file->store('blog', 'public');
                $fullPath = 'storage/' . $path;
                $data['imagem_destaque'] = $fullPath;

                Media::create([
                    'filename' => $file->getClientOriginalName(),
                    'path' => $fullPath,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'alt_text' => $seoAlt,
                ]);
            }
        }

        $data['publicado'] = $request->has('publicado');

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('sucesso', 'Post atualizado com sucesso!');
    }

    public function destroy(Post $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('sucesso', 'Post removido com sucesso!');
    }

    /**
     * Otimiza a imagem enviada (Resize + WebP + Compressão)
     */
    private function optimizeAndUpload($file, $customFilename = null)
    {
        // Cria a imagem a partir do conteúdo do arquivo
        $content = file_get_contents($file->getRealPath());
        $image = @imagecreatefromstring($content);
        
        if (!$image) {
            throw new \Exception('Formato de imagem não suportado ou arquivo corrompido.');
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $maxWidth = 720; // Reduzido para 720px (Mobile first)

        // Redimensionar se for maior que o limite
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = floor($height * ($maxWidth / $width));
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preservar transparência
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $newImage;
        } else {
            // Converter paleta para truecolor para garantir compatibilidade com filtros webp se necessário
            if (!imageistruecolor($image)) {
                imagepalettetotruecolor($image);
            }
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }

        // Bufferizar a saída WebP
        ob_start();
        imagewebp($image, null, 40); // Qualidade reduzida para 40 (Extrema)
        $webpContent = ob_get_clean();
        imagedestroy($image);
        
        // Gerar nome único
        if ($customFilename) {
            $baseName = Str::slug($customFilename);
            $filename = 'blog/' . $baseName . '-' . Str::random(6) . '.webp';
        } else {
            $filename = 'blog/' . Str::random(40) . '.webp';
        }
        
        // Salvar no disco público
        Storage::disk('public')->put($filename, $webpContent);
        
        return [
            'path' => 'storage/' . $filename,
            'size' => strlen($webpContent),
            'mime_type' => 'image/webp',
            'filename' => pathinfo($filename, PATHINFO_BASENAME)
        ];
    }
}
