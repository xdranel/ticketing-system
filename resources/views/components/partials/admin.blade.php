<x-nav-item :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
    Dashboard
</x-nav-item>
<x-nav-item :href="route('tickets.index')" :active="request()->routeIs('tickets.index', 'tickets.show', 'tickets.edit')">
    All Tickets
</x-nav-item>
<x-nav-item :href="route('tickets.create')" :active="request()->routeIs('tickets.create')">
    Create Ticket
</x-nav-item>
