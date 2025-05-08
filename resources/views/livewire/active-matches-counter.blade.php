<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\DartMatch;

new class extends Component {
    public $matches;

    public function mount(): void
    {
        $this->loadMatches();
    }

    public function loadMatches(): void
    {
        $this->matches = DartMatch::where('status', 'active')->get();
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
            </div>
        </div>
        @endforeach
    @endif
</div>
