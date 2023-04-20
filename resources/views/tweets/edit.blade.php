<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Tweet') }}
      </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="card bg-white shadow-xl">
        <div class="card-body">
          <form action="{{route('tweet.update', $tweet->id)}}" method="post">
            @csrf
            @method('put')
            <textarea name="content" id="" cols="30" rows="3" class="textarea textarea-bordered w-full" placeholder="Apa yang kamu pikirin?">{{$tweet->content}}</textarea>
            <input type="submit" value="Edit" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>