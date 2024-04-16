<?php
// Include the database configuration file
require("../login/config.php");
require('../components/superadminnavi.php');

// Initialize variables for date range filter
$startDate = $_GET['startDate'] ?? date('Y-m-01');
$endDate = $_GET['endDate'] ?? date('Y-m-t');

// Fetch all users within the specified date range from the database
$query = "SELECT * FROM user WHERE dateCreated BETWEEN '$startDate' AND '$endDate'";
$result = mysqli_query($conn, $query);

// Fetch distinct campus names from the database
$campusQuery = "SELECT DISTINCT campusID FROM user";
$campusResult = mysqli_query($conn, $campusQuery);

// Check if there are any users
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User List</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <style>
            /* Your CSS styles here */
        </style>
    </head>
    <body>
    <div class="container mt-5">
        <h2 class="mb-4">User List</h2>
        <!-- Date range filter -->
        <div class="mb-3">
            <label for="startDate" class="form-label">Start Date:</label>
            <input type="date" id="startDate" name="startDate" class="form-control" value="<?= $startDate ?>">
        </div>
        <div class="mb-3">
            <label for="endDate" class="form-label">End Date:</label>
            <input type="date" id="endDate" name="endDate" class="form-control" value="<?= $endDate ?>">
        </div>
        <button onclick="applyDateRangeFilter()" class="btn btn-primary">Apply</button>
        <!-- End of date range filter -->

        <!-- User list -->
        <div id="searchResults" class="mt-3">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Campus ID</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ID']); ?></td>
                        <td><?= htmlspecialchars($row['studentid']); ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['campusID']); ?></td>
                        <td><?= date('F j, Y', strtotime($row['dateCreated'])); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= htmlspecialchars($row['ID']); ?>"
                               class="btn btn-primary">Edit</a>
                            <button onclick="deleteUser(<?= htmlspecialchars($row['ID']); ?>)"
                                    class="btn btn-danger">Delete
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function applyDateRangeFilter() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            // Redirect to the same page with date range parameters
            window.location.href = 'user_list.php?startDate=' + startDate + '&endDate=' + endDate;
        }

        $(document).ready(function () {
            $('#campusFilter').change(function () {
                var selectedCampus = $(this).val();
                // Send AJAX request to filter users by selected campus
                $.ajax({
                    url: 'filter_users.php',
                    type: 'GET',
                    data: {campus: selectedCampus}, // Pass the selected campus value
                    dataType: 'html',
                    success: function (response) {
                        $('#searchResults').html(response);
                    }
                });
            });

            $('#searchInput').keyup(function () {
                var searchTerm = $(this).val();
                // Send AJAX request to search users
                $.ajax({
                    url: 'search_users.php',
                    type: 'GET',
                    data: {term: searchTerm},
                    dataType: 'html',
                    success: function (response) {
                        $('#searchResults').html(response);
                    }
                });
            });
        });

        function deleteUser(ID) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: 'delete_user.php',
                    type: 'POST',
                    data: {ID: ID},
                    success: function (data) {
                        // Reload the page after deleting the user
                        location.reload();
                    }
                });
            }
        }
    </script>
    </body>
    </html>
    <?php
} else {
    // No users found
    echo "No users found";
}

// Close the database connection
mysqli_close($conn);
?>
