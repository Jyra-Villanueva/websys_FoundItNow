<?php
// Include the database configuration file
require("../login/config.php");

// Get the selected campus value from the request
$selectedCampus = $_GET['campus'];

// SQL query to filter users by selected campus
$query = "SELECT * FROM user WHERE campusID = '$selectedCampus'";
$result = mysqli_query($conn, $query);

// Check if there are any results
if ($result && mysqli_num_rows($result) > 0) {
    // Output the results in HTML format
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
} else {
    // No users found for the selected campus
    echo "<tr><td colspan='6'>No users found for the selected campus</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>
