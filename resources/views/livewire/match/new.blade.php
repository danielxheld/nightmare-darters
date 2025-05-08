<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public ?User $user;
    public string $guestName = '';
    public string $homeName = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->user = Auth::user();
        if ($this->user->dartMatches()->where('status', 'active')->exists()) {
            $this->redirect(route('dashboard', absolute: false));
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function createMatch(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'guestName' => ['required', 'string', 'max:255'],
            'homeName' => ['required', 'string', 'max:255'],
        ]);

        $user->dartMatches()->create([
            'homeName' => $validated['homeName'],
            'guestName' => $validated['guestName'],
            'homeScore' => 0,
            'guestScore' => 0,
            'status' => 'active',
        ]);

        $this->redirectIntended(default: route('dashboard', absolute: false));
    }
}; ?>

<section class="w-full">
    @include('partials.match-heading')

    <x-match.layout>
        <form wire:submit="createMatch" class="my-6 w-full space-y-6">
            <flux:input wire:model="homeName" :label="__('Heim - Name')" type="text" required autofocus/>
            <flux:input wire:model="guestName" :label="__('Gast - Name')" type="text" required autofocus/>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Match anlegen') }}</flux:button>
                </div>
            </div>
        </form>
    </x-match.layout>
</section>
