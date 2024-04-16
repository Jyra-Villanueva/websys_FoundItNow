<?php
// Include the database configuration file
require("../login/config.php");

// Get parameters from the AJAX request
$campus = $_GET['campus'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Construct the base query
$query = "SELECT * FROM user WHERE 1";

// Append the campus filter if a campus is selected
if (!empty($campus)) {
    $query .= " AND campusID = '$campus'";
}

// Append the date range filter if both start and end dates are provided
if (!empty($startDate) && !empty($endDate)) {
    // Convert dates to MySQL date format (YYYY-MM-DD)
    $startDate = date('Y-m-d', strtotime($startDate));
    $endDate = date('Y-m-d', strtotime($endDate));
    
    // Append the date range condition to the query
    $query .= " AND dateCreated BETWEEN '$startDate' AND '$endDate'";
}

// Execute the query
$result = mysqli_query($conn, $query);

// Check if there are any users
if (mysqli_num_rows($result) > 0) {
    // Output HTML for displaying users
    while ($row = mysqli_fetch_assoc($result)) {
?>
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
            // Loop through each row and display user data
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['studentid']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['campusID']); ?></td>
                    <td><?php echo date("F j, Y", strtotime($row['dateCreated'])); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo htmlspecialchars($row['ID']); ?>"
                           class="btn btn-primary">Edit</a>
                        <button onclick="deleteUser(<?php echo htmlspecialchars($row['ID']); ?>)"
                                class="btn btn-danger">Delete
                        </button>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
<?php
    }
} else {
    // No users found
    echo "<tr><td colspan='7'>No users found</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>
