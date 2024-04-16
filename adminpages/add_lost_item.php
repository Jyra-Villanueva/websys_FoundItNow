<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lost Item</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php require("../components/adminnavi.php");?>

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

<div class="container">
    <h2 class="mt-4">Add Lost Item</h2>
    <form action="process_lost_item.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="itemName">Item Name:</label>
            <input type="text" class="form-control" id="itemName" name="itemName">
        </div>
        
        <div class="form-group">
            <label for="campusID">Campus:</label>
            <select class="form-control" id="campusID" name="campusID">
                <option value="CAMP1001">Urdaneta</option>
                <option value="CAMP1002">Asingan</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        
        <div class="form-group">
            <label for="locationLost">Location Lost:</label>
            <input type="text" class="form-control" id="locationLost" name="locationLost">
        </div>
        
        <div class="form-group">
            <label for="dateFound">Date Found:</label>
            <input type="datetime-local" class="form-control" id="dateFound" name="dateFound">
        </div>
        
        <div class="form-group">
            <label for="contactInfo">Contact Info:</label>
            <input type="text" class="form-control" id="contactInfo" name="contactInfo">
        </div>
        
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
