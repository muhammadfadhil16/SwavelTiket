@extends ('layouts.adminLayout')

@section ('title', 'Orders Management')

@section ('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Orders Management</h1>

    <!-- Alerts -->
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
            <i class="bi bi-x text-green-700"></i>
        </button>
    </div>
    @endif
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
            <i class="bi bi-x text-red-700"></i>
        </button>
    </div>
    @endif

    <!-- Search and Filter -->
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <!-- Search Form -->
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-2 w-full md:w-auto">
            <!-- Search by Customer Name -->
            <input
                type="text"
                name="customer"
                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search by customer name"
                value="{{ request('customer') }}"
            >

            <!-- Search by Event Name -->
            <input
                type="text"
                name="event"
                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                placeholder="Search by event name"
                value="{{ request('event') }}"
            >

            <!-- Search Button -->
            <button
                class="px-4 py-2  bg-slate-800 text-white rounded-md hover:bg-slate-700  flex items-center gap-2"
                type="submit"
            >
                <i class="bi bi-search"></i> Search
            </button>
        </form>

        <!-- Export Button -->
        <a
            href="{{ route('admin.orders.export') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 flex items-center gap-2"
        >
            <i class="bi bi-download"></i> Export Orders
        </a>
    </div>

    <!-- Orders Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-black uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-center">No</th>
                    <th scope="col" class="px-6 py-3">Customer Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Event</th>
                    <th scope="col" class="px-6 py-3 text-center">Quantity</th>
                    <th scope="col" class="px-6 py-3 text-right">Total Price</th>
                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Payment</th>
                </tr>
            </thead>
            <tbody>
                @if($orders->count() > 0)
                    @foreach($orders as $key => $order)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $orders->firstItem() + $key }}
                        </td>
                        <td class="px-6 py-4">{{ $order->user->name_user }}</td>
                        <td class="px-6 py-4">{{ $order->user->email_user }}</td>
                        <td class="px-6 py-4">{{ $order->event->name }}</td>
                        <td class="px-6 py-4 text-center">{{ $order->quantity }}</td>
                        <td class="px-6 py-4 text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.orders.updateStatus', $order->id_order) }}" method="POST">
                                @csrf
                                <select
                                    name="status"
                                    class="w-full px-2 py-1 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                    onchange="this.form.submit()"
                                >
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $order->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $order->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-wrap justify-center gap-2">
                                <a
                                    href="{{ route('admin.orders.showPaymentProof', $order->id_order) }}"
                                    target="_blank"
                                    class="px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm"
                                >
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No orders found matching your search.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links('pagination::tailwind') }}
    </div>
</div>
@endsection
