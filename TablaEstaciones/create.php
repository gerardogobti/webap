<?php
// Incluimos nuestro archivo config 
require_once "config.php";
 
// Definimos las variables a utilizar 
$name = $ubication = $managerduty = $activestation = $pricemagna = $pricepremium = $pricedisel = "";
$name_err = $ubication_err = $managerduty_err = $activestation_err = $pricemagna_err = 
$pricepremium_err = $pricedisel_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


    // Validando el campo Nombre
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese un nombre para la estacion.";     
    } else{
        $name = $input_name;
    }

    // Validando el campo de la ubicacion
    $input_ubication = trim($_POST["ubication"]);
    if(empty($input_ubication)){
        $ubication_err = "Por favor ingrese una ubicacion.";     
    } else{
        $ubication = $input_ubication;
    }

    // Validando el campo gerente en turno
    $input_managerduty = trim($_POST["managerduty"]);
    if(empty($input_managerduty)){
        $managerduty_err = "Por favor ingrese un gerente de turno.";     
    } else{
        $managerduty = $input_managerduty;
    }

    // Validando el campo de Estacion activa
    $input_activestation = trim($_POST["activestation"]);
    if(empty($input_activestation)){
        $activestation_err = "Por favor ingrese el estado actual de la estacion.";     
    } else{
        $activestation = $input_activestation;
    }

    // Validando el campo costo de gasolina magna 
    $input_pricemagna = trim($_POST["pricemagna"]);
    if(empty($input_pricemagna)){
        $pricemagna_err = "Por favor ingrese el costo actual de la gasolina magna.";     
    } else{
        $pricemagna = $input_pricemagna;
    }


    // Validar el campo costo de gasolina premium
    $input_pricepremium = trim($_POST["pricepremium"]);
    if(empty($input_pricepremium)){
        $pricepremium_err = "Por favor ingrese el costo actual de la gasolina premium.";     
    } else{
        $pricepremium = $input_pricepremium;
    }

    // Validando el campo costo del disel
    $input_pricedisel = trim($_POST["pricedisel"]);
    if(empty($input_pricedisel)){
        $pricedisel_err = "Por favor ingrese el costo actual del disel.";     
    } else{
        $pricedisel = $input_pricedisel;
    }

    

    // Check input errors before inserting in database
    if(empty($name_err) && empty($ubication_err) && empty($managerduty_err) && empty($activestation_err) && empty($pricemagna_err) && empty($pricepremium_err) && empty($pricedisel_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO station (name, ubication, managerduty, activestation, pricemagna, pricepremium, pricedisel) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_ubication, $param_managerduty, $param_activestation, $param_pricemagna, $param_pricepremium, $param_pricedisel);
            
            // Set parameters
            $param_name = $name;
            $param_ubication = $ubication;
            $param_managerduty = $managerduty;
            $param_activestation = $activestation;
            $param_pricemagna = $pricemagna;
            $param_pricepremium = $pricepremium;
            $param_pricedisel = $pricedisel;
            
            
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
    <title>Agregar Noticias</title>
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
                        <h3>Agregar Estaciones al SistemaAP</h3>
                    </div>
                    <p>Favor de llenar el siguiente formulario, para agregar las estaciones de gasolina.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                            <label>Gerente en Turno:</label>
                            <textarea name="managerduty" class="form-control"><?php echo $managerduty; ?></textarea>
                            <span class="help-block"><?php echo $managerduty_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($activestation_err)) ? 'has-error' : ''; ?>">
                            <label>Estado de la Estacion:</label>
                            <input type="text" name="activestation" class="form-control" value="<?php echo $activestation; ?>">
                            <span class="help-block"><?php echo $activestation_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pricemagna_err)) ? 'has-error' : ''; ?>">
                            <label>Precio de la Gasolina Magna:</label>
                            <input type="text" name="pricemagna" class="form-control" value="<?php echo $pricemagna; ?>">
                            <span class="help-block"><?php echo $pricemagna_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pricepremium_err)) ? 'has-error' : ''; ?>">
                            <label>Precio de la Gasolina Premium:</label>
                            <input type="text" name="pricepremium" class="form-control" value="<?php echo $pricepremium; ?>">
                            <span class="help-block"><?php echo $pricepremium_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pricedisel_err)) ? 'has-error' : ''; ?>">
                            <label>Precio del Disel:</label>
                            <input type="text" name="pricedisel" class="form-control" value="<?php echo $pricedisel; ?>">
                            <span class="help-block"><?php echo $pricedisel_err;?></span>
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