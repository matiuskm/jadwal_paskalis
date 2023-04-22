<x-app-layout>
  <x-slot name="header">
      <h2 class="font-black text-xl leading-tight">
          {{ __('Daftar User') }}
      </h2>
  </x-slot>

  <div class="py-12 px-6">
    <div class="md:max-w-2xl mx-auto sm:px-6 lg:px-8 overflow-x-auto">
      <table class="table md:w-full">
        <thead>
          <tr>
            <th></th>
            <th class="sm:text-sm">Username</th>
            <th class="sm:text-sm">Aktivitas</th>
            <th class="sm:text-sm">Waktu</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($activities as $a)              
            <tr>
              <td></td>
              <td class="sm:text-sm">{{$a->user->username}}</td>
              <td class="sm:text-sm">{{$a->action}}</td>
              <td class="sm:text-sm">{{ Carbon\Carbon::parse($a->created_at)->isoFormat('dddd, D-MMM-YYYY H:m:s') }}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          {{ $activities->links() }}
        </tfoot>
      </table>
    </div>
  </div>
</x-app-layout>