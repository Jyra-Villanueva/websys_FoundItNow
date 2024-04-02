<?php
// Include the database configuration file
require("../login/config.php");
require('../components/superadminnavi.php');
// Function to escape special characters in a string for use in an SQL statement
function escape_string($value) {
    global $conn;
    return mysqli_real_escape_string($conn, $value);
}

// Check if item ID and claim status are provided in the URL for updating claim status
if (isset($_GET['itemID']) && isset($_GET['claimed'])) {
    // Sanitize input
    $itemID = escape_string($_GET['itemID']);
    $claimed = ($_GET['claimed'] == 'true') ? 1 : 0; // Convert 'true' or 'false' to 1 or 0
    
    // Update the claim status in the database
    $query = "UPDATE lostitems SET claimed = '$claimed' WHERE itemID = '$itemID'";
    if (mysqli_query($conn, $query)) {
        echo "Claim status updated successfully.";
    } else {
        echo "Error updating claim status: " . mysqli_error($conn);
    }
}

// Check if item ID is provided in the URL for delete or update
if (isset($_GET['action']) && isset($_GET['itemID'])) {
    $action = $_GET['action'];
    $itemID = escape_string($_GET['itemID']);
    
    // Perform delete or update action based on the provided action
    if ($action == 'delete') {
        // Delete the item from the database
        $query = "DELETE FROM lostitems WHERE itemID = '$itemID'";
        if (mysqli_query($conn, $query)) {
            echo "Item deleted successfully.";
        } else {
            echo "Error deleting item: " . mysqli_error($conn);
        }
    } elseif ($action == 'update') {
        // Redirect to update page with the itemID
        header("Location: update_item.php?itemID=$itemID");
        exit();
    }
}

// Check if filter parameter is provided to show claimed items
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'unclaimed'; // Default to unclaimed if filter parameter is not provided

// Check if search query is provided
$search = isset($_GET['search']) ? escape_string($_GET['search']) : '';

// Fetch lost items based on filter and search query
$query = "SELECT * FROM lostitems WHERE 1";

// Add filter condition
if ($filter == 'claimed') {
    $query .= " AND claimed = 1";
} else {
    $query .= " AND claimed = 0";
}

// Add search query condition
if (!empty($search)) {
    $query .= " AND (ItemName LIKE '%$search%' OR campusID LIKE '%$search%' OR description LIKE '%$search%' OR locationLost LIKE '%$search%' OR contactInfo LIKE '%$search%')";
}

$result = mysqli_query($conn, $query);

// Check if there are any lost items
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Lost Items</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

</head>
<body>



<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
<body>
    
    <div class="container">
        <h2 class="mt-4">Manage Lost Items</h2>
        <form method="GET" action="" class="mt-3 mb-3">
            <div class="form-group">
                <input type="text" name="search" placeholder="Search..." class="form-control" value="<?php echo htmlspecialchars($search); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        <a href="?filter=unclaimed" class="btn btn-secondary">Show Unclaimed Items</a>
        <a href="?filter=claimed" class="btn btn-secondary">Show Claimed Items</a>
        <table class="table mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Item Name</th>
                    <th>Campus ID</th>
                    <th>Description</th>
                    <th>Location Lost</th>
                    <th>Date Found</th>
                    <th>Contact Info</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['ItemName']); ?></td>
                        <td><?php echo htmlspecialchars($row['campusID']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['locationLost']); ?></td>
                        <td><?php echo htmlspecialchars($row['dateFound']); ?></td>
                        <td><?php echo htmlspecialchars($row['contactInfo']); ?></td>
                        <td>
                            <a href="?itemID=<?php echo $row['itemID']; ?>&claimed=<?php echo $row['claimed'] == 0 ? 'true' : 'false'; ?>" class="btn btn-<?php echo $row['claimed'] == 0 ? 'success' : 'warning'; ?> btn-sm">
                                <?php echo $row['claimed'] == 0 ? 'Mark as Claimed' : 'Mark as Not Claimed'; ?>
                            </a>
                            <a href="?action=delete&itemID=<?php echo $row['itemID']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            <a href="?action=update&itemID=<?php echo $row['itemID']; ?>" class="btn btn-info btn-sm">Update</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
} else {
    // No lost items found
    echo "No lost items found";
}

// Close the database connection
mysqli_close($conn);
?>
