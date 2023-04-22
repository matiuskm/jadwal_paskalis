<x-app-layout>
  <x-slot name="header">
      <h2 class="font-black text-xl leading-tight">
          {{ __('Daftar User') }}
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

    <div class="md:max-w-2xl mx-auto sm:px-6 lg:px-8 overflow-x-auto">
      <table class="table md:w-full">
        <thead>
          <tr>
            <th></th>
            <th class="sm:text-sm">Username</th>
            <th class="sm:text-sm">Nama</th>
            <th class="sm:text-sm">Admin</th>
            <th class="sm:text-sm">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $u)              
            <tr>
              <td></td>
              <td class="sm:text-sm">{{$u->username}}</td>
              <td class="sm:text-sm">{{$u->name}} @if ($u->status) {{"(Aktif)"}} @else {{"(Tidak aktif)"}} @endif</td>
              <td class="sm:text-sm">@if($u->role == 'moderator') {{"Y"}} @else {{"T"}} @endif</td>
              <td class="sm:text-sm">
                @can('update', $u)
                  <a href="{{ route('user.edit', $u->id) }}" class="btn btn-square btn-sm" title="Ubah Jadwal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>                    
                  </a>
                @endcan               
                @can('delete', $u)
                  <form action="{{route('user.destroy', $u->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-square btn-sm" type="submit" title="Non aktifkan user" onclick="return confirm('Apakah Anda yakin akan menonaktifkan user?')">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                  </form>
                @endcan
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</x-app-layout>