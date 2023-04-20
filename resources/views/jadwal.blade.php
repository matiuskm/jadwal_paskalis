<x-app-layout>
  <x-slot name="header">
      <h2 class="font-black text-xl leading-tight">
          {{ __('Jadwal Saya') }}
      </h2>
  </x-slot>

  <div class="py-12 px-6">
      <div class="grid gap-4 md:grid-cols-3 sm:grid-cols-1">
        @foreach ($jadwal as $j)
          <div class="grid card bg-transparent dark:bg-base-300 rounded-box place-items-center mt-5">
            <div class="card w-full warna-{{$j->warna}} text-primary-content">
              <div class="card-body">
                <div class="card-actions justify-end">
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
                <p class="text-xs mt-5"><span class="font-black">Status: </span> @if ($j->status == 'open') {{"Petugas masih kurang ".($j->jml_petugas - count($j->petugas))." orang."}} @else {{"Petugas lengkap."}} @endif</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</x-app-layout>
