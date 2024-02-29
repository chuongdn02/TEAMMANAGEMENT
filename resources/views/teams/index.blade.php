<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Team Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h2>Team Management</h2>
                <table class="table" id="teamTable">
                    <thead>
                        <tr>
                            <th>Team ID</th>
                            <th>Team Name</th>
                            <th>Department Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                            @php
                                $team_department_name = '';
                                foreach($departments as $department) {
                                    if($department->department_id === $team->department_id) {
                                        $team_department_name = $department->department_name;
                                        break;
                                    }
                                }
                            @endphp
                            <tr class="team-row" data-team-id="{{ $team->team_id }}" data-team-name="{{ $team->team_name }}" data-department-id="{{ $team->department_id }}">
                                <td>{{ substr($team->team_id, 0, 10) }}</td> 
                                <td>{{ substr($team->team_name, 0, 20) }}</td>
                                <td>{{ substr($team_department_name, 0, 20) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h2>Add/Edit Team</h2>
                <form id="teamForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="team_id">Team ID</label>
                        <input type="text" name="team_id" class="form-control" id="team_id" placeholder="Team ID">
                    </div>
                    <div class="form-group">
                        <label for="team_name">Team Name</label>
                        <input type="text" name="team_name" class="form-control" id="team_name" placeholder="Team Name">
                    </div>
                    <div class="form-group">
                        <label for="department_id">Department</label>
                        <select name="department_id" class="form-control" id="department_id">
                            @foreach($departments as $department)
                                <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" id="add-btn">Add</button>
                        <button type="button" class="btn btn-warning" id="edit-btn">Edit</button>
                        <button type="button" class="btn btn-danger" id="delete-btn">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.team-row');
            const form = document.getElementById('teamForm');
            const teamIdInput = document.getElementById('team_id');
            const teamNameInput = document.getElementById('team_name');
            const departmentIdInput = document.getElementById('department_id');

            rows.forEach(row => {
                row.addEventListener('click', function() {
                    rows.forEach(row => row.style.backgroundColor = '');
                    this.style.backgroundColor = 'lightblue';
                    teamIdInput.value = this.getAttribute('data-team-id');
                    teamNameInput.value = this.getAttribute('data-team-name');
                    departmentIdInput.value = this.getAttribute('data-department-id');
                });
            });

            document.getElementById('add-btn').addEventListener('click', function() {
                const teamId = teamIdInput.value;
                const teamName = teamNameInput.value;
                const departmentId = departmentIdInput.value;

                if (!teamId.trim() || !teamName.trim() || !departmentId.trim()) {
                    alert('Please fill in all fields.');
                    return;
                }

                const teamExists = Array.from(rows).some(row => row.getAttribute('data-team-id') === teamId);

                if (teamExists) {
                    alert('Team ID already exists');
                } else {
                    if (confirm('Do you want to create?')) {
                        const form = document.createElement('form');
                        form.setAttribute('action', 'teams');
                        form.setAttribute('method', 'POST');
                        form.innerHTML = `
                            @csrf
                            <input type="hidden" name="team_id" value="${teamId}">
                            <input type="hidden" name="team_name" value="${teamName}">
                            <input type="hidden" name="department_id" value="${departmentId}">`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                } 
            });


            document.getElementById('edit-btn').addEventListener('click', function() {
                const teamId = teamIdInput.value;
                const teamName = teamNameInput.value;
                const departmentId = departmentIdInput.value;

                if (!teamId.trim() || !teamName.trim() || !departmentId.trim()) {
                    alert('Please fill in all fields.');
                    return;
                }

                const teamExists = Array.from(rows).some(row => row.getAttribute('data-team-id') === teamId);
                if (!teamExists) {
                    alert(`Team ID: ${teamId} does not exist`);
                }else{
                    if (teamId) {
                        if (confirm('Do you want to do this action?')) {
                            const form = document.createElement('form');
                            form.setAttribute('action', `teams/${teamId}`);
                            form.setAttribute('method', 'POST');
                            form.innerHTML = `
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="team_id" value="${teamId}">
                                <input type="hidden" name="team_name" value="${teamName}">
                                <input type="hidden" name="department_id" value="${departmentId}">`;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    } else {
                        alert('Please select a row or enter Team ID to edit.');
                    }
                }
            });

            document.getElementById('delete-btn').addEventListener('click', function() {
                const teamId = teamIdInput.value;

                const teamExists = Array.from(rows).some(row => row.getAttribute('data-team-id') === teamId);

                if (!teamExists) {
                    alert(`Team ID: ${teamId} does not exist`);
                }else{
                    if (teamId) {
                        if (confirm(`Are you sure you want to delete Team ID: ${teamId}?`)) {
                            const form = document.createElement('form');
                            form.setAttribute('action', `teams/${teamId}`);
                            form.setAttribute('method', 'POST');
                            form.innerHTML = `
                                @csrf
                                @method('DELETE')`;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    } else {
                        alert('Please select a row or enter Team ID to delete.');
                    }
                } 
            });
        });
    </script>
</body>
</html>
