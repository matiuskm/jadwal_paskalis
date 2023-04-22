<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
          {{ __('Jadwal Baru') }}
      </h2>
  </x-slot>
  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      @if (session()->has('success'))
      <div class="alert alert-success shadow-lg">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
          <span>{{ session('success') }}</span>
        </div>
      </div>
      @endif
      @if (session()->has('error'))
      <div class="alert alert-error shadow-lg">
        <div>
          <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
          <span>{{ session('error') }}</span>
        </div>
      </div>
      @endif
      <div class="card bg-white dark:bg-gray-800 shadow-xl">
        <div class="card-body">
          <form action="{{route('schedule.store')}}" method="post">
            @csrf
            @if (auth()->user()->role == 'admin')
              <div class="mb-4">
                <x-input-label for="app" :value="__('App')" />
                <select id="app" name="app" class="select select-accent w-full mt-2 bg-white dark:bg-gray-800">
                  <option value="prodiakon">prodiakon</option>
                  <option value="misdinar">misdinar</option>
                  <option value="pasdior">pasdior</option>
                  <option value="tatib">tatib</option>
                </select>
              </div>
            @endif
            <x-datepicker :name="__('tgl_jadwal')" :value="old('tgl_jadwal')" :placeholder="__('Pilih Tanggal')">
              <x-input-label for="datepickerId" :value="__('Tanggal Tugas')" />
            </x-datepicker>
            <div class="mt-4">
              <x-input-label for="jam_jadwal" :value="__('Waktu Tugas')" />
              <select id="jam_jadwal" name="jam_jadwal" class="select select-accent w-full mt-2 bg-white dark:bg-gray-800">
                @for ($i = 0; $i < 24; $i++)
                  <option value="{{ substr('0'. $i, -2) . ':00' }}">{{ substr('0'. $i, -2) . ':00' }}</option>
                  {{-- <option value="{{ substr('0'. $i, -2) . ':30' }}">{{ substr('0'. $i, -2) . ':30' }}</option> --}}
                @endfor
              </select>
            </div>
            <div class="mt-4">
              <x-input-label for="lokasi" :value="__('Lokasi')" />
              <select id="lokasi" name="lokasi" class="select select-accent w-full mt-2 bg-white dark:bg-gray-800">
                <option value="Gereja Paskalis">Gereja Paskalis</option>
                <option value="Kapel Lourdes">Kapel Lourdes</option>
              </select>
            </div>
            <div class="mt-4">
              <x-input-label for="nama_tugas" :value="__('Nama Tugas / Misa')" />
              <x-text-input id="nama_tugas" name="nama_tugas" type="text" class="input input-bordered input-accent mt-2 block w-full" :value="old('nama_tugas')" required autofocus />
            </div>
            <div class="mt-4">
              <x-input-label for="warna" :value="__('Warna Liturgi')" />
              <select id="warna" name="warna" class="select select-accent w-full mt-2 bg-white dark:bg-gray-800">
                <option value="putih">Putih</option>
                <option value="hijau">Hijau</option>
                <option value="merah">Merah</option>
                <option value="ungu">Ungu</option>
                <option value="pink">Merah Muda</option>
              </select>
            </div>
            <div class="mt-4">
              <x-input-label for="jml_petugas" :value="__('Jumlah Petugas')" />
              <x-text-input id="jml_petugas" name="jml_petugas" type="text" class="input input-bordered input-accent mt-2 block w-full" :value="old('jml_petugas')" required autofocus />
            </div>
            <div class="mt-4">
              <x-input-label for="petugas" :value="__('Petugas')" />
              <select x-cloak id="nama" class="select w-full">
                @foreach ($nama as $n)
                  <option value="{{ $n->id }}">{{ $n->name }}</option>
                @endforeach
              </select>
              <x-multiple-select :name="__('nama')" :placeholder="__('Pilih Petugas')" />              
            </div>
            <div class="mt-4">
              <input type="submit" name="draft" value="Simpan Draft" class="btn btn-ghost w-full">
              <input type="submit" name="publish" value="Publish" class="btn btn-accent w-full">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</x-app-layout>