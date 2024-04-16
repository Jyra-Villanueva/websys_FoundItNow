<?php
// Include the database configuration file
require("../login/config.php");

// Get the search term from the request
$searchTerm = $_GET['term'];

// SQL query to search for users based on the search term
$query = "SELECT * FROM user WHERE studentid LIKE '%$searchTerm%' OR name LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";

// Perform the query
$result = mysqli_query($conn, $query);

// Check if there are any results
if ($result && mysqli_num_rows($result) > 0) {
    // Output the results in HTML format
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped'>";
    echo "<thead class='thead-dark'>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Student ID</th>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "<th>Campus ID</th>";
    echo "<th>Actions</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['studentid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['campusID']) . "</td>";
        echo "<td>
                <a href='edit_user.php?id=" . htmlspecialchars($row['ID']) . "' class='btn btn-primary'>Edit</a>
                <button onclick='deleteUser(" . htmlspecialchars($row['ID']) . ")' class='btn btn-danger'>Delete</button>
              </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    // No users found
    echo "<div class='alert alert-warning' role='alert'>No users found</div>";
}

// Close the database connection
mysqli_close($conn);
?>
