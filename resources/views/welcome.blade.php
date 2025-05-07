<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid grid-cols-1 auto-rows-min gap-1">
            <livewire:active-matches-counter/>
        </div>
    </div>
</x-layouts.app>
