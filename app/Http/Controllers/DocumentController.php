<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // 1. TAMPILKAN DASHBOARD
    public function index()
    {
        $userId = auth()->id();
        // Jika admin login, tampilkan SEMUA dokumen. Jika dosen, tampilkan PUNYA DIA saja.
        if(Auth::user()->role === 'admin'){
            $documents = Document::with('category')->latest()->get();
        } else {
            $documents = Document::where('user_id', $userId)->with('category')->latest()->get();
        }

        return view('dashboard', compact('documents'));
    }

    // 2. FORM UPLOAD
    public function create()
    {
        $categories = DocumentCategory::all();
        return view('create', compact('categories'));
    }

    // 3. PROSES SIMPAN
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,jpg,png|max:5048',
        ]);

        $filePath = $request->file('file')->store('arsip-jafung', 'public');
        $statusAwal = (Auth::user()->role === 'admin') ? 'verified' : 'pending';

        Document::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'semester' => $request->semester,
            'file_path' => $filePath,
            'status' => $statusAwal, 
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diunggah!');
    }

    // 4. FORM EDIT (BARU)
    public function edit($id)
    {
        $document = Document::findOrFail($id);
        
        // Cek kepemilikan (biar orang lain tidak bisa edit punya kita, kecuali admin)
        if(Auth::user()->role !== 'admin' && $document->user_id !== Auth::id()){
            abort(403);
        }

        $categories = DocumentCategory::all();
        // Kita simpan file view edit di folder profile dengan nama edit_archive.blade.php
        return view('profile.edit_archive', compact('document', 'categories'));
    }

    // 5. PROSES UPDATE (BARU)
    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'file' => 'nullable|mimes:pdf,doc,docx,jpg,png|max:5048', // File boleh kosong jika tidak diganti
        ]);

        // Logic Update File
        if ($request->hasFile('file')) {
            // 1. Hapus file lama
            if($document->file_path){
                Storage::disk('public')->delete($document->file_path);
            }
            // 2. Upload file baru
            $filePath = $request->file('file')->store('arsip-jafung', 'public');
            $document->file_path = $filePath;
        }

        // Logic Update Data
        $document->title = $request->title;
        $document->category_id = $request->category_id;
        $document->semester = $request->semester;
        
        // Jika diedit, status balik jadi pending lagi (opsional, tergantung kebijakan)
        // $document->status = 'pending'; 
        
        $document->save();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    // 6. PROSES HAPUS (BARU)
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Cek kepemilikan
        if(Auth::user()->role !== 'admin' && $document->user_id !== Auth::id()){
            abort(403);
        }

        // 1. Hapus File Fisik di folder storage
        if($document->file_path){
            Storage::disk('public')->delete($document->file_path);
        }

        // 2. Hapus Data di Database
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus!');
    }

    // 7. VERIFIKASI
    public function verify($id)
    {
        $document = Document::findOrFail($id);
        $document->update(['status' => 'verified']);
        return redirect()->back()->with('success', 'Dokumen berhasil disetujui!');
    }
}