<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use App\Models\DartMatch;

new class extends Component {
    public $matches;
    public int $homeScore;
    public int $guestScore;
    public string $homeName;
    public string $guestName;
    public bool $confirmEnd = false;

    public function mount(): void
    {
        $this->matches = DartMatch::where('status', 'active')->get();
    }
} ?>

<div>
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
                        <div class="text-red-400 uppercase">Home</div>
                        <div class="text-lg">{{ $match->homeName }}</div>
                    </div>
                    <div>
                        <div class="text-blue-400 uppercase">Guest</div>
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
