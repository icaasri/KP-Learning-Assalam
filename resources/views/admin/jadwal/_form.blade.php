@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-input-label for="kelas_id" value="Kelas" />
        <select name="kelas_id" id="kelas_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
            <option>Pilih Kelas</option>
            @foreach ($kelas as $k)
                <option value="{{ $k->id }}" @selected(old('kelas_id', $jadwal->kelas_id ?? '') == $k->id)>
                    {{ $k->tingkat }} {{ $k->jurusan->singkatan }} {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="guru_id" value="Guru Pengajar" />
        <select name="guru_id" id="guru_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
            <option>Pilih Guru</option>
            @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}" @selected(old('guru_id', $jadwal->guru_id ?? '') == $guru->id)>{{ $guru->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label for="mata_pelajaran" value="Mata Pelajaran" />
        <x-text-input id="mata_pelajaran" class="block mt-1 w-full" type="text" name="mata_pelajaran" :value="old('mata_pelajaran', $jadwal->mata_pelajaran ?? '')" required />
    </div>
    <div>
        <x-input-label for="ruangan" value="Ruangan" />
        <x-text-input id="ruangan" class="block mt-1 w-full" type="text" name="ruangan" :value="old('ruangan', $jadwal->ruangan ?? '')" required />
    </div>
    <div>
        <x-input-label for="hari" value="Hari" />
        <select name="hari" id="hari" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
            @foreach ($hari as $h)
                <option value="{{ $h }}" @selected(old('hari', $jadwal->hari ?? '') == $h)>{{ $h }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <x-input-label for="waktu_mulai" value="Waktu Mulai" />
            <x-text-input id="waktu_mulai" class="block mt-1 w-full" type="time" name="waktu_mulai" :value="old('waktu_mulai', $jadwal->waktu_mulai ?? '')" required />
        </div>
        <div>
            <x-input-label for="waktu_selesai" value="Waktu Selesai" />
            <x-text-input id="waktu_selesai" class="block mt-1 w-full" type="time" name="waktu_selesai" :value="old('waktu_selesai', $jadwal->waktu_selesai ?? '')" required />
        </div>
    </div>
</div>
<div class="flex justify-end mt-6">
    <x-primary-button>
        Simpan Jadwal
    </x-primary-button>
</div>
