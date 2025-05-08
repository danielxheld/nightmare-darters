<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\DartMatch;
use Livewire\Attributes\On;

new class extends Component {
    public $matches;

    #[On('match-ended')]
    public function loadMatches()
    {
        $this->matches = DartMatch::where('status', 'ended')
            ->get();
    }

    public function mount(): void
    {
        $this->loadMatches();
    }
} ?>

<div class="bg-neutral-850 text-white p-6 rounded-2xl max-w-lg mx-auto space-y-6">
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
            <div class="text-right">
                <div class="text-2xl font-bold">
                    {{ $match->homeScore }} : {{ $match->guestScore }}
                </div>
                <div class="text-xs text-green-400 uppercase">Beendet</div>
            </div>
        </div>
    @empty
        <div class="text-center text-neutral-400">Noch keine beendeten Matches.</div>
    @endforelse
</div>
