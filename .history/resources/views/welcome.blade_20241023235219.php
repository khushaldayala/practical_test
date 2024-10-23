<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Leaderboard</h1>

        <form action="{{ route('leaderboard.index') }}" method="GET" class="mb-4">
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
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" onclick="location.href='{{ route('leaderboard.recalculate') }}'" class="btn btn-warning">Re-calculate</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Rank</th>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Total Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboardData as $entry)
                    <tr>
                        <td>{{ $entry->id }}</td> <!-- Change to user_id based on your model -->
                        <td>{{ $entry->rank }}</td>
                        <td>{{ $entry->name }}</td> <!-- Change to full_name based on your model -->
                        <td>{{ $entry->points }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>