<div class="flex mb-4">
    <div class="mr-auto">
        <h1 class="text-3xl font-bold">{{ $title }}</h1>
    </div>
    @isset($actions)
        <div class="flex items-center gap-2 ms-auto">
            {{ $actions }}
        </div>
    @endisset
</div>
