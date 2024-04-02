<?php
// Include the database configuration file
require("../login/config.php");

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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .topnav {
            background-color: #007bff;
            overflow: hidden;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 20px;
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

<body>

<?php require("../components/adminnavi.php");?>

<h2 class="text-center my-4">Lost Items</h2>

<!-- Filter Dropdown -->
<div class="container mb-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <label for="campusFilter">Filter by Campus:</label>
            <select id="campusFilter" class="form-control">
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
    </div>
</div>

<!-- Display Lost Items -->
<div class="container">
    <div class="row">
        <?php
        // Loop through each row and display lost item data
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <?php 
                    $imagePath = '../uploads/' . $row['image']; // Adjusted path
                    if (!empty($row['image']) && file_exists($imagePath)) {
                        echo '<img class="card-img-top" src="' . htmlspecialchars($imagePath) . '" alt="Item Image">';
                    } else {
                        echo '<div class="card-img-top">No Image Available</div>';
                    }
                    ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['ItemName']); ?></h5>
                        <p class="card-text"><strong>Campus:</strong> <?php echo htmlspecialchars($row['campusName']); ?></p>
                        <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="card-text"><strong>Location Lost:</strong> <?php echo htmlspecialchars($row['locationLost']); ?></p>
                        <p class="card-text"><strong>Date Found:</strong> <?php echo htmlspecialchars($row['dateFound']); ?></p>
                        <p class="card-text"><strong>Contact Info:</strong> <?php echo htmlspecialchars($row['contactInfo']); ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
