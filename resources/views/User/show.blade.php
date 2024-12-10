@extends ('layouts.layout')

@section('content')
    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="w-50 d-flex justify-content-center mx-auto my-4">
        <form action="{{ route('user.index') }}" class="d-flex gap-2" role="search">
            <input type="text" class="form-control" name="search_name" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <div class="container my-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0 text-center">User  List</h3>
            </div>
            <div class="card-body p-4">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user as $index => $item)
                        <tr>
                            <td class="text-center">
                                {{ ($user->currentPage() - 1) * $user->perPage() + ($index + 1) }}
                            </td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['email'] }}</td>
                            <td>{{ $item['role'] }}</td>
                            <td class="text-center">
                                <a href="{{ route('user.edit', $item['id']) }}" class="btn btn-outline-primary me-2 btn-sm">Edit</a>
                                <a href="#" class="btn btn-outline-danger btn-sm" onclick="showModal('{{ $item->id }}', '{{ $item->name }}')">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Modal Delete -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="form-delete-user" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this user <span id="name-user"></span>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div>
                    <a href="{{ route('user.exportExcel')}}" class="btn btn-success">Export to Excel</a>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $user->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function showModal(id, name) {
            let urlDelete = "{{ route('user.destroy', ':id') }}";
            urlDelete = urlDelete.replace(':id', id);
            $('#form-delete-user').attr('action', urlDelete);
            $('#exampleModal').modal('show');
            $('#name-user').text(name);
        }
    </script>
@endpush
@push('style')
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .alert {
            margin-bottom: 20px;
        }
        .modal-content {
            border-radius: 10px;
        }
    </style>
@endpush
