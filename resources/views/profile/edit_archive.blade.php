<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Dokumen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-lg bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-blue-500 p-4">
            <h2 class="text-white text-lg font-bold">Edit Arsip Dokumen</h2>
        </div>

        <div class="p-6">
            <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Judul Dokumen</label>
                    <input type="text" name="title" value="{{ $document->title }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                    <div class="relative">
                        <select name="category_id" class="w-full px-3 py-2 border rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-yellow-500 bg-white" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $document->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Semester (Opsional)</label>
                    <input type="text" name="semester" value="{{ $document->semester }}" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ganti File (Biarkan kosong jika tidak ingin mengganti)</label>
                    <div class="flex items-center space-x-2">
                        <input type="file" name="file" class="block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-yellow-50 file:text-yellow-700
                          hover:file:bg-yellow-100 cursor-pointer border rounded-lg
                        ">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">File saat ini: <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-500 underline">Lihat File</a></p>
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('documents.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">Update Perubahan</button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>