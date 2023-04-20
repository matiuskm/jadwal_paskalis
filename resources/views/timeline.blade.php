<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('create')
            <div class="card bg-white dark:bg-gray-800 shadow-xl">
                <div class="card-body">
                    <form action="{{route('tweets.store')}}" method="post">
                        @csrf
                        <textarea name="content" id="" cols="30" rows="3" class="textarea textarea-bordered bg-white dark:bg-gray-800 w-full" placeholder="Apa yang kamu pikirin?"></textarea>
                        <input type="submit" value="Tweet" class="btn btn-primary">
                    </form>
                </div>
            </div>
            @endcan
            @foreach ($tweets as $tweet)
                <div class="card my-4 bg-white dark:bg-gray-800 shadow-xl">
                    <div class="card-body my-2">
                        <h2 class="text-xl font-bold">{{ $tweet->user->name }}</h2>
                        <p style="white-space: pre-line">{{ $tweet->content }}</p>
                        <div class="text-end">
                            @can('update', $tweet)                            
                                <a href="{{route('tweet.edit', $tweet->id)}}" class="link link-hover text-blue-400"> Edit </a>
                            @endcan
                            @can('delete', $tweet)
                                <form action="{{route('tweet.destroy', $tweet->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm"> Hapus </button>
                                </form>
                            @endcan
                            <span class="text-xs">{{ $tweet->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
