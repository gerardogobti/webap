<?php
// Incluimos nuestro archivo config 
require_once "config.php";
 
// Definimos las variables a utilizar 
$name = $lastname = $email = $phone = $usertype = $user = $password = "";
$name_err = $lastname_err = $email_err = $phone_err = $usertype_err = $user_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validando el campo Nombre(s) 
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese el nombre del usuario.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Por favor ingrese un nombre válido.";
    } else{
        $name = $input_name;
    }
    
    // Validando el campo Apellido(s)
    $input_lastname = trim($_POST["lastname"]);
    if(empty($input_lastname)){
        $lastname_err = "Por favor ingrese un apellido.";     
    } else{
        $lastname = $input_lastname;
    }

    // Validando el campo Email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Por favor ingrese un correo electronico.";     
    } else{
        $email = $input_email;
    }

    // Validando el campo Telefono
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Por favor ingrese un numero telefonico.";     
    } else{
        $phone = $input_phone;
    }

    // Validando el campo Tipo de Usuario
    $input_usertype = trim($_POST["usertype"]);
    if(empty($input_usertype)){
        $usertype_err = "Por favor ingrese un tipo de usuario.";     
    } else{
        $usertype = $input_usertype;
    }


    // Validar el campo Usuario
    $input_user = trim($_POST["user"]);
    if(empty($input_user)){
        $user_err = "Por favor ingrese un usuario.";     
    } else{
        $user = $input_user;
    }

    // Validando el campo Password
    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Por favor ingrese una contraseña de usuario.";     
    } else{
        $password = $input_password;
    }
        
    // Check input errors before inserting in database
    if(empty($name_err) && empty($lastname_err) && empty($email_err) && empty($phone_err) && empty($usertype_err) && empty($user_err) && empty($password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO user (name, lastname, email, phone, usertype, user, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_lastname, $param_email, $param_phone, $param_usertype, $param_user, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_phone = $phone;
            $param_usertype = $usertype;
            $param_user = $user;
            $param_password = $password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Algo salio mal. Intentelo mas tarde.";
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
    <title>Agregar Empleado</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Agregar Usuario</h2>
                    </div>
                    <p>Favor de llenar el siguiente formulario, para agregar el usuario.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre(s):</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                            <label>Apellido(s):</label>
                            <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                            <span class="help-block"><?php echo $lastname_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Correo:</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Telefono:</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                            <span class="help-block"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($usertype_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de Usuario:</label>
                            <input type="text" name="usertype" class="form-control" value="<?php echo $usertype; ?>">
                            <span class="help-block"><?php echo $usertype_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($user_err)) ? 'has-error' : ''; ?>">
                            <label>Usuario:</label>
                            <input type="text" name="user" class="form-control" value="<?php echo $user; ?>">
                            <span class="help-block"><?php echo $user_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Contraseña:</label>
                            <input type="text" name="password" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Agregar" >
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>