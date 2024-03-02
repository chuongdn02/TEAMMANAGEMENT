<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Team Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <input type="text" id="searchInput" class="form-control mb-2" placeholder="Search Export...">
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
                        <small id="team_id_error" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="team_name">Team Name</label>
                        <input type="text" name="team_name" class="form-control" id="team_name" placeholder="Team Name">
                        <small id="team_name_error" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="department_id">Department</label>
                        <select name="department_id" class="form-control" id="department_id">
                            @foreach($departments as $department)
                                <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                        <small id="department_id_error" class="text-danger"></small> 
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" id="add-btn">Add</button>
                        <button type="button" class="btn btn-warning" id="edit-btn">Update</button>
                        <button type="button" class="btn btn-danger" id="delete-btn">Delete</button>
                    </div>
                </form>
                <button type="button" class="btn btn-success mt-2" id="export-btn">Export to Excel</button>
                
            </div>
            <a href="departments" class="btn btn-info mt-2">Manage Departments</a>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#teamTable').DataTable();

            $('#searchInput').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                table.search(searchText).draw();
            });

            $('#export-btn').on('click', function() {
                const tableData = [];
                $('#teamTable tbody tr').each(function() {
                    const rowData = [];
                    $(this).find('td').each(function() {
                        rowData.push($(this).text());
                    });
                    tableData.push(rowData);
                });

                const csvContent = "data:text/csv;charset=utf-8," + tableData.map(e => e.join(",")).join("\n");
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "team_data.csv");
                document.body.appendChild(link);
                link.click();
            });

            $('#teamTable tbody').on('click', 'tr', function() {
                $('.team-row').removeClass('selected');
                $(this).addClass('selected');
                $('#team_id').val($(this).data('team-id'));
                $('#team_name').val($(this).data('team-name'));
                $('#department_id').val($(this).data('department-id'));
            });

            $('#add-btn').on('click', function() {
                const teamId = $('#team_id').val();
                const teamName = $('#team_name').val();
                const departmentId = $('#department_id').val();

                if (!teamId || !teamName || !departmentId) {
                    if (!teamId) $('#team_id_error').text('Team ID is required.');
                    if (!teamName) $('#team_name_error').text('Team Name is required.');
                    if (!departmentId) $('#department_id_error').text('Department is required.');
                    return;
                }

                if (!/^[a-zA-Z0-9]+$/.test(teamId)) {
                    $('#team_id_error').text('Team ID must contain only letters and numbers.');
                    return;
                }

                $('#teamForm').submit();
            });

            $('#edit-btn').on('click', function() {
                const teamId = $('#team_id').val();
                if (!teamId) {
                    alert('Please select a row to edit.');
                    return;
                }
                $('#teamForm').attr('action', 'teams/' + teamId);
                $('#teamForm').attr('method', 'POST');
                $('#teamForm').append('@csrf');
                $('<input>').attr({
                    type: 'hidden',
                    name: '_method',
                    value: 'PUT'
                }).appendTo('#teamForm');
                $('#teamForm').submit();
            });

            $('#delete-btn').on('click', function() {
                const teamId = $('#team_id').val();
                if (!teamId) {
                    alert('Please select a row to delete.');
                    return;
                }
                if (confirm('Are you sure you want to delete this team?')) {
                    $('#teamForm').attr('action', 'teams/' + teamId);
                    $('#teamForm').attr('method', 'POST');
                    $('#teamForm').append('@csrf');
                    $('<input>').attr({
                        type: 'hidden',
                        name: '_method',
                        value: 'DELETE'
                    }).appendTo('#teamForm');
                    $('#teamForm').submit();
                }
            });
        });

    </script>
</body>
</html>
