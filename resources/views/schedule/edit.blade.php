<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
          {{ __('Ubah Jadwal') }}
      </h2>
  </x-slot>
  <div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
      <div class="card bg-white dark:bg-gray-800 shadow-xl">
        <div class="card-body">
          <form action="{{ route('schedule.update', $schedule->id) }}" method="post">
            @csrf
            @method("PUT")
            @if (auth()->user()->role == 'admin')
              <div class="mb-4">
                <x-input-label for="app" :value="__('App')" />
                <select id="app" name="app" class="select select-accent w-full mt-2 bg-white dark:bg-gray-800">
                  <option value="prodiakon" @if (old('app', $schedule->app) == "prodiakon") {{"selected"}} @endif>prodiakon</option>
                  <option value="misdinar" @if (old('app', $schedule->app) == "misdinar") {{"selected"}} @endif>misdinar</option>
                  <option value="pasdior" @if (old('app', $schedule->app) == "pasdior") {{"selected"}} @endif>pasdior</option>
                  <option value="tatib" @if (old('app', $schedule->app) == "tatib") {{"selected"}} @endif>tatib</option>
                </select>
              </div>
            @endif
            <x-datepicker :name="__('tgl_jadwal')" :value="old('tgl_jadwal', $schedule->tgl_jadwal)" :placeholder="__('Pilih Tanggal')">
              <x-input-label for="datepickerId" :value="__('Tanggal Tugas')" />
            </x-datepicker>
            <div class="mt-4">
              <x-input-label for="jam_jadwal" :value="__('Waktu Tugas')" />
              <select id="jam_jadwal" name="jam_jadwal" class="select select-accent w-full mt-2 bg-white dark:bg-gray-800">
                @for ($i = 0; $i < 24; $i++)
                  <option value="{{ substr('0'. $i, -2) . ':00' }}" 
                    @if ( old('jam_jadwal', $schedule->jam_jadwal) == (substr('0'. $i, -2) . ':00')) {{"selected"}} @endif
                  >
                    {{ substr('0'. $i, -2) . ':00' }}
                  </option>
                @endfor
              </select>
            </div>
            <div class="mt-4">
              <x-input-label for="lokasi" :value="__('Lokasi')" />
              <select id="lokasi" name="lokasi" class="select select-accent w-full mt-2 bg-white dark:bg-gray-800">
                <option value="Gereja Paskalis" 
                  @if (old('lokasi', $schedule->lokasi) == "Gereja Paskalis") {{"selected"}} @endif
                >Gereja Paskalis</option>
                <option value="Kapel Lourdes" 
                  @if (old('lokasi', $schedule->lokasi) == "Kapel Lourdes") {{"selected"}} @endif
                >Kapel Lourdes</option>
              </select>
            </div>
            <div class="mt-4">
              <x-input-label for="nama_tugas" :value="__('Nama Tugas / Misa')" />
              <x-text-input id="nama_tugas" name="nama_tugas" type="text" class="input input-bordered input-accent mt-2 block w-full" :value="old('nama_tugas', $schedule->nama_tugas)" required autofocus />
            </div>
            <div class="mt-4">
              <x-input-label for="warna" :value="__('Warna Liturgi')" />
              <select id="warna" name="warna" class="select select-accent w-full mt-2 bg-white dark:bg-gray-800">
                <option value="putih" @if ( old('warna', $schedule->warna) == "white") {{"selected"}} @endif>Putih</option>
                <option value="hijau" @if ( old('warna', $schedule->warna) == "green") {{"selected"}} @endif>Hijau</option>
                <option value="merah" @if ( old('warna', $schedule->warna) == "red") {{"selected"}} @endif>Merah</option>
                <option value="ungu" @if ( old('warna', $schedule->warna) == "purple") {{"selected"}} @endif>Ungu</option>
                <option value="pink" @if ( old('warna', $schedule->warna) == "pink") {{"selected"}} @endif>Merah Muda</option>
              </select>
            </div>
            <div class="mt-4">
              <x-input-label for="jml_petugas" :value="__('Jumlah Petugas')" />
              <x-text-input id="jml_petugas" name="jml_petugas" type="text" class="input input-bordered input-accent mt-2 block w-full" :value="old('jml_petugas', $schedule->jml_petugas)" required autofocus />
            </div>
            <div class="mt-4">
              <x-input-label for="petugas" :value="__('Petugas')" />
              <select x-cloak id="nama" class="select w-full">
                @foreach ($nama as $n)
                  <option value="{{ $n->id }}" @if (in_array($n->id, $schedule->petugas)) {{"selected"}} @endif>{{ $n->name }}</option>
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