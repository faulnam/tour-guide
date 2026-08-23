@props(['items' => []])

<div class="py-12 md:py-16 border-y border-neutral-200 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="grid grid-cols-2 md:grid-cols-{{ count($items) > 0 ? count($items) : 4 }} gap-8 md:gap-12 text-center divide-y md:divide-y-0 md:divide-x divide-neutral-200">
            @foreach($items as $item)
                <div class="pt-4 md:pt-0 px-4 space-y-2">
                    <div class="stat-number">
                        {{ \App\Models\SiteSetting::get($item['key'], $item['default'] ?? '0') }}
                    </div>
                    <div class="eyebrow tracking-widest text-[11px]">
                        {{ $item['label'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
