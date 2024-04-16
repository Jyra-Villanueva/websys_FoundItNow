<?php
// Include the database configuration file
require("../login/config.php");

// Get the filter parameters
$campusID = isset($_GET['campusID']) ? $_GET['campusID'] : null;
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : null;
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : null;
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

// Construct the SQL query with optional filtering
$query = "SELECT lostitems.*, campus.campusName 
          FROM lostitems 
          INNER JOIN campus ON lostitems.campusID = campus.campusID";

// Add filtering conditions for campus
if ($campusID) {
    $query .= " WHERE lostitems.campusID = '$campusID'";
}

// Add filtering conditions for from and to dates if provided
if ($fromDate && $toDate) {
    if ($campusID) {
        $query .= " AND lostitems.dateFound BETWEEN '$fromDate' AND '$toDate'";
    } else {
        $query .= " WHERE lostitems.dateFound BETWEEN '$fromDate' AND '$toDate'";
    }
} elseif ($fromDate) {
    if ($campusID) {
        $query .= " AND lostitems.dateFound >= '$fromDate'";
    } else {
        $query .= " WHERE lostitems.dateFound >= '$fromDate'";
    }
} elseif ($toDate) {
    if ($campusID) {
        $query .= " AND lostitems.dateFound <= '$toDate'";
    } else {
        $query .= " WHERE lostitems.dateFound <= '$toDate'";
    }
}

$query .= " ORDER BY lostitems.dateFound DESC";

// Add limit and offset for pagination
$query .= " LIMIT 6 OFFSET $offset";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Fetch and display lost items
    while ($row = mysqli_fetch_assoc($result)) {
        // Output HTML for displaying each lost item
        // Adjust this HTML structure as needed to match your design
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<h3>' . htmlspecialchars($row['ItemName']) . '</h3>';
        echo '<p><strong>Campus:</strong> ' . htmlspecialchars($row['campusName']) . '</p>';
        echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
        echo '<p><strong>Location Lost:</strong> ' . htmlspecialchars($row['locationLost']) . '</p>';
        // Add more details if needed
        echo '</div>';
        echo '</div>';
    }

    // If there are more items, show the "See More" button
    $nextOffset = $offset + 6; // Increment offset for the next set of items
    echo '<div class="col-md-12 text-center mt-3">';
    echo '<button id="seeMoreBtn" class="btn btn-primary" data-offset="' . $nextOffset . '">See More</button>';
    echo '</div>';
} else {
    // If no lost items found, display a message
    echo '<div class="col-md-12 text-center">No lost items found.</div>';
}

// Close the database connection
mysqli_close($conn);
?>
