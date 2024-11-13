@include('home.layouts.header')

<div class="container">
    <div class="button-container">
        <a href="{{ route('departments.create') }}" class="btn btn-primary">Add Department</a>
        <a href="{{ route('employees.create') }}" class="btn btn-secondary">Add Employee Details</a>
    </div>
</div>
