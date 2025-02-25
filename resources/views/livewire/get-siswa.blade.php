<div>
    <div x-data="{ open: false }" class="relative w-full max-w-md mx-auto form-group">
        <label for="">Nama Siswa</label>
        <input type="text" wire:model="search" wire:keyup="searchSiswa" @focus="open = true" @click.away="open = false"
            @keydown.escape.window="open = false" placeholder="Ketik nama siswa (min. 3 karakter)..."
            class="form-control p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

        <input type="text" hidden wire:model="nisn" name="nisn">
        <div x-show="open"
            class="absolute z-10 w-full bg-white border rounded-lg shadow-lg mt-1 max-h-60 overflow-auto">
            @if (strlen($search) >= 3)
                @if (count($results) > 0)
                    @foreach ($results as $siswa)
                        <div wire:click="selectSiswa({{ $siswa->nisn }})" @click="open = false"
                            class="p-3 hover:bg-blue-100 cursor-pointer transition">
                            {{ '[' . $siswa->kelas->namakelas . ' ' . $siswa->jurusan->jurusan . '] - ' . $siswa->namasiswa }}
                        </div>
                    @endforeach
                @else
                    <div class="p-3 text-gray-500">Siswa tidak ditemukan.</div>
                @endif
            @endif
        </div>
    </div>
</div>
