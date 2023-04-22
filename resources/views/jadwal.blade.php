<x-app-layout>
  <x-slot name="header">
      <h2 class="font-black text-xl leading-tight">
          {{ __('Jadwal') }}
      </h2>
  </x-slot>

  <div class="py-12 px-6">
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

    <h2 class="font-black text-xl max-w-7xl mx-auto">Jadwal Terbuka</h2>
    <div class="grid gap-4 max-w-7xl mx-auto md:grid-cols-3 sm:grid-cols-1">
      @if (count($jadwal_buka) == 0)
        <p class="text-xl">Tidak ada jadwal yang terbuka.</p>
      @else
        @foreach ($jadwal_buka as $j)
          <div class="grid card bg-white dark:bg-base-300 rounded-box place-items-center mt-5">
            <div class="card w-full text-primary-content text-base-300 dark:text-white">
              <div class="card-body">
                <h1 class="card-title">{{ Carbon\Carbon::parse($j->tgl_jadwal)->isoFormat('dddd, D-MMM-YYYY') }} {{ $j->jam_jadwal }}</h1>
                <p class="text-sm">Lokasi: {{$j->lokasi}}</p>
                <div class="divider"></div>
                <a href="{{ route('schedule.assign', $j->id) }}" class="btn btn-accent" onclick="return confirm('Apakah Anda yakin akan mengambil jadwal?')">Saya ambil jadwalnya</a>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>
    <div class="divider"></div>
    <h2 class="font-black text-xl max-w-7xl mx-auto">Jadwal Saya</h2>
    <div class="grid gap-4 max-w-7xl mx-auto md:grid-cols-3 sm:grid-cols-1">
      @if (count($jadwal) == 0)
        <p class="text-xl">Anda belum mendapatkan tugas.</p>
      @else
        @foreach ($jadwal as $j)
          <div class="grid card bg-transparent dark:bg-base-300 rounded-box place-items-center mt-5">
            <div class="card w-full warna-{{$j->warna}} text-primary-content">
              <div class="card-body">
                <div class="card-actions justify-end">
                  <span class="font-black text-xl">@if (!$j->published) {{"DRAFT"}} @endif</span>
                  @can('update', $j)
                    <a href="{{ route('schedule.edit', $j->id) }}" class="btn btn-square btn-sm" title="Ubah Jadwal">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                      </svg>                    
                    </a>
                  @endcan
                  @can('delete', $j)
                    <form action="{{route('schedule.destroy', $j->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-square btn-sm" type="submit" title="Hapus Jadwal" onclick="return confirm('Apakah Anda yakin akan menghapus jadwal?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                      </button>
                    </form>
                  @endcan
                </div>
                <h1 class="card-title">{{ Carbon\Carbon::parse($j->tgl_jadwal)->isoFormat('dddd, D-MMM-YYYY') }} {{ $j->jam_jadwal }}</h1>
                <h4 class="font-black">{{$j->nama_tugas}}</h4>
                <p class="text-sm">Lokasi: {{$j->lokasi}}</p>
                <p class="text-sm">Warna Liturgi: {{ucfirst($j->warna)}}</p>
                <p>&nbsp;</p>
                <p><strong>Petugas:</strong></p>
                <ol>
                  @foreach ($j->petugas as $petugas)
                    <li>{{$petugas->name}}</li>
                  @endforeach
                </ol>
                <p class="text-xs mt-5"><span class="font-black">Status: </span> @if ($j->status == 'open') {{"Petugas masih kurang ".($j->jml_petugas - count($j->petugas))." orang."}} @else {{"Petugas lengkap."}} @endif {{ '('.count($j->petugas).'/'.$j->jml_petugas.')' }}</p>
                <div class="divider"></div>
                <a href="{{ route('schedule.release', $j->id) }}" class="btn btn-error" onclick="return confirm('Apakah Anda yakin akan melepas jadwal?')">Saya lepas jadwal ini</a>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    </div>
    @can('buat_jadwal')
      <div class="divider"></div>
      <h2 class="font-black text-xl max-w-7xl mx-auto">Jadwal Lengkap</h2>
      <div class="grid gap-4 max-w-7xl mx-auto md:grid-cols-3 sm:grid-cols-1">
        @foreach ($semua_jadwal as $j)
          <div class="grid card bg-transparent dark:bg-base-300 rounded-box place-items-center mt-5">
            <div class="card w-full warna-{{$j->warna}} text-primary-content">
              <div class="card-body">
                <div class="card-actions justify-end">
                  <span class="font-black text-xl">@if (!$j->published) {{"DRAFT"}} @endif</span>
                  @if (!$j->published)
                    <a href="{{ route('schedule.publish', $j->id) }}" class="btn btn-square btn-sm" title="Publish Jadwal">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>                                          
                    </a>
                  @endif
                  @can('update', $j)
                    <a href="{{ route('schedule.edit', $j->id) }}" class="btn btn-square btn-sm" title="Ubah Jadwal">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                      </svg>                    
                    </a>
                  @endcan
                  @can('delete', $j)
                    <form action="{{route('schedule.destroy', $j->id)}}" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-square btn-sm" type="submit" title="Hapus Jadwal" onclick="return confirm('Apakah Anda yakin akan menghapus jadwal?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                      </button>
                    </form>
                  @endcan
                </div>
                <h1 class="card-title">{{ Carbon\Carbon::parse($j->tgl_jadwal)->isoFormat('dddd, D-MMM-YYYY') }} {{ $j->jam_jadwal }}</h1>
                <h4 class="font-black">{{$j->nama_tugas}}</h4>
                <p class="text-sm">Lokasi: {{$j->lokasi}}</p>
                <p class="text-sm">Warna Liturgi: {{ucfirst($j->warna)}}</p>
                <p>&nbsp;</p>
                <p><strong>Petugas:</strong></p>
                <ol>
                  @foreach ($j->petugas as $petugas)
                    <li>{{$petugas->name}}</li>
                  @endforeach
                </ol>
                <p class="text-xs mt-5"><span class="font-black">Status: </span> @if ($j->status == 'open') {{"Petugas masih kurang ".($j->jml_petugas - count($j->petugas))." orang."}} @else {{"Petugas lengkap."}} @endif {{ '('.count($j->petugas).'/'.$j->jml_petugas.')' }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endcan
  </div>
</x-app-layout>
