<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $role = $administrator = "";
$name_err = $role_err = $administrator_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate role
    $input_role = trim($_POST["role"]);
    if(empty($input_role)){
        $role_err = "Please enter a role.";     
    } else{
        $role = $input_role;
    }
    
    // Validate administrator
    $input_administrator = trim($_POST["administrator"]);
    if(empty($input_administrator)){
        $administrator_err = "Please enter the name of administrator.";     
    } elseif(!filter_var($input_administrator, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $administrator_err = "Please enter a valid administrator name.";
    } else{
        $administrator = $input_administrator;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($role_err) && empty($administrator_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO roleadministrator1 (name, role, administrator) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_role, $param_administrator);
            
            // Set parameters
            $param_name = $name;
            $param_role = $role;
            $param_administrator = $administrator;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" name="role" class="form-control <?php echo (!empty($role_err)) ? 'is-invalid' : ''; ?>"><?php echo $role; ?></input>
                            <span class="invalid-feedback"><?php echo $role_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Administrator</label>
                            <input type="text" name="administrator" class="form-control <?php echo (!empty($administrator_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $administrator; ?>">
                            <span class="invalid-feedback"><?php echo $administrator_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>