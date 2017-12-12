<?php
session_start();
    if(!isset($_SESSION['username'])){
        
        header("Location: index.php");
    }



  include './database.php';
  $conn = getDatabaseConnection();
function departmentList(){
      
        global $conn;
        
        $sql = "SELECT * FROM department ORDER BY deptName";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $records;
    }  
function getUserInfo() {
    global $conn;
    
    $sql = "SELECT * 
            FROM users
            WHERE userId = " . $_GET['userId']; 
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    //print_r($record);
    
    return $record;

}

if(isset($_GET['updateUser'])){// checks whether admin has submitted form

    echo"Form has been submitted!";
    $sql = "UPDATE users
            SET firstName = :fName,
                lastName = :lName,
                email = :email,
                phone = :phone
            WHERE userId = :id";
    $np = array();
    
    $np[':fName'] = $_GET['firstName'];
    $np[':lName'] = $_GET['lastName'];
    $np[':email'] = $_GET['email'];
    $np[':phone'] = $_GET['phone'];
    $np[':id'] = $_GET['userId'];
    
    print_r($np);
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    
    echo"Record has been updated!";
    
}


 if (isset($_GET['userId'])) {
     
    $userInfo = getUserInfo(); 
     
     
 }



?>


<!DOCTYPE html>
<html>
    <head>
        <title> Update User </title>
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
    </head>
    <body>

        <h1> Tech Checkout System: Updating User's Info </h1>
        <form method="GET">
            <input type="hidden" name="userId" value="<?=$userInfo['userId']?>" />
            First Name:<input type="text" name="firstName" value="<?=$userInfo['firstName']?>" />
            <br />
            Last Name:<input type="text" name="lastName" value="<?=$userInfo['lastName']?>"/>
            <br/>
            Email: <input type= "email" name ="email" value="<?=$userInfo['email']?>"/>
            <br/>
            Phone Number: <input type ="text" name= "phone" value="<?=$userInfo['phone']?>"/>
            <br />
           Role: 
           <select name="role">
                <option value=""> - Select One - </option>
                <option value="staff"  <?=($userInfo['role']=='Staff')?" selected":"" ?>  >Staff</option>
                <option value="student" <?=($userInfo['role']=='Student')?" selected":"" ?>  >Student</option>
                <option value="faculty" <?=($userInfo['role']=='Faculty')?" selected":"" ?>>Faculty</option>
            </select>
            <br />
            Department: 
            <select name="deptId">
                <option value="" >- Select One - </option>
                  <?php
                    
                    $departments = departmentList();
                    
                    foreach($departments as $department) {
                       echo "<option value='".$department['id']."' ";
                       echo ($userInfo['deptId']==$department['deptartmentId'])?" selected":"";
                       echo "> " . $department['deptName']  . "</option>";  
                    }
                    
                    
                    ?>
            </select>
            <input type="submit" value="Update User" name="updateUser">
        </form>

    </body>
</html>