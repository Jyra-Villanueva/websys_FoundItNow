<?php
// Include the database configuration file
require("../login/config.php");
require("../components/adminnavi.php");
// Fetch all users from the database
$query = "SELECT * FROM user";
$result = mysqli_query($conn, $query);

// Fetch distinct campus names from the database
$campusQuery = "SELECT DISTINCT campusID FROM user"; // Adjusted column name to 'campusID'
$campusResult = mysqli_query($conn, $campusQuery);

// Check if there are any users
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User List</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
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

<div class="container mt-5">
    <h2 class="mb-4">User List</h2>
    <div class="mb-3">
        <label for="campusFilter" class="form-label">Filter by Campus:</label>
        <select class="form-select" id="campusFilter">
            <option value="">All Campuses</option>
            <?php
            while ($row = mysqli_fetch_assoc($campusResult)) {
                echo "<option value='" . $row['campusID'] . "'>" . $row['campusID'] . "</option>"; // Adjusted to 'campusID'
            }
            ?>
        </select>
    </div>
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search for Student ID..">
    <div id="searchResults">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Campus ID</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Loop through each row and display user data
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['studentid']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['campusID']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo htmlspecialchars($row['ID']); ?>"
                           class="btn btn-primary">Edit</a>
                        <button onclick="deleteUser(<?php echo htmlspecialchars($row['ID']); ?>)"
                                class="btn btn-danger">Delete
                        </button>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#campusFilter').change(function () {
            var selectedCampus = $(this).val();
            // Send AJAX request to filter users by selected campus
            $.ajax({
                url: 'filter_users.php',
                type: 'GET',
                data: {campus: selectedCampus},
                dataType: 'html',
                success: function (response) {
                    $('#searchResults').html(response);
                }
            });
        });

        $('#searchInput').keyup(function () {
            var searchTerm = $(this).val();
            // Send AJAX request to search users
            $.ajax({
                url: 'search_users.php',
                type: 'GET',
                data: {term: searchTerm},
                dataType: 'html',
                success: function (response) {
                    $('#searchResults').html(response);
                }
            });
        });
    });

    function deleteUser(ID) {
        if (confirm("Are you sure you want to delete this user?")) {
            $.ajax({
                url: 'delete_user.php',
                type: 'POST',
                data: {ID: ID},
                success: function (data) {
                    // Reload the page after deleting the user
                    location.reload();
                }
            });
        }
    }
</script>
</body>
</html>
<?php
} else {
    // No users found
    echo "No users found";
}

// Close the database connection
mysqli_close($conn);
?>
