<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Departments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Departments</h2>
        <form action="{{ route('departments.store') }}" method="POST" class="mb-3">
            @csrf
            <input type="text" name="department_id" placeholder="Department ID" class="form-control" required>
            @if ($errors->has('department_id'))
                <span class="text-danger">{{ $errors->first('department_id') }}</span>
            @endif
            <input type="text" name="department_name" placeholder="Department Name" class="form-control" required>
            <input type="text" name="descriptions" placeholder="Descriptions" class="form-control" required>
            <button type="submit" class="btn btn-primary mt-2">Add Department</button>
        </form>
        <ul class="list-group">
            @foreach($departments as $department)
                <li class="list-group-item">
                    {{ $department->department_name }}
                    <form action="{{ route('departments.destroy', $department->department_id) }}" method="POST" class="float-right" id="delete-form-{{ $department->department_id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-department-name="{{ $department->department_name }}" data-department-id="{{ $department->department_id }}">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <a href="teams" class="btn btn-info mt-2">Manage Teams</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const departmentName = this.getAttribute('data-department-name');
                    const departmentId = this.getAttribute('data-department-id');
                    const confirmDelete = confirm(`Are you sure you want to delete the department "${departmentName}"?`);

                    if (confirmDelete) {
                        const form = document.getElementById(`delete-form-${departmentId}`);
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
