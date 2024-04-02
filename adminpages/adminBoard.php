<?php
// Include the database configuration file
require("../login/config.php");
require("../components/adminnavi.php");
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
        <style>
            .card {
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 10px;
                margin-bottom: 10px;
                background-color: #f9f9f9;
            }
            .card img {
                max-width: 100%;
                height: auto;
            }

            body {
            margin: 0;
            padding: 0;
        }

        .topnav {
            background-color: #333;
            overflow: hidden;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        .topnav .icon {
            display: none;
        }

        @media screen and (max-width: 600px) {
            .topnav a:not(:first-child) {display: none;}
            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 600px) {
            .topnav.responsive {position: relative;}
            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }
            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }
        }
        </style>
    </head>

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
        <h2>Lost Items</h2>

        <!-- Filter Dropdown -->
        <div>
            <label for="campusFilter">Filter by Campus:</label>
            <select id="campusFilter">
                <option value="">All Campuses</option>
                <?php
                // Fetch distinct campus names and populate the dropdown
                $campusQuery = "SELECT DISTINCT campusID, campusName FROM campus";
                $campusResult = mysqli_query($conn, $campusQuery);
                while ($row = mysqli_fetch_assoc($campusResult)) {
                    echo "<option value='{$row['campusID']}'>{$row['campusName']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Display Lost Items -->
        <div class="container">
            <?php
            // Loop through each row and display lost item data
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($row['ItemName']); ?></h3>
                    <p><strong>Campus:</strong> <?php echo htmlspecialchars($row['campusName']); ?></p> <!-- Display Campus Name -->
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
            ?>
        </div>

        <script>
    // JavaScript to handle campus filtering
    document.getElementById('campusFilter').addEventListener('change', function() {
        var campusID = this.value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.querySelector('.container').innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "filter_lost_items.php?campusID=" + campusID, true);
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
