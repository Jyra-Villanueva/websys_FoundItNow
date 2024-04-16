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
    <link rel="stylesheet" href="../css/cssdashboard.css">
    <style>
        /* Add your CSS styles here */
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
        </div>
        <div id="verificationMessage"></div>
        <div class="container mt-3">
            <div class="row">
                <?php
                // Display lost items
                while ($row = mysqli_fetch_assoc($result)) {
                    // Calculate time elapsed since the item was found
                    $timeFound = strtotime($row['dateFound']);
                    $timeNow = time();
                    $timeDiff = $timeNow - $timeFound;
                    if ($timeDiff < 60 * 60 * 24) {
                        $timeAgo = round($timeDiff / (60 * 60));
                        $timeUnit = ($timeAgo === 1) ? "hour" : "hours";
                        $timeAgo = "$timeAgo $timeUnit ago";
                    } else {
                        $timeAgo = round($timeDiff / (60 * 60 * 24));
                        $timeUnit = ($timeAgo === 1) ? "day" : "days";
                        $timeAgo = "$timeAgo $timeUnit ago";
                    }
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <?php 
                        $imagePath = '../form/uploads/' . $row['image']; 
                        if (!empty($row['image']) && file_exists($imagePath)) {
                            echo '<p><strong>Image:</strong><br><img src="' . htmlspecialchars($imagePath) . '" alt="Item Image"></p>';
                        } else {
                            echo '<p><strong>No Image Available</strong></p>';
                        }
                        ?>
                        <h3><?php echo htmlspecialchars($row['ItemName']); ?></h3>
                        <p><strong>Campus:</strong> <?php echo htmlspecialchars($row['campusName']); ?></p>
                        <p><strong>Location Lost:</strong> <?php echo htmlspecialchars($row['locationLost']); ?></p>
                        <p><strong>Date Found:</strong> <?php echo date("F j, Y", strtotime($row['dateFound'])); ?></p>
                        <p><strong>Contact Info:</strong> <?php echo htmlspecialchars($row['contactInfo']); ?></p>
                        <p><strong>Date Posted:</strong> <?php echo $timeAgo; ?></p>
                        <button class="btn btn-primary claim-btn" data-item-id="<?php echo $row['itemID']; ?>">Claim</button>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal for questionnaire -->
    <div class="modal fade" id="questionnaireModal" tabindex="-1" role="dialog" aria-labelledby="questionnaireModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="questionnaireModalLabel">Claim Item Questionnaire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="questionnaireForm">
                        <div class="form-group">
                            <label for="question1">Describe the Item</label>
                            <input type="text" class="form-control" id="question1" name="question1" required>
                        </div>
                        <input type="hidden" id="itemId" name="itemId">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event listener for claim buttons
            $('.claim-btn').click(function() {
                var itemId = $(this).data('item-id');
                openQuestionnaireModal(itemId);
            });

            // Function to open questionnaire modal
            function openQuestionnaireModal(itemId) {
                $('#itemId').val(itemId);
                $('#questionnaireModal').modal('show');
            }

            // Submit questionnaire form
            $('#questionnaireForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'submit_questionnaire.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Display the response message
                        $('#verificationMessage').html(response).show();
                        $('#questionnaireModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Show error message or perform any other action
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
