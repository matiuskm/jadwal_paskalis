<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('User Profile') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
          <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
              <div class="max-w-xl">
                <section>
                  <header>
                      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                          {{ __('Informasi User') }}
                      </h2>
                  </header>
              
                  <form method="post" action="{{ route('user.update', $user->id) }}" class="mt-6 space-y-6">
                      @csrf
                      @method('patch')
              
                      <div>
                          <x-input-label for="username" :value="__('Username')" />
                          <x-text-input id="username" name="username" type="text" readonly class="mt-1 block w-full" :value="old('username', $user->username)" required autofocus autocomplete="username" />
                          <x-input-error class="mt-2" :messages="$errors->get('username')" />
                      </div>
              
                      <div>
                          <x-input-label for="name" :value="__('Nama')" />
                          <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                          <x-input-error class="mt-2" :messages="$errors->get('name')" />
                      </div>
              
                      <x-datepicker :name="__('dob')" :value="old('dob', $user->dob)" :placeholder="__('Pilih Tanggal')">
                          <x-input-label for="datepickerId" :value="__('Tanggal Lahir')" />
                      </x-datepicker>
                         
                      <div>
                          <x-input-label for="email" :value="__('Email')" />
                          <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
                          <x-input-error class="mt-2" :messages="$errors->get('email')" />
                      </div>

                      <div class="mt-4">
                        <x-input-label for="role" :value="__('Role')" />
            
                        <select id="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                        name="role" required autocomplete="new-password">
                            <option value="user" @if (old('role', $user->role) == 'user') {{"selected"}} @endif>User</option>
                            <option value="moderator" @if (old('role', $user->role) == 'moderator') {{"selected"}} @endif>Moderator</option>
                        </select>
            
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                      </div>
            
              
                      <div class="flex items-center gap-4">
                          <x-primary-button>{{ __('Save') }}</x-primary-button>
              
                          @if (session('status') === 'profile-updated')
                              <p
                                  x-data="{ show: true }"
                                  x-show="show"
                                  x-transition
                                  x-init="setTimeout(() => show = false, 2000)"
                                  class="text-sm text-gray-600 dark:text-gray-400"
                              >{{ __('Saved.') }}</p>
                          @endif
                      </div>
                  </form>
              </section>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
