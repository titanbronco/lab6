<?php

include './database.php';
$conn = getDatabaseConnection();

    function departmentList(){
      
        global $conn;
        
        $sql = "SELECT * FROM Departments ORDER BY name";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $records;
    }


if (isset($_GET['addUser'])) {  //the add form has been submitted

    $sql = "INSERT INTO User
             (firstName, lastName, email, role, phone, deptId) 
             VALUES
             (:fName, :lName, :email, :role, :phone, :deptId)";
    $np = array();
    
    echo "$sql";
    
    $np[':fName'] = $_GET['firstName'];
    $np[':lName'] = $_GET['lastName'];
    $np[':email'] = $_GET['email'];
    $np[':phone'] = $_GET['phone'];
    $np[':role'] = $_GET['role'];
    $np[':deptId'] = $_GET['deptId'];
    
    $stmt=$conn->prepare($sql);
    $stmt->execute($np);
    
    echo "User Was Added!";
    
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Admin: Add new user</title>
    </head>
    <body>


            <h1> Adding New User </h1>

            <h2> Tech Checkout System: Adding a New User </h2>
    
            <form method="GET">
                First Name:<input type="text" name="firstName" />
                <br />
                Last Name:<input type="text" name="lastName"/>
                <br/>
                Email: <input type= "email" name ="email"/>
                <br/>
                Phone Number: <input type ="text" name= "phone"/>
                <br />
               Role: 
               <select name="role">
                    <option value=""> - Select One - </option>
                    <option value="staff">Staff</option>
                    <option value="student">Student</option>
                    <option value="faculty">Faculty</option>
                </select>
                <br />
                Department: 
                <select name="deptId">
                    <option value="" > Select One </option>
                    
                    <?php
                    
                    $departments = departmentList();
                    
                    foreach($departments as $department) {
                       echo "<option value='".$department['id']."'> " . $department['name']  . "</option>";  
                    }
                    
                    
                    ?>
                    
                </select>
                <input type="submit" value="Add User" name="addUser">
            </form>

    </body>
</html>