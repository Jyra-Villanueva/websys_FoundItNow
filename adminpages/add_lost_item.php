<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Lost Item</title>
</head>


<body>

</head>
<?php require("../components/adminnavi.php");?>
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



    <h2>Add Lost Item</h2>
    <form action="process_lost_item.php" method="post" enctype="multipart/form-data">
        <label for="itemName">Item Name:</label><br>
        <input type="text" id="itemName" name="itemName"><br>
        
        <label for="campusID">Campus ID:</label><br>
        <select id="campusID" name="campusID">
            <option value="CAMP1001">Urdaneta</option>
            <option value="CAMP1002">Asingan</option>
            <!-- Add more options as needed -->
        </select><br>
        
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        
        <label for="locationLost">Location Lost:</label><br>
        <input type="text" id="locationLost" name="locationLost"><br>
        
        <label for="dateFound">Date Found:</label><br>
        <input type="datetime-local" id="dateFound" name="dateFound"><br>
        
        <label for="contactInfo">Contact Info:</label><br>
        <input type="text" id="contactInfo" name="contactInfo"><br>
        
        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image"><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>




