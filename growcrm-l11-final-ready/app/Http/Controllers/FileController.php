<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display files by role:
     * - Admin: all files
     * - Manager: own files + employee files
     * - Employee: only own files
     */
    public function index()
    {
        $user = Auth::user();

        $query = UserFile::with('user')->orderByDesc('created_at');

        // Role-based filtering
        if ($user->role === 'admin') {
            // Admin sees everything
        } elseif ($user->role === 'manager') {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhereHas('user', function ($u) {
                      $u->where('role', 'employee');
                  });
            });
        } else {
            // Employee → only own files
            $query->where('user_id', $user->id);
        }

        $files = $query->paginate(20);

        return view('files.index', compact('files', 'user'));
    }


    /**
     * Upload file
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'file' => 'required|file|max:20480' // 20 MB
        ]);

        $uploaded = $request->file('file');

        // Store file in storage/app/public/user_files
        $path = $uploaded->store('user_files', 'public');

        UserFile::create([
            'user_id'       => $user->id,
            'original_name' => $uploaded->getClientOriginalName(),
            'path'          => $path,
            'size'          => $uploaded->getSize(),
            'mime_type'     => $uploaded->getClientMimeType(),
        ]);

        return redirect()->route('files.index')
            ->with('success', 'File uploaded successfully.');
    }


    /**
     * Download file — Only owner or admin
     */
    public function download(UserFile $file)
    {
        $user = Auth::user();

        if ($file->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'You are not allowed to download this file.');
        }

        if (!Storage::disk('public')->exists($file->path)) {
            return back()->with('error', 'File not found on server.');
        }

        return Storage::disk('public')
            ->download($file->path, $file->original_name);
    }


    /**
     * Delete file — Only owner or admin
     */
    public function destroy(UserFile $file)
    {
        $user = Auth::user();

        if ($file->user_id !== $user->id && $user->role !== 'admin') {
            abort(403, 'You are not allowed to delete this file.');
        }

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return redirect()->route('files.index')
            ->with('success', 'File deleted successfully.');
    }
}
