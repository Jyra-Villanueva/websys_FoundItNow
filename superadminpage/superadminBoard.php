<?php
// Include the database configuration file
require("../login/config.php");
require("../components/superadminnavi.php");


// Fetch all lost items from the database with associated campus names
$query = "SELECT lostitems.*, campus.campusName 
          FROM lostitems 
          INNER JOIN campus ON lostitems.campusID = campus.campusID";
$result = mysqli_query($conn, $query);

// Check if there are any lost items
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Items</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles */
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .card img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-3">Lost Items</h2>

        <!-- Filter Dropdown -->
        <div class="mb-3">
            <label for="campusFilter">Filter by Campus:</label>
            <select id="campusFilter" class="form-control">
                <option value="">All Campuses</option>
                <?php
                // PHP code to fetch campus names and populate dropdown options
                $campusQuery = "SELECT DISTINCT campusID, campusName FROM campus";
                $campusResult = mysqli_query($conn, $campusQuery);
                while ($row = mysqli_fetch_assoc($campusResult)) {
                    echo "<option value='{$row['campusID']}'>{$row['campusName']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Display Lost Items as Grid View -->
        <div class="row" id="lostItemsContainer">
            <?php
            // PHP code to fetch and display lost item data
            while ($row = mysqli_fetch_assoc($result)) {
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
                            $imagePath = '../uploads/' . $row['image']; // Adjusted path
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
            ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // JavaScript to handle campus filtering
        $(document).ready(function() {
            $('#campusFilter').change(function() {
                var campusID = $(this).val();
                $.ajax({
                    url: "../adminpages/filter_lost_items.php",
                    type: "GET",
                    data: { campusID: campusID },
                    success: function(response) {
                        $('#lostItemsContainer').html(response);
                    }
                });
            });
        });
    </script>
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
