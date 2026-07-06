@extends('layouts.app')

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
                    @endswitch
                @endforeach
            @else
                <p class="text-gray-500 italic">Halaman ini belum memiliki konten.</p>
            @endif
        </div>
    </div>
</div>
@endsection
