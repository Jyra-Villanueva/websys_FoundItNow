<?php
// Include the database configuration file
require("../login/config.php");
require("../components/adminnavi.php");
// Get the search term from the AJAX request
$searchTerm = mysqli_real_escape_string($conn, $_GET['term']);

// Fetch users that match the search term from the database
$query = "SELECT * FROM user 
          WHERE studentid LIKE '%$searchTerm%' 
          OR name LIKE '%$searchTerm%' 
          OR email LIKE '%$searchTerm%' 
          OR campusName LIKE '%$searchTerm%'";

$result = mysqli_query($conn, $query);

// Prepare an array to store the search results
$searchResults = [];

// Loop through the query results and add them to the search results array
while ($row = mysqli_fetch_assoc($result)) {
    $searchResults[] = $row;
}

// Close the database connection
mysqli_close($conn);

// Return the search results as JSON
echo json_encode($searchResults);
?>
