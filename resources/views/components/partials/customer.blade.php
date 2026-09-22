<x-nav-item :href="route('customer.dashboard')" :active="request()->routeIs('customer.dashboard')">
    Dashboard
</x-nav-item>
<x-nav-item :href="route('tickets.index')" :active="request()->routeIs('tickets.index', 'tickets.show')">
    My Tickets
</x-nav-item>
<x-nav-item :href="route('tickets.create')" :active="request()->routeIs('tickets.create')">
    Create Ticket
</x-nav-item>
