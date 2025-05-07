<?php

use Livewire\Volt\Component;
use App\Models\DartMatch;

new class extends Component {
    public string $homeName = '';
    public string $guestName = '';

    protected $rules = [
        'homeName' => 'required|string|max:255',
        'guestName' => 'required|string|max:255',
    ];

    public function create()
    {
        $this->validate();

        $match = DartMatch::create([
            'homeName' => $this->homeName,
            'guestName' => $this->guestName,
            'homeScore' => 0,
            'guestScore' => 0,
            'status' => 'active',
        ]);

        return redirect()->route('dart-match.show', $match);
    }
}; ?>

<div class="bg-white dark:bg-neutral-900 p-6 max-w-md mx-auto rounded-2xl shadow space-y-6">
    <h2 class="text-xl font-bold text-neutral-800 dark:text-white text-center">Neues Dart-Match erstellen</h2>

    <form wire:submit.prevent="create" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Home-Spieler</label>
            <input type="text" wire:model.defer="homeName" class="w-full rounded border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 p-2" required>
            @error('homeName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Guest-Spieler</label>
            <input type="text" wire:model.defer="guestName" class="w-full rounded border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 p-2" required>
            @error('guestName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="text-center">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                Match erstellen
            </button>
        </div>
    </form>
</div>

