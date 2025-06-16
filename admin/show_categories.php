<?php
require_once('include/db.php');
//require_once($_SERVER["DOCUMENT_ROOT"] . "index.php");
function selectAllCategories(){
  // Запрос для получения всех категорий
  $query = "SELECT * FROM bike_categories";  
  $conn = openDbConnection();
  $result = $conn->query($query);  
  if ($result) {
      $categories = [];
      while ($row = $result->fetch_assoc()) {
          $categories[] = $row; 
      }
      
      return $categories;  
  } else {
      return [];  
  }
}
?>

