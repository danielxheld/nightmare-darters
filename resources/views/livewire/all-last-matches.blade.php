<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\DartMatch;
use Livewire\Attributes\On;

new class extends Component {
    public $matches;
    public bool $isAdmin = false;
    public bool $confirmDelete = false;
    public $matchToDelete = null;

    #[On('match-ended')]
    public function loadMatches()
    {
        $this->matches = DartMatch::where('status', 'ended')
            ->get();
    }

    public function deleteMatch(): void
    {
        if ($this->matchToDelete) {
            $match = DartMatch::findOrFail($this->matchToDelete);
            if ($match) {
                $match->delete();
            }
        }

        $this->confirmDelete = false;
        $this->matchToDelete = null;
        $this->loadMatches();
    }


    public function mount(): void
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->id == 1 || $user->id == 2) {
                $this->isAdmin = true;
            }
        }
        $this->loadMatches();
    }

    public function confirmDeleteMatch($matchId): void
    {
        $this->matchToDelete = $matchId;
        $this->confirmDelete = true;
    }

    public function cancelDeleteMatch(): void
    {
        $this->confirmDelete = false;
        $this->matchToDelete = null;
    }
} ?>

<div class="bg-neutral-850 text-white p-6 rounded-2xl max-w-lg mx-auto space-y-6" wire:poll.500ms="loadMatches">
    <h2 class="text-xl font-bold text-white text-center">Match Historie</h2>

    @forelse ($matches as $match)
        <div class="bg-neutral-800 rounded-xl p-4 shadow-inner flex justify-between items-center">
            <div>
                <div class="text-sm text-neutral-400">
                    {{ \Carbon\Carbon::parse($match->created_at)->format('d.m.Y H:i') }}
                </div>
                <div class="text-lg font-semibold">
                    {{ $match->homeName }} <span class="text-neutral-400">vs</span> {{ $match->guestName }}
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <div class="text-2xl font-bold">
                        {{ $match->homeScore }} : {{ $match->guestScore }}
                    </div>
                    <div class="text-xs text-green-400 uppercase">Beendet</div>
                </div>

                @if($isAdmin)
                    <button
                        wire:click="confirmDeleteMatch({{ $match->id }})"
                        class="text-red-500 hover:text-red-700 text-sm font-semibold"
                        title="Löschen"
                    >
                        Löschen
                    </button>
                @endif
            </div>

            @if($confirmDelete)
                <div class="fixed inset-0 bg-opacity-60 flex items-center justify-center z-50">
                    <div class="bg-neutral-700 p-6 rounded-xl shadow-2xl w-full max-w-sm mx-auto text-center">
                        <p class="text-white text-lg font-semibold mb-4">
                            Bist du sicher, dass du das Match aus der Historie löschen möchtest?
                        </p>

                        <div class="flex justify-center gap-4 mt-6">
                            <button wire:click="deleteMatch"
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md shadow">
                                Ja, löschen
                            </button>
                            <button wire:click="cancelDeleteMatch"
                                    class="px-4 py-2 bg-neutral-600 hover:bg-neutral-700 text-white rounded-md shadow">
                                Abbrechen
                            </button>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    @empty
        <div class="text-center text-neutral-400">Noch keine beendeten Matches.</div>
    @endforelse
</div>
