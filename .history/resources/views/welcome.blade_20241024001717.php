<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Leaderboard</h1>

        <form id="filterForm" method="GET" class="mb-4">
            <div class="form-row">
                <div class="col">
                    <input type="text" name="search" class="form-control" placeholder="Search by User ID">
                </div>
                <div class="col">
                    <select name="filter" class="form-control">
                        <option value="">Select Filter</option>
                        <option value="day">Today</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" id="filterButton">Filter</button>
                    <button type="button" id="recalculateButton" class="btn btn-warning">Re-calculate</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="leaderboardTable">
                <thead class="thead-dark">
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Total Points</th>
                        <th>Rank</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboardData as $entry)
                    <tr>
                        <td>{{ $entry->id }}</td>
                        <td>{{ $entry->name }}</td>
                        <td>{{ $entry->points }}</td>
                        <td>{{ $entry->rank }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {

            function showleads() {
                // Handle filter button click
                $('#filterButton').click(function() {
                    $.ajax({
                        url: "{{ route('leaderboard.index') }}",
                        type: "GET",
                        data: $('#filterForm').serialize(),
                        success: function(data) {
                            // Update the table with the new data
                            let rows = '';
                            $.each(data.leaderboardData, function(index, entry) {
                                rows += `<tr>
                                            <td>${entry.id}</td>
                                            <td>${entry.name}</td>
                                            <td>${entry.points}</td>
                                            <td>${entry.rank}</td>
                                         </tr>`;
                            });
                            $('#leaderboardTable tbody').html(rows);
                            toastr.success('Leaderboard updated successfully!');
                        },
                        error: function() {
                            toastr.error('An error occurred while fetching data.');
                        }
                    });
                });
            }

            // Handle recalculate button click
            $('#recalculateButton').click(function() {
                $.ajax({
                    url: "{{ route('leaderboard.recalculate') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}' // Include CSRF token for security
                    },
                    success: function(response) {
                        toastr.success(response.message); // Show success message
                        // Optionally refresh the leaderboard
                        $('#filterButton').click();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Display a more informative error message
                        var errorMessage = jqXHR.responseJSON?.message || 'An error occurred while recalculating ranks.';
                        toastr.error(errorMessage);
                    }
                });
            });

        });
    </script>
</body>

</html>