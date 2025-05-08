<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <livewire:live-viewer-counter />
        </div>
        <div class="grid grid-cols-1 auto-rows-min gap-1">
            <div class="relative aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:match-counter />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <livewire:last-matches />
        </div>
    </div>
</x-layouts.app>
