<?php
session_start();

if (!isset($_SESSION['username'])) {  //checks whether the admin is logged in
    header("Location: index.php");
}

function userList(){
  include './database.php';
  $conn = getDatabaseConnection();
  
  $sql = "SELECT *
          FROM users order by firstName";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
  //print_r($records);
  return $records;
    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Main Page </title>
        <script>
            
            function confirmDelete() {
                
                return confirm("Are you sure you want to delete this user?");
                
            }
            
        </script>
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
    </head>
    <body>

            <h1> Admin Main </h1>
            <h2> Welcome <?=$_SESSION['adminName']?>!</h2>
            
            <form action="addUser.php">
                
                <input type="submit" value="Add New User" />
                
            </form>
            
            
            <form action="logout.php">
                
                <input type="submit" value="Logout!" />
                
            </form>
            
            
            
            <br />
            
            <?php
            
             $users = userList();
             echo "<table>";
             
             foreach($users as $user) {
                 echo "<tr>";
                 
                 
                 echo $user['userId'] . "  " . $user['firstName'] . " " . $user['lastName'];
                 
                 echo "[<a href='updateUser.php?userId=".$user['userId']."'> Update </a>] ";
                 echo "[<a onclick='return confirmDelete()' href='deleteUser.php?userId=".$user['userId']."'> Delete </a>] <br />";
                 
                 echo "</tr>";
                 
                 
                 
             }
             echo "</table>";
             
             
             
             ?>
            
    </body>
</html>