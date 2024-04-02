
<?php
require("../components/header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found Questionnaire</title>
    <link rel="stylesheet" href="../css/cssquestionaire.css">
</head>
<body>
    <h1>Lost and Found Questionnaire</h1>
    <form id="lostFoundForm" action="../form/submit_form.php" method="post" enctype="multipart/form-data">
        <label for="itemName">Item Name:</label>
        <input type="text" id="itemName" name="itemName" required><br><br>
       
        <label for="campusID">Campus:</label>
            <select id="campusID" name="campusID" required>
                <option value="">Select Campus</option>
                <option value="CAMP1001">Urdaneta Campus</option>
                <option value="CAMP1002">Asingan Campus</option>
                <option value="CAMP1003">Binmaley Campus</option>
                <option value="CAMP1004">Alaminos Campus</option>
                <option value="CAMP1005">Bayambang Campus</option>
                <option value="CAMP1006">Infanta Campus</option>
                <option value="CAMP1007">San Carlos Campus</option>
                <option value="CAMP1008">Sta. Maria Campus</option>
                <option value="CAMP1009">Lingayen Campus</option>
            </select><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>

        <label for="locationLost">Location Lost/Found:</label>
        <input type="text" id="locationLost" name="locationLost" required><br><br>

        <label for="dateFound">Date Found/Lost:</label>
        <input type="datetime-local" id="dateFound" name="dateFound" required><br><br>

        <label for="contactInfo">Contact Information:</label>
        <input type="text" id="contactInfo" name="contactInfo" required><br><br>

        <label for="image">Upload Image (Optional):</label>
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" value="Submit">
    </form>
    <?php
require("../components/footer.php");
?>
</body>
</html>
