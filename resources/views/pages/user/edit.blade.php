@extends('panel/main')
@section('content')
    <form enctype="multipart/form-data" action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required autocomplete="off">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" required autocomplete="off">
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" autocomplete="off">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" name="role" id="role" required>
                        <option value="0" {{ $user->role == 0 ? 'selected' : '' }}>User</option>
                        <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="foto">Foto:</label>
                    <input type="file" class="form-control" name="foto" id="foto">
                    @error('foto')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection

@push('script')
    <script>
        $('#dataTable').DataTable();
    </script>
@endpush
