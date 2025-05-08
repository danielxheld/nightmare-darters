<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\DartMatch;

new class extends Component {
    public ?DartMatch $match;
    public int $homeScore;
    public int $guestScore;
    public string $homeName;
    public string $guestName;
    public bool $confirmEnd = false;

    public function mount(): void
    {
        $user = Auth::user();
        $this->match = $user->dartMatches()->where('status', 'active')->first();
        if ($this->match) {
            $this->homeScore = $this->match->homeScore;
            $this->guestScore = $this->match->guestScore;
            $this->homeName = $this->match->homeName;
            $this->guestName = $this->match->guestName;
        }
    }

    public function incrementHome(): void
    {
        if ($this->match->isEnded()) return;
        $this->homeScore++;
        $this->save();
    }

    public function decrementHome(): void
    {
        if ($this->match->isEnded()) return;
        if ($this->homeScore > 0) $this->homeScore--;
        $this->save();
    }

    public function incrementGuest(): void
    {
        if ($this->match->isEnded()) return;
        $this->guestScore++;
        $this->save();
    }

    public function decrementGuest(): void
    {
        if ($this->match->isEnded()) return;
        if ($this->guestScore > 0) $this->guestScore--;
        $this->save();
    }

    public function endMatch()
    {
        $this->match->update([
            'homeScore' => $this->homeScore,
            'guestScore' => $this->guestScore,
            'status' => 'ended',
        ]);
        $this->confirmEnd = false;
        $this->match = null;

        $this->dispatch('match-ended');
    }

    protected function save()
    {
        $this->match->update([
            'homeScore' => $this->homeScore,
            'guestScore' => $this->guestScore,
        ]);
    }

    public function confirmEndMatch(): void
    {
        $this->confirmEnd = true;
    }

    public function cancelEndMatch(): void
    {
        $this->confirmEnd = false;
    }

    public function createNewMatch()
    {
        return redirect()->route('match.new');
    }
} ?>

<div class="@if (!$match) h-full @endif text-white p-6 rounded-2xl shadow-xl max-w-lg mx-auto space-y-6">
    @if (!$match)
        <div class="h-full flex items-center justify-center">
            <div class="h-full flex items-center justify-center text-center font-bold text-lg">
                <button wire:click="createNewMatch"
                        class="px-6 py-3 bg-green-600 text-white rounded-xl shadow-lg font-semibold">
                    Neues Match erstellen
                </button>
            </div>
        </div>
    @else
        <!-- Namen -->
        <div class="grid grid-cols-2 text-center text-sm font-semibold text-neutral-400">
            <div>
                <div class="text-red-400 uppercase">Heim</div>
                <div class="text-lg">{{ $homeName }}</div>
            </div>
            <div>
                <div class="text-blue-400 uppercase">Gast</div>
                <div class="text-lg">{{ $guestName }}</div>
            </div>
        </div>

        <!-- Punktestand -->
        <div class="text-center text-8xl font-extrabold tracking-wider">
            {{ $homeScore }} <span class="text-4xl text-neutral-500">:</span> {{ $guestScore }}
        </div>

        <!-- Buttons -->
        <div class="grid grid-cols-2 gap-6">
            <!-- Home Buttons -->
            <div class="flex justify-center gap-4">
                <button wire:click="decrementHome"
                        class="w-14 h-14 bg-gradient-to-br from-neutral-700 to-neutral-800 hover:from-neutral-600 hover:to-neutral-700 text-3xl font-bold rounded-full shadow-inner">
                    –
                </button>
                <button wire:click="incrementHome"
                        class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 text-3xl font-bold rounded-full shadow-lg">
                    +
                </button>
            </div>

            <!-- Guest Buttons -->
            <div class="flex justify-center gap-4">
                <button wire:click="decrementGuest"
                        class="w-14 h-14 bg-gradient-to-br from-neutral-700 to-neutral-800 hover:from-neutral-600 hover:to-neutral-700 text-3xl font-bold rounded-full shadow-inner">
                    –
                </button>
                <button wire:click="incrementGuest"
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-400 hover:to-blue-500 text-3xl font-bold rounded-full shadow-lg">
                    +
                </button>
            </div>
        </div>

        <div class="text-center">
            <button wire:click="confirmEndMatch"
                    class="mt-6 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl shadow-lg font-semibold">
                Match beenden
            </button>
        </div>

        @if($confirmEnd)
            <div class="fixed inset-0 bg-opacity-60 flex items-center justify-center z-50">
                <div class="bg-neutral-700 p-6 rounded-xl shadow-2xl w-full max-w-sm mx-auto text-center">
                    <p class="text-white text-lg font-semibold mb-4">
                        Bist du sicher, dass du das Match beenden möchtest?
                    </p>

                    <div class="flex justify-center gap-4 mt-6">
                        <button wire:click="endMatch"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md shadow">
                            Ja, beenden
                        </button>
                        <button wire:click="cancelEndMatch"
                                class="px-4 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-md shadow">
                            Abbrechen
                        </button>
                    </div>
                </div>
            </div>

        @endif
    @endif
</div>
