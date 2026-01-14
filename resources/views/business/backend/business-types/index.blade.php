@extends('layout.superAdminDashboard')
@section('body')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Business Types</h1>

        <div class="mb-4">
            <form action="{{ route('business-types.bulk-upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center">
                    <input type="file" name="file" accept=".csv,.xlsx,.xls" class="form-control w-1/3" required>
                    <button type="submit" class="btn btn-primary mt-2">Upload CSV/Excel</button>
                </div>
                <p class="text-sm text-gray-600 mt-2">Upload a CSV or Excel file with only 'name' column for business types.</p>
            </form>
        </div>
        <a href="{{ route('business-type.create') }}" class="btn btn-dark mb-4 d-inline-block ms-auto">
    Create New <i class="bi bi-plus-lg ms-2"></i>
</a>



        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($businessTypes as $type)
                    <tr>
                        <td class="border px-4 py-2">{{ $type->name }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('business-type.edit', $type) }}" class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('business-type.delete', $type) }}" method="GET" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this business type?')">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection