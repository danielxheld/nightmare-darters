<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\DartMatch;

new class extends Component {
    public $matches;
    public bool $confirmEnd = false;
    public $matchToEnd = null;

    public function mount(): void
    {
        $this->loadMatches();
    }

    public function loadMatches(): void
    {
        $this->matches = DartMatch::where('status', 'active')->get();
    }

    public function confirmEndMatch($matchId): void
    {
        $this->matchToEnd = $matchId;
        $this->confirmEnd = true;
    }

    public function cancelEndMatch(): void
    {
        $this->confirmEnd = false;
        $this->matchToEnd = null;
    }

    public function endMatch(): void
    {
        if ($this->matchToEnd) {
            $match = DartMatch::find($this->matchToEnd);
            if ($match) {
                $match->status = 'ended';
                $match->save();
            }
        }

        $this->confirmEnd = false;
        $this->matchToEnd = null;
        $this->loadMatches();
    }
} ?>

<div wire:poll.500ms="loadMatches">
    @if (!$matches->count())
        <div class="relative aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="h-full text-white p-6 rounded-2xl shadow-xl max-w-lg mx-auto space-y-6">
                <div class="h-full flex items-center justify-center">
                    <div class="h-full flex items-center justify-center text-center font-bold text-lg">
                        <p>Keine aktiven Matches</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        @foreach($this->matches as $match)
        <div class="relative aspect-video rounded-xl border border-neutral-200 dark:border-neutral-700 @if (!$loop->first) mt-6 @endif">
            <div class="text-white p-6 rounded-2xl shadow-xl max-w-lg mx-auto space-y-6">
                <div class="grid grid-cols-2 text-center text-sm font-semibold text-neutral-400">
                    <div>
                        <div class="text-red-400 uppercase">Heim</div>
                        <div class="text-lg">{{ $match->homeName }}</div>
                    </div>
                    <div>
                        <div class="text-blue-400 uppercase">Gast</div>
                        <div class="text-lg">{{ $match->guestName }}</div>
                    </div>
                </div>


                <div class="text-center text-8xl font-extrabold tracking-wider mb-1">
                    {{ $match->homeScore }} <span class="text-4xl text-neutral-500">:</span> {{ $match->guestScore }}
                </div>

                <div class="text-center">
                    <button wire:click="confirmEndMatch({{ $match->id }})"
                            class="mt-6 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl shadow-lg font-semibold">
                        Match beenden
                    </button>
                </div>

                @if($confirmEnd)
                    <div class="fixed inset-0 bg-opacity-60 flex items-center justify-center z-50">
                        <div class="bg-neutral-700 p-6 rounded-xl shadow-2xl w-full max-w-sm mx-auto text-center">
                            <p class="text-white text-lg font-semibold mb-4">
                                Bist du sicher, dass du das Match für jemand anderes beenden möchtest?
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
            </div>
        </div>
        @endforeach
    @endif
</div>
