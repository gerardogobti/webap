<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $ubication = $managerduty = $activestation = $pricemagna = $pricepremium = $pricedisel = "";
$name_err = $ubication_err = $managerduty_err = $activestation_err = $pricemagna_err = $pricepremium_err = $pricedisel_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validando el registro de nmombre
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese un nombre de estacion.";     
    } else{
        $name = $input_name;
    }

    // Validando ubicacion
    $input_ubication = trim($_POST["ubication"]);
    if(empty($input_ubication)){
        $ubication_err = "Por favor ingrese una ubicacion de la estacion.";     
    } else{
        $ubication = $input_ubication;
    }

     
    // Validando gerente en turno
    $input_managerduty = trim($_POST["managerduty"]);
    if(empty($input_managerduty)){
        $managerduty_err = "Por favor ingrese un gerente en turno actual.";     
    } else{
        $managerduty = $input_managerduty;
    }

    // Validando estado actual de la estacion
    $input_activestation = trim($_POST["activestation"]);
    if(empty($input_activestation)){
        $activestation_err = "Por favor ingrese un estado actual de la estacion.";     
    } else{
        $activestation = $input_activestation;
    }

    // Validando precio gasolina magna 
    $input_pricemagna = trim($_POST["pricemagna"]);
    if(empty($input_pricemagna)){
        $pricemagna_err = "Por favor ingrese un precio de la gasolina magna.";     
    } else{
        $pricemagna = $input_pricemagna;
    }

    // Validando costo gasolina premium 
    $input_pricepremium = trim($_POST["pricepremium"]);
    if(empty($input_pricepremium)){
        $pricepremium_err = "Por favor ingrese un costo de la gasolina premium.";     
    } else{
        $pricepremium = $input_pricepremium;
    }

    // Validando costo disel 
    $input_pricedisel = trim($_POST["pricedisel"]);
    if(empty($input_pricedisel)){
        $pricedisel_err = "Por favor ingrese un costo del disel.";     
    } else{
        $pricedisel = $input_pricedisel;
    }
  
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($ubication_err) && empty($managerduty_err) && empty($activestation_err) && empty($pricemagna_err) && empty($pricepremium_err) && empty($pricedisel_err)){
        // Prepare an update statement
        $sql = "UPDATE station SET name=?, ubication=?, managerduty=?, activestation=?, pricemagna=?, 
        pricepremium=?, pricedisel=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_name, $param_ubication, $param_managerduty, 
                $param_activestation, $param_pricemagna, $param_pricepremium, $param_pricedisel, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_ubication = $ubication;
            $param_managerduty = $managerduty;
            $param_activestation = $activestation;
            $param_pricemagna = $pricemagna;
            $param_pricepremium = $pricepremium;
            $param_pricedisel = $pricedisel;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Ocurrio un error. Intentelo mas tarde.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM station WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $ubication = $row["ubication"];
                    $managerduty = $row["managerduty"];
                    $activestation = $row["activestation"];
                    $pricemagna = $row["pricemagna"];
                    $pricepremium = $row["pricepremium"];
                    $pricedisel = $row["pricedisel"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Ocurrio un error. Porfavor intentelo mas tarde.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Datos de la Estacion</title>
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
                        <h2>Actualizar Datos de la Estacion</h2>
                    </div>
                    <p>Edite los datos de entrada y envíe para actualizar el registro de usuarios.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ubication_err)) ? 'has-error' : ''; ?>">
                            <label>Ubicacion:</label>
                            <input type="text" name="ubication" class="form-control" value="<?php echo $ubication; ?>">
                            <span class="help-block"><?php echo $ubication_err;?></span>
                        </div>
                       <div class="form-group <?php echo (!empty($managerduty_err)) ? 'has-error' : ''; ?>">
                            <label>Gerente en Turno Actual:</label>
                            <textarea name="managerduty" class="form-control"><?php echo $managerduty; ?></textarea>
                            <span class="help-block"><?php echo $managerduty_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($activestation_err)) ? 'has-error' : ''; ?>">
                            <label>Estado actual de la Estacion:</label>
                            <input type="text" name="activestation" class="form-control" value="<?php echo $activestation; ?>">
                            <span class="help-block"><?php echo $activestation_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pricemagna_err)) ? 'has-error' : ''; ?>">
                            <label>Precio de la Gasolina Magna:</label>
                            <input type="text" name="pricemagna" class="form-control" value="<?php echo $pricemagna; ?>">
                            <span class="help-block"><?php echo $pricemagna_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pricepremium_err)) ? 'has-error' : ''; ?>">
                            <label>Precio Gasolina Premium</label>
                            <input type="text" name="pricepremium" class="form-control" value="<?php echo $pricepremium; ?>">
                            <span class="help-block"><?php echo $pricepremium_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pricedisel_err)) ? 'has-error' : ''; ?>">
                            <label>Costo del Disel:</label>
                            <input type="text" name="pricedisel" class="form-control" value="<?php echo $pricedisel; ?>">
                            <span class="help-block"><?php echo $pricedisel_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>