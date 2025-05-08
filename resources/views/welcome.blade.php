<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <span class="flex items-center space-x-2">
            <img src="{{ asset('nightmare-darters-logo-min.png') }}" alt="Logo" class="h-[50px] w-[50px]">
            <span class="text-white font-semibold">Nightmare Darters - Aktive Matches</span>
        </span>
        <div>
            <livewire:live-viewer-counter />
        </div>
        <div class="grid grid-cols-1 auto-rows-min gap-1">
            <livewire:active-matches-counter/>
        </div>
    </div>
</x-layouts.app>
