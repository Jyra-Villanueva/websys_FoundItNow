<?php
// Include the database configuration file
require("../login/config.php");

// Initialize variables
$condition = "";
$params = array();

// Filter by campus
if (isset($_GET['campusID']) && $_GET['campusID'] !== "") {
    $condition .= " AND lostitems.campusID = ?";
    $params[] = $_GET['campusID'];
}

// Filter by date range
if (isset($_GET['fromDate']) && isset($_GET['toDate']) && $_GET['fromDate'] !== "" && $_GET['toDate'] !== "") {
    $condition .= " AND lostitems.dateFound BETWEEN ? AND ?";
    $params[] = $_GET['fromDate'];
    $params[] = $_GET['toDate'];
}

// Prepare SQL statement
$query = "SELECT lostitems.*, campus.campusName 
          FROM lostitems 
          INNER JOIN campus ON lostitems.campusID = campus.campusID
          WHERE 1" . $condition . "
          ORDER BY lostitems.dateFound DESC";

// If offset is provided, limit the results
if (isset($_GET['offset'])) {
    $query .= " LIMIT " . intval($_GET['offset']) . ", 6"; 
}

// Prepare and bind parameters
$stmt = $conn->prepare($query);
if ($stmt) {
    if (!empty($params)) {
        $types = str_repeat("s", count($params)); // Assuming all parameters are strings
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the lost items
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4">
            <div class="card">
                <h3><?php echo htmlspecialchars($row['ItemName']); ?></h3>
                <p><strong>Campus:</strong> <?php echo htmlspecialchars($row['campusName']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                <p><strong>Location Lost:</strong> <?php echo htmlspecialchars($row['locationLost']); ?></p>
                <p><strong>Date Found:</strong> <?php echo htmlspecialchars($row['dateFound']); ?></p>
                <p><strong>Contact Info:</strong> <?php echo htmlspecialchars($row['contactInfo']); ?></p>

                <?php 
                    $imagePath = '../uploads/' . $row['image']; 
                    if (!empty($row['image']) && file_exists($imagePath)) {
                        echo '<img src="' . htmlspecialchars($imagePath) . '" class="img-fluid" alt="Item Image">';
                    } else {
                        echo '<p><strong>No Image Available</strong></p>';
                    }
                ?>
            </div>
        </div>
        <?php
    }

    $stmt->close();
} else {
    
    echo "Error in preparing SQL statement.";
}

// Close the database connection
mysqli_close($conn);
?>
