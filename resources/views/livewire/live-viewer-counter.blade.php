<?php

use Livewire\Volt\Component;
use App\Models\LiveViewer;

new class extends Component {
    public int $onlineCount = 0;

    public function loadOnlineCount(): void
    {
        $this->onlineCount = LiveViewer::where('last_ping', '>=', now()->subSeconds(1))->count();
    }

    public function mount(): void
    {
        $this->loadOnlineCount();
    }
} ?>

<div wire:poll.500ms="loadOnlineCount" class="text-sm text-white">
    Live Zuschauer: {{ $onlineCount }}
</div>
