<?php
// Include the database configuration file
require("../login/config.php");
require("../components/adminnavi.php");
// Check if campusID is set and not empty
if (isset($_GET['campusID']) && !empty($_GET['campusID'])) {
    // If a specific campus is selected, filter by campusID
    // Prepare the SQL statement with a placeholder for the campusID
    $query = "SELECT lostitems.*, campus.campusName 
              FROM lostitems 
              INNER JOIN campus ON lostitems.campusID = campus.campusID 
              WHERE lostitems.campusID = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind the campusID parameter to the placeholder
    mysqli_stmt_bind_param($stmt, "s", $_GET['campusID']);
    
    // Execute the statement
    mysqli_stmt_execute($stmt);
    
    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Output the filtered lost items
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($row['ItemName']); ?></h3>
                <p><strong>Campus:</strong> <?php echo htmlspecialchars($row['campusName']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                <p><strong>Location Lost:</strong> <?php echo htmlspecialchars($row['locationLost']); ?></p>
                <p><strong>Date Found:</strong> <?php echo htmlspecialchars($row['dateFound']); ?></p>
                <p><strong>Contact Info:</strong> <?php echo htmlspecialchars($row['contactInfo']); ?></p>
                <?php 
                    $imagePath = '../uploads/' . $row['image']; // Adjusted path
                    if (!empty($row['image']) && file_exists($imagePath)) {
                        echo '<p><strong>Image:</strong><br><img src="' . htmlspecialchars($imagePath) . '" alt="Item Image"></p>';
                    } else {
                        echo '<p><strong>No Image Available</strong></p>';
                    }
                ?>
            </div>
            <?php
        }
    } else {
        echo "No lost items found for this campus";
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // If no specific campus is selected, fetch all lost items
    // Query to fetch all lost items without filtering by campus
    $query = "SELECT lostitems.*, campus.campusName 
              FROM lostitems 
              INNER JOIN campus ON lostitems.campusID = campus.campusID";
    
    // Execute the query
    $result = mysqli_query($conn, $query);

    // Output the lost items
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($row['ItemName']); ?></h3>
                <p><strong>Campus:</strong> <?php echo htmlspecialchars($row['campusName']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                <p><strong>Location Lost:</strong> <?php echo htmlspecialchars($row['locationLost']); ?></p>
                <p><strong>Date Found:</strong> <?php echo htmlspecialchars($row['dateFound']); ?></p>
                <p><strong>Contact Info:</strong> <?php echo htmlspecialchars($row['contactInfo']); ?></p>
                <?php 
                    $imagePath = '../uploads/' . $row['image']; // Adjusted path
                    if (!empty($row['image']) && file_exists($imagePath)) {
                        echo '<p><strong>Image:</strong><br><img src="' . htmlspecialchars($imagePath) . '" alt="Item Image"></p>';
                    } else {
                        echo '<p><strong>No Image Available</strong></p>';
                    }
                ?>
            </div>
            <?php
        }
    } else {
        echo "No lost items found";
    }
}

// Close the database connection
mysqli_close($conn);
?>
