<x-nav-item :href="route('agent.dashboard')" :active="request()->routeIs('agent.dashboard')">
    Dashboard
</x-nav-item>
<x-nav-item :href="route('tickets.index')" :active="request()->routeIs('tickets.index', 'tickets.show', 'tickets.edit')">
    Assigned Tickets
</x-nav-item>
