@extends('layouts.app')

@section('meta_tags')
<title>{{ $page->meta_title ?? $page->title }} - {{ config('app.name', 'Komunitas') }}</title>
<meta name="description" content="{{ $page->meta_description ?? 'Situs resmi komunitas kami dengan berbagai program dan kegiatan bermanfaat.' }}">
<meta property="og:title" content="{{ $page->meta_title ?? $page->title }}">
<meta property="og:description" content="{{ $page->meta_description ?? 'Situs resmi komunitas kami dengan berbagai program dan kegiatan bermanfaat.' }}">
<meta property="og:image" content="{{ $page->meta_image ? asset('storage/' . $page->meta_image) : asset('images/default-og-image.jpg') }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 border-b pb-4">{{ $page->title }}</h1>

        <div class="space-y-6">
            @if(is_array($page->content_blocks))
                @foreach($page->content_blocks as $block)
                    @switch($block['type'])
                        @case('judul')
                            <h2 class="text-2xl font-bold text-indigo-700 mt-8 mb-4">{{ $block['content'] }}</h2>
                            @break
                        
                        @case('teks')
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $block['content'] }}</p>
                            @break

                        @case('gambar')
                            <div class="my-6">
                                <img src="{{ asset('storage/' . $block['content']) }}" alt="Gambar" class="rounded-lg shadow-md max-w-full h-auto w-full object-cover">
                            </div>
                            @break

                        @case('file')
                            <div class="my-6">
                                <a href="{{ asset('storage/' . $block['content']) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh Dokumen
                                </a>
                            </div>
                            @break

                        @case('grup_teks_gambar')
                            <div class="my-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                                <div class="text-gray-700 leading-relaxed text-lg">
                                    {{ $block['content']['teks'] }}
                                </div>
                                <div>
                                    <img src="{{ asset('storage/' . $block['content']['gambar']) }}" alt="Gambar Grup" class="rounded-lg shadow-md w-full h-auto object-cover">
                                </div>
                            </div>
                            @break

                        @case('video_youtube')
                            <div class="my-6">
                                <iframe src="https://www.youtube.com/embed/{{ $block['content'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full rounded-lg shadow-md aspect-video" style="min-height: 400px;"></iframe>
                            </div>
                            @break

                        @case('iframe')
                            <div class="my-6 w-full overflow-x-auto rounded-lg shadow-md border border-gray-200 bg-gray-50 p-2">
                                {!! $block['content'] !!}
                            </div>
                            @break

                        @case('video')
                            <div class="my-6">
                                <video controls class="w-full rounded-lg shadow-md bg-black">
                                    <source src="{{ asset('storage/' . $block['content']) }}" type="video/mp4">
                                    Browser Anda tidak mendukung pemutaran video.
                                </video>
                            </div>
                            @break

                        @case('slider')
                            @if(is_array($block['content']))
                            <div class="my-6">
                                <div class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 scroll-smooth">
                                    @foreach($block['content'] as $imagePath)
                                    <div class="shrink-0 w-full md:w-2/3 snap-center">
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Slider Image" class="w-full h-auto rounded-lg shadow-md object-cover">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @break

                        @case('grup_teks')
                            <div class="my-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="text-gray-700 leading-relaxed text-lg">
                                    {{ $block['content']['kolom_1'] ?? '' }}
                                </div>
                                <div class="text-gray-700 leading-relaxed text-lg">
                                    {{ $block['content']['kolom_2'] ?? '' }}
                                </div>
                            </div>
                            @break

                        @case('grup_gambar')
                            @if(is_array($block['content']))
                            <div class="my-8">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($block['content'] as $imagePath)
                                    <div class="aspect-square w-full">
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Galeri Grup" class="w-full h-full rounded-lg shadow-sm object-cover hover:opacity-90 transition-opacity">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @break

                        @case('tabel')
                            @php
                                $rows = explode("\n", trim($block['content']));
                                $headerRow = array_shift($rows);
                                $headers = explode(',', $headerRow);
                            @endphp
                            <div class="my-6 w-full overflow-x-auto rounded-lg shadow-sm border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            @foreach($headers as $header)
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ trim($header) }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($rows as $row)
                                            @if(trim($row) !== '')
                                                @php $columns = explode(',', $row); @endphp
                                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                    @foreach($columns as $colIndex => $column)
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm {{ $colIndex === 0 ? 'font-medium text-gray-900' : 'text-gray-500' }}">
                                                            {{ trim($column) }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @break

                        @case('tab')
                            @if(is_array($block['content']))
                            <div class="my-8" x-data="{ activeTab: 0 }">
                                <!-- Tab Headers -->
                                <div class="flex flex-wrap border-b border-gray-200">
                                    <template x-for="(tab, index) in {{ json_encode($block['content']) }}" :key="index">
                                        <button 
                                            @click="activeTab = index"
                                            :class="{'border-indigo-500 text-indigo-600': activeTab === index, 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== index}"
                                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none"
                                            x-text="tab.judul_tab">
                                        </button>
                                    </template>
                                </div>
                                <!-- Tab Contents -->
                                <div class="p-6 bg-white border border-t-0 border-gray-200 rounded-b-lg">
                                    <template x-for="(tab, index) in {{ json_encode($block['content']) }}" :key="index">
                                        <div x-show="activeTab === index" x-transition.opacity>
                                            <p class="text-gray-700 leading-relaxed text-lg whitespace-pre-line" x-text="tab.isi_tab"></p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            @endif
                            @break

                        @case('widget')
                            @if($block['content'] === 'widget_anggota')
                                <div class="my-8">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                                        @forelse($members ?? [] as $member)
                                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden text-center p-6 hover:shadow-md transition">
                                                <div class="w-24 h-24 rounded-full bg-gray-200 mx-auto mb-4 overflow-hidden border-4 border-white shadow-sm">
                                                    @if($member->photo)
                                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <svg class="w-full h-full text-gray-400 p-2" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                                    @endif
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900">{{ $member->name }}</h3>
                                                <p class="text-blue-600 text-sm font-semibold mb-3">{{ $member->position }}</p>
                                                @if($member->bio)
                                                    <p class="text-gray-600 text-xs line-clamp-3">{{ $member->bio }}</p>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="col-span-full text-center py-16 text-gray-500 bg-gray-50 rounded-lg border border-dashed">
                                                Data struktur anggota belum ditambahkan.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @elseif($block['content'] === 'widget_program')
                                <div class="my-8 space-y-8">
                                    @forelse($workPrograms ?? [] as $program)
                                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col md:flex-row gap-6 hover:shadow-md transition">
                                            @if($program->image)
                                                <div class="md:w-1/3 flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-48 object-cover rounded-md">
                                                </div>
                                            @endif
                                            
                                            <div class="{{ $program->image ? 'md:w-2/3' : 'w-full' }} flex flex-col justify-center">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h2 class="text-xl font-bold text-gray-900">{{ $program->title }}</h2>
                                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                                        {{ $program->status === 'completed' ? 'bg-green-100 text-green-800' : ($program->status === 'ongoing' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($program->status) }}
                                                    </span>
                                                </div>
                                                
                                                <p class="text-sm text-gray-500 mb-4">
                                                    Jadwal: {{ $program->start_date ? $program->start_date->format('d M Y') : 'TBA' }} 
                                                    s/d {{ $program->end_date ? $program->end_date->format('d M Y') : 'TBA' }}
                                                </p>
                                                <p class="text-gray-600">{{ $program->description }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-16 text-gray-500 bg-gray-50 rounded-lg border border-dashed">
                                            Belum ada data program kerja.
                                        </div>
                                    @endforelse
                                </div>
                            @elseif($block['content'] === 'widget_berita')
                                <div class="my-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    @forelse($news ?? [] as $item)
                                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition flex flex-col">
                                            @if($item->thumbnail)
                                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                                            @else
                                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                                    <span class="sr-only">Tanpa Gambar</span>
                                                </div>
                                            @endif
                                            
                                            <div class="p-6 flex-grow flex flex-col">
                                                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                                                    {{ $item->title }}
                                                </h3>
                                                <div class="text-gray-600 text-sm mb-4 line-clamp-3">
                                                    {!! Str::limit(strip_tags($item->content), 100) !!}
                                                </div>
                                                <a href="{{ route('news.detail', $item->slug) }}" class="inline-block px-4 py-2 bg-blue-50 text-blue-700 rounded hover:bg-blue-600 hover:text-white transition-colors text-sm font-semibold text-center mt-auto border border-blue-100">
                                                    Baca Penuh
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-full text-center py-16 text-gray-500 bg-gray-50 rounded-lg border border-dashed">
                                            Belum ada data berita.
                                        </div>
                                    @endforelse
                                </div>
                            @endif
                            @break
                    @endswitch
                @endforeach
            @else
                <p class="text-gray-500 italic">Halaman ini belum memiliki konten.</p>
            @endif
        </div>
    </div>
</div>
@endsection
