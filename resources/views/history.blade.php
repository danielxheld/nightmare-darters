<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <span class="flex items-center space-x-2">
            <img src="{{ asset('nightmare-darters-logo-min.png') }}" alt="Logo" class="h-[50px] w-[50px] rounded-full">
            <span class="text-white font-semibold">Nightmare Darters - Historie</span>
        </span>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <livewire:all-last-matches />
        </div>
    </div>
</x-layouts.app>
