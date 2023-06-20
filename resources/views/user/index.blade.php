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
      <table class="table w-full" style="margin-bottom: 20px">
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
                  <a href="{{ route('user.reset', $u->id) }}" class="btn btn-square btn-sm" title="Reset Password" onclick="return confirm('Apakah Anda yakin akan reset password user {{$u->username}}?')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                      <path fill-rule="evenodd" d="M12 5.25c1.213 0 2.415.046 3.605.135a3.256 3.256 0 013.01 3.01c.044.583.077 1.17.1 1.759L17.03 8.47a.75.75 0 10-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 00-1.06-1.06l-1.752 1.751c-.023-.65-.06-1.296-.108-1.939a4.756 4.756 0 00-4.392-4.392 49.422 49.422 0 00-7.436 0A4.756 4.756 0 003.89 8.282c-.017.224-.033.447-.046.672a.75.75 0 101.497.092c.013-.217.028-.434.044-.651a3.256 3.256 0 013.01-3.01c1.19-.09 2.392-.135 3.605-.135zm-6.97 6.22a.75.75 0 00-1.06 0l-3 3a.75.75 0 101.06 1.06l1.752-1.751c.023.65.06 1.296.108 1.939a4.756 4.756 0 004.392 4.392 49.413 49.413 0 007.436 0 4.756 4.756 0 004.392-4.392c.017-.223.032-.447.046-.672a.75.75 0 00-1.497-.092c-.013.217-.028.434-.044.651a3.256 3.256 0 01-3.01 3.01 47.953 47.953 0 01-7.21 0 3.256 3.256 0 01-3.01-3.01 47.759 47.759 0 01-.1-1.759L6.97 15.53a.75.75 0 001.06-1.06l-3-3z" clip-rule="evenodd" />
                    </svg>                                        
                  </a>
                @endcan        
                @can('update', $u)
                  <a href="{{ route('user.edit', $u->id) }}" class="btn btn-square btn-sm" title="Ubah Profil User">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>                    
                  </a>
                @endcan        
                @can('delete', $u)
                  <form action="{{route('user.destroy', $u->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-square btn-sm" type="submit" title="Non aktifkan user" onclick="return confirm('Apakah Anda yakin akan menonaktifkan user {{$u->username}}?')">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                  </form>
                @endcan
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{ $users->links() }}
    </div>
  </div>
</x-app-layout>