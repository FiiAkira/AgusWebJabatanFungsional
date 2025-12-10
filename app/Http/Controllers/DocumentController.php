<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // 1. Menampilkan Halaman Arsip
    public function index()
{
    $userId = auth()->id();
    $documents = Document::where('user_id', $userId)->with('category')->latest()->get();

    // DULU (Mungkin mengarah ke index):
    // return view('dosen.documents.index', compact('documents'));

    // SEKARANG (Arahkan ke dashboard):
    return view('dashboard', compact('documents'));
}

    // 2. Menampilkan Form Upload
    public function create()
    {
        $categories = DocumentCategory::all();
        // Sesuaikan dengan file view yang ada: resources/views/create.blade.php
        return view('create', compact('categories'));
    }

    // 3. Proses Simpan ke Database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,jpg,png|max:5048', // Max 5MB
        ]);

        // Simpan file ke folder: storage/app/public/arsip-jafung
        $filePath = $request->file('file')->store('arsip-jafung', 'public');

        Document::create([
            'user_id' => Auth::id(), // ID user yang login
            'category_id' => $request->category_id,
            'title' => $request->title,
            'semester' => $request->semester,
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diunggah!');
    }
}