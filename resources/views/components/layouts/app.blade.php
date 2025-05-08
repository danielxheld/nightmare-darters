<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
    <script>
        if (!window.viewerId) {
            window.viewerId = "{{ session('viewer_id') }}";

            setInterval(() => {
                fetch("/live-ping", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ session_id: window.viewerId })
                });
            }, 1000);
        }
    </script>
</x-layouts.app.sidebar>
