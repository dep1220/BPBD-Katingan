<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateFileUpload
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if request has file uploads
        if ($request->hasFile('gambar_utama') || $request->hasFile('gambar') || 
            $request->hasFile('foto') || $request->hasFile('icon') || 
            $request->hasFile('file') || $request->hasFile('foto_anggota')) {
            
            $files = array_filter([
                $request->file('gambar_utama'),
                $request->file('gambar'),
                $request->file('foto'),
                $request->file('icon'),
                $request->file('file'),
                $request->file('foto_anggota'),
            ]);
            
            foreach ($files as $file) {
                if (!$file) continue;
                
                // Check real MIME type (not just extension)
                $mimeType = $file->getMimeType();
                
                // Allowed MIME types
                $allowedImageMimes = [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp',
                    'image/svg+xml',
                ];
                
                $allowedDocumentMimes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ];
                
                $allowedMimes = array_merge($allowedImageMimes, $allowedDocumentMimes);
                
                // Block executable files and scripts
                $dangerousExtensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'exe', 'bat', 'sh', 'js', 'html', 'htm'];
                $extension = strtolower($file->getClientOriginalExtension());
                
                if (in_array($extension, $dangerousExtensions)) {
                    return response()->json([
                        'message' => 'File type not allowed for security reasons.',
                        'errors' => ['file' => ['Tipe file berbahaya dan tidak diizinkan.']]
                    ], 422);
                }
                
                // Validate MIME type
                if (!in_array($mimeType, $allowedMimes)) {
                    return response()->json([
                        'message' => 'Invalid file type.',
                        'errors' => ['file' => ['Tipe file tidak valid atau tidak diizinkan.']]
                    ], 422);
                }
                
                // Check file size (max 10MB)
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return response()->json([
                        'message' => 'File too large.',
                        'errors' => ['file' => ['Ukuran file melebihi batas maksimum 10MB.']]
                    ], 422);
                }
            }
        }
        
        return $next($request);
    }
}
