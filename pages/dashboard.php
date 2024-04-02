<?php
// Include the database configuration file
require("../login/config.php");
require("../components/navigator.php");
// Initialize the campus filter variable and search query variable
$campusFilter = "";
$searchQuery = "";

// Check if a specific campus is selected
if (isset($_GET['campusID']) && $_GET['campusID'] !== 'all') {
    // Sanitize the input
    $campusFilter = mysqli_real_escape_string($conn, $_GET['campusID']);
    $campusFilterClause = "WHERE lostitems.campusID = '{$campusFilter}'";
} else {
    // If "All Campuses" is selected or no filter is applied, show all posts
    $campusFilterClause = "";
}

// Check if a search query is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    // Sanitize the input
    $searchQuery = mysqli_real_escape_string($conn, $_GET['search']);
    
    // Construct the search condition
    $searchCondition = "AND (ItemName LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%' OR locationLost LIKE '%$searchQuery%' OR contactInfo LIKE '%$searchQuery%')";
} else {
    $searchCondition = "";
}

// Fetch all lost items from the database with associated campus names
$query = "SELECT lostitems.*, campus.campusName 
          FROM lostitems 
          INNER JOIN campus ON lostitems.campusID = campus.campusID
          {$campusFilterClause}
          {$searchCondition}";
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
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            margin-top: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        }

        .card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .card h3 {
            margin-top: 0;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card p {
            margin: 5px 0;
            font-size: 14px;
        }

        .card strong {
            font-weight: bold;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        /* Adjustments for small screens */
        @media screen and (max-width: 600px) {
            .card {
                width: calc(50% - 20px); /* Two cards per row */
            }
        }

        /* Adjustments for extra small screens */
        @media screen and (max-width: 400px) {
            .card {
                width: calc(100% - 20px); /* One card per row */
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Lost Items</h2>
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="campusFilter">Filter by Campus:</label>
                <select id="campusFilter" class="form-control">
                    <option value="all">All Campuses</option>
                    <?php
                    // Fetch distinct campus names and populate the dropdown
                    $campusQuery = "SELECT DISTINCT campusID, campusName FROM campus";
                    $campusResult = mysqli_query($conn, $campusQuery);
                    while ($row = mysqli_fetch_assoc($campusResult)) {
                        $selected = ($row['campusID'] === $campusFilter) ? "selected" : "";
                        echo "<option value='{$row['campusID']}' $selected>{$row['campusName']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <form action="" method="get">
                    <label for="search">Search:</label>
                    <div class="input-group">
                        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>" class="form-control" placeholder="Enter search keyword">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>

        <div class="container" id="lostItemsContainer">
            <?php
            // Loop through each row and display lost item data
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <?php 
                            $imagePath = '../form/uploads/' . $row['image']; // Adjusted path
                            if (!empty($row['image']) && file_exists($imagePath)) {
                                echo '<p><strong>Image:</strong><br><img src="' . htmlspecialchars($imagePath) . '" alt="Item Image"></p>';
                            } else {
                                echo '<p><strong>No Image Available</strong></p>';
                            }
                        ?>
                        <h3><?php echo htmlspecialchars($row['ItemName']); ?></h3>
                        <p><strong>Campus:</strong> <?php echo htmlspecialchars($row['campusName']); ?></p> <!-- Display Campus Name -->
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                        <p><strong>Location Lost:</strong> <?php echo htmlspecialchars($row['locationLost']); ?></p>
                        <p><strong>Date Found:</strong> <?php echo htmlspecialchars($row['dateFound']); ?></p>
                        <p><strong>Contact Info:</strong> <?php echo htmlspecialchars($row['contactInfo']); ?></p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

   
        
        </div>
    </div>

    <script>
        // JavaScript to handle campus filtering
        document.getElementById('campusFilter').addEventListener('change', function() {
            var campusID = this.value;
            var searchQuery = document.getElementById('search').value; // Get the search query
            var url = "../adminpages/filter_lost_item.php";

            // Adjust the URL based on the selected campus ID and search query
            if (campusID !== "all") {
                url += "?campusID=" + campusID;
            }
            if (searchQuery.trim() !== "") {
                url += (campusID !== "all" ? "&" : "?") + "search=" + encodeURIComponent(searchQuery); // Include search query in URL
            }

            // Send AJAX request to update lost items
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('lostItemsContainer').innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
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