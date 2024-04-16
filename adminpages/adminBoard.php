<?php
// Include the database configuration file
require("../login/config.php");
require("../components/adminnavi.php");

// Set default values for from and to dates
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : null;
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : null;

// Construct the SQL query with optional date range filtering
$query = "SELECT lostitems.*, campus.campusName 
          FROM lostitems 
          INNER JOIN campus ON lostitems.campusID = campus.campusID";

// Add filtering conditions for from and to dates if they are provided
if ($fromDate && $toDate) {
    $query .= " WHERE lostitems.dateFound BETWEEN '$fromDate' AND '$toDate'";
} elseif ($fromDate) {
    $query .= " WHERE lostitems.dateFound >= '$fromDate'";
} elseif ($toDate) {
    $query .= " WHERE lostitems.dateFound <= '$toDate'";
}

$query .= " ORDER BY lostitems.dateFound DESC";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Items</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
.card-container {
    display: flex;
    flex-wrap: wrap;
}

.card {
    flex: 0 0 calc(33.3333% - 20px); /* Adjust the width as needed */
    margin: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background-color: #f9f9f9;
}

.card img {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
}
#campusFilter {
    width: auto; /* Adjust the width as needed */
    max-width: 200px; /* Set a maximum width if necessary */
}
#fromDate {
    width: auto; /* Adjust the width as needed */
    max-width: 200px; /* Set a maximum width if necessary */
}
#toDate {
    width: auto; /* Adjust the width as needed */
    max-width: 200px; /* Set a maximum width if necessary */
}
.date-filter {
    display: flex;
    justify-content: end;
    align-items: center;
}
.date-filter input {
    width: auto;
    max-width: 200px;
}
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-3">Lost Items</h2>

    <!-- Filter Dropdown and Date Range Filter -->
    <div class="mb-3 row">
        <label for="campusFilter" class="col-md-2 col-sm-12 col-form-label">Filter by Campus:</label>
        <div class="col-md-4 col-sm-12">
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
        <div class="col-md-6 col-sm-12">
            <div class="row">
                <label for="fromDate" class="col-sm-4 col-form-label">From:</label>
                <div class="col-sm-8">
                    <input type="date" id="fromDate" class="form-control" value="<?php echo $fromDate; ?>">
                </div>
            </div>
            <div class="row mt-2">
                <label for="toDate" class="col-sm-4 col-form-label">To:</label>
                <div class="col-sm-8">
                    <input type="date" id="toDate" class="form-control" value="<?php echo $toDate; ?>">
                </div>
            </div>
        </div>
    </div>

        <!-- Display Lost Items as Grid View -->
        <div class="row" id="lostItemsContainer">
            <?php
            // PHP code to fetch and display limited number of lost items
            $limit = 6; // Number of items to display initially
            $count = 0; // Counter to track displayed items
            if(mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Calculate time difference
                    $foundTime = strtotime($row['dateFound']);
                    $currentTime = time();
                    $timeDiff = $currentTime - $foundTime;

                    // Determine time ago string
                    if ($timeDiff < 3600) { // Less than 1 hour
                        $timeAgo = round($timeDiff / 60) . " minutes ago";
                    } elseif ($timeDiff < 86400) { // Less than 24 hours
                        $timeAgo = round($timeDiff / 3600) . " hours ago";
                    } else { // More than 24 hours
                        $daysAgo = round($timeDiff / 86400); // Calculate days
                        $timeAgo = $daysAgo . " days ago";
                    }

                    // Convert dateFound to desired format
                    $dateFound = date('F j, Y', strtotime($row['dateFound']));
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <h3><?php echo htmlspecialchars($row['ItemName']); ?></h3>
                            <p><strong>Campus:</strong> <?php echo htmlspecialchars($row['campusName']); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                            <p><strong>Location Lost:</strong> <?php echo htmlspecialchars($row['locationLost']); ?></p>
                            <p><strong>Date Found:</strong> <?php echo $dateFound; ?></p>
                            <p><strong>Contact Info:</strong> <?php echo htmlspecialchars($row['contactInfo']); ?></p>
                            <p><strong>Date Posted:</strong> <?php echo $timeAgo; ?></p>

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
                    $count++; // Increment counter
                }
            } else {
                echo "<div class='col-md-12 text-center'>No lost items found for the specified date range.</div>";
            }
            ?>

        </div>

        <!-- See More Button -->
        <div class="col-md-12 text-center mt-3">
            <button id="seeMoreBtn" class="btn btn-primary">See More</button>
        </div>
    </div>
        <!-- See More Button -->
        <div class="col-md-12 text-center mt-3">
            <button id="seeMoreBtn" class="btn btn-primary">See More</button>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // JavaScript to handle campus filtering and "See More" button
        $(document).ready(function () {
            // Function to load additional lost items
            function loadMoreItems() {
                var campusID = $('#campusFilter').val();
                var offset = $('.card').length; // Number of already displayed items
                $.ajax({
                    url: "../adminpages/filter_lost_items.php",
                    type: "GET",
                    data: { campusID: campusID, offset: offset },
                    success: function (response) {
                        $('#lostItemsContainer').append(response);
                    }
                });
            }

            $('#campusFilter').change(function () {
                var campusID = $(this).val();
                var fromDate = $('#fromDate').val();
                var toDate = $('#toDate').val();
                
                $.ajax({
                    url: "../superadminpage/filter_lost_items.php",
                    type: "GET",
                    data: { campusID: campusID, fromDate: fromDate, toDate: toDate },
                    success: function (response) {
                        $('#lostItemsContainer').html(response);
                    }
                });
            });

            // See More button click event
            $('#seeMoreBtn').click(function () {
                loadMoreItems();
            });
        });
    </script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
