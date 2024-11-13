@include('home.layouts.header')

<div class="container">
    <a href="{{ url('/') }}">back to home</a>

    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Department Name</label>
            <input type="text" class="form-control-sm" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Department</button>
    </form>

    <h2>Existing Departments</h2>
    <ul>
        @foreach ($departments as $department)
            <li>{{ $department->name }}
                <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                    style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this department?');">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
