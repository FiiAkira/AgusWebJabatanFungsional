<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arsip Dokumen Sistem Jabatan Fungsional Dosen') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Arsip Dokumen</h3>
                        <a href="{{ route('documents.create') }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded text-sm shadow-sm hover:bg-gray-50">+ Upload Dokumen Baru</a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-3 text-sm text-green-800 bg-green-100 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm">No</th>
                                    <th class="px-4 py-2 text-left text-sm">Judul Dokumen</th>
                                    <th class="px-4 py-2 text-left text-sm">Kategori</th>
                                    <th class="px-4 py-2 text-left text-sm">Semester</th>
                                    <th class="px-4 py-2 text-left text-sm">Status</th>
                                    <th class="px-4 py-2 text-left text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($documents as $doc)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $doc->title }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $doc->category->name ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $doc->semester }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($doc->status == 'verified')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                                        @elseif($doc->status == 'rejected')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="inline-flex items-center px-2 py-1 bg-blue-600 text-white rounded text-sm">Lihat File</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">Belum ada dokumen yang diunggah.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>