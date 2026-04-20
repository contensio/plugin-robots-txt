@extends('contensio::admin.layout')
@section('title', 'Robots.txt Editor')
@section('breadcrumb')
<a href="{{ route('contensio.settings') }}" class="text-gray-500 hover:text-gray-700">Settings</a>
<span class="mx-2 text-gray-300">/</span>
<span class="font-medium text-gray-700">Robots.txt</span>
@endsection
@section('content')

@if(session('success'))
<div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
    <svg class="w-4 h-4 shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
    <svg class="w-4 h-4 shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <div>{{ $errors->first() }}</div>
</div>
@endif

<form method="POST" action="{{ route('contensio-robots-txt.settings.update') }}">
@csrf
<div class="space-y-4">
    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-base font-bold text-gray-900">robots.txt</h2>
                <p class="text-sm text-gray-500 mt-0.5">Served dynamically at <a href="/robots.txt" target="_blank" class="text-ember-600 hover:underline font-mono text-xs">/robots.txt</a></p>
            </div>
            <div class="shrink-0 text-xs text-gray-400 bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 font-mono">
                text/plain
            </div>
        </div>

        <textarea name="content" rows="18" spellcheck="false"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm font-mono leading-relaxed focus:outline-none focus:ring-2 focus:ring-ember-500 focus:border-transparent resize-y">{{ old('content', $content) }}</textarea>

        <p class="text-xs text-gray-400">
            Each directive must be on its own line. Use <code class="bg-gray-100 px-1 rounded">Disallow: /</code> to block all bots, or <code class="bg-gray-100 px-1 rounded">Allow: /</code> to allow all.
        </p>
    </div>

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('contensio-robots-txt.settings.reset') }}" onsubmit="return confirm('Reset robots.txt to the default content?')">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition-colors">
                Reset to default
            </button>
        </form>

        <button type="submit" class="bg-ember-500 hover:bg-ember-600 text-white font-semibold text-sm px-5 py-2 rounded-lg transition-colors">
            Save robots.txt
        </button>
    </div>
</div>
</form>
@endsection
