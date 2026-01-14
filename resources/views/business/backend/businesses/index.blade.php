@extends('layout.superAdminDashboard')

@section('body')
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800">Business Listings</h1>
            {{-- Search bar positioned to the right on desktop --}}
            <div class="flex-shrink-0 w-full sm:w-80">
                <input
                    type="text"
                    id="searchInput"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm"
                    placeholder="Search by business name..."
                    oninput="searchTable()"
                />
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Images</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="businessTable" class="bg-white divide-y divide-gray-200">
                        @foreach($businesses as $business)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $business->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $business->businessType->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $business->businessLocation->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $business->contact_no }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $business->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($business->images->isNotEmpty())
                                        @php $image = $business->images->first(); @endphp
                                        <img src="{{ asset($image->image_path) }}" alt="Business Image" class="object-cover rounded-lg shadow-sm"  style="height: 30px; width: 30px;">
                                    @else
                                        <span class="text-gray-400 text-sm">No Images</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($business->is_approved)
                                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Approved</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex flex-wrap gap-2">
                                       <!-- View Button -->
                                        <a href="{{ route('business.view', $business) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium bg-red-500 text-white rounded hover:bg-red-600">
                                            <i class="fas fa-eye text-sm text-black"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('business.edit', $business) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium bg-red-500 text-white rounded hover:bg-red-600">
                                            <i class="fas fa-edit text-sm text-black"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('business.delete', $business) }}" method="GET" class="inline-block">
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this business?')" class="inline-flex items-center px-3 py-1 text-xs font-medium bg-red-500 text-white rounded hover:bg-red-600">
                                                <i class="fas fa-trash-alt text-sm text-black"></i>
                                            </button>
                                        </form>

                                        @if(!$business->is_approved)
                                            <form action="{{ route('business.approve', $business) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors duration-150">Approve</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#businessTable tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                row.style.display = name.includes(input) ? '' : 'none';
            });
        }
    </script>
@endsection