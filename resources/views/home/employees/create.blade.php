@include('home.layouts.header')

<div class="container">
    <a href="{{ url('/') }}" >back to home</a>
    <form  action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Employee Name:</label>
            <input class="form-control" type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="department">Department:</label>
            <select class="form-control" id="department" name="department_id" required>
                <option value="">Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="phone">Phone:</label>
            <input class="form-control" type="text" id="phone" name="phone" required>
        </div>
        <div>
            <label for="dob">Date of Birth:</label>
            <input class="form-control" type="date" id="dob" name="dob" required>
        </div>
        <div>
            <label for="photo">Photo:</label>
            <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
        </div>
        <button class="form-control" type="submit">Add Employee</button>
    </form>

    <div>
        <h2>Employee List</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Phone</th>
                    <th>Date of Birth</th>
                    <th>Age</th>
                    <th>Photo</th>
                    <th>Actions</th> <!-- Added Actions column -->
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->department->name }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->dob }}</td>
                        <td>{{ \Carbon\Carbon::parse($employee->dob)->age }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $employee->photo) }}" alt="Employee Photo" style="width: 50px; height: auto;"> <!-- Fetch and display employee photo -->
                        </td>
                        <td>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this employee?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
