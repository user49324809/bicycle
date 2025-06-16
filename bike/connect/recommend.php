<?php
$recommendedAccessories = [];
$query = "SELECT * FROM recommended_accessories";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recommendedAccessories[] = $row;
    }
}


