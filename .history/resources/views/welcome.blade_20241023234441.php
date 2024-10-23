<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
</head>

<body>
    <h1>Leaderboard</h1>

    <form action="{{ route('leaderboard.index') }}" method="GET">
        <input type="text" name="search" placeholder="Search by User ID">
        <select name="filter">
            <option value="">Select Filter</option>
            <option value="day">Today</option>
            <option value="month">This Month</option>
            <option value="year">This Year</option>
        </select>
        <button type="submit">Filter</button>
        <button type="button" onclick="location.href='{{ route('leaderboard.recalculate') }}'">Re-calculate</button>
    </form>

    <table>
        <thead>
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
                <td>{{ $entry->rank }}</td>
                <td>{{ $entry->user_id }}</td>
                <td>{{ $entry->full_name }}</td>
                <td>{{ $entry->points }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>