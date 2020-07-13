<?php
// Incluimos nuestro archivo config 
require_once "config.php";
 
// Definimos las variables a utilizar 
$name = $title = $description = $active = $type = $father = $image = "";
$name_err = $title_err = $description_err = $active_err = $type_err = 
$father_err = $image_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validando el campo de la fecha de registro
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese una fecha de registro.";     
    } else{
        $name = $input_name;
    }
    
    // Validando el campo de la fecha de registro
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Por favor ingrese una fecha de registro.";     
    } else{
        $title = $input_title;
    }

    // Validando el campo descripcion
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Por favor ingrese una descripcion de noticia.";     
    } else{
        $description = $input_description;
    }

    // Validando el campo noticia activa o inactiva 
    $input_active = trim($_POST["active"]);
    if(empty($input_active)){
        $active_err = "Por favor ingrese el estado actual de la noticia.";     
    } else{
        $active = $input_active;
    }


    // Validar el campo Usuario
    $input_type = trim($_POST["type"]);
    if(empty($input_type)){
        $type_err = "Por favor ingrese un usuario.";     
    } else{
        $type = $input_type;
    }

    // Validando el campo Fecha de publicacion
    $input_father = trim($_POST["father"]);
    if(empty($input_father)){
        $father_err = "Por favor ingrese una fecha de publicacion.";     
    } else{
        $father = $input_father;
    }

    // Validando el campo de Imagen
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Por favor ingrese una imagen.";     
    } else{
        $image = $input_image;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($title_err) && empty($description_err) && empty($active_err) 
        && empty($type_err) && empty($father_err) && empty($image_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO aboutus (name, title, description, active, type, father, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_name, $param_title, $param_description, $param_active, $param_type, $param_father, $param_image);
            
            // Set parameters
            $param_name = $name;
            $param_title = $title;
            $param_description = $description;
            $param_active = $active;
            $param_type = $type;
            $param_father = $father;
            $param_image = $image;
            
            
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
                        <h3>Agregar Informacion de la Empresa AP</h3>
                    </div>
                    <p>Favor de llenar el siguiente formulario, para agregar las noticias.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                            <label>Titulo:</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                            <span class="help-block"><?php echo $title_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Descripcion:</label>
                            <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($active_err)) ? 'has-error' : ''; ?>">
                            <label>Estado Actual:</label>
                            <input type="text" name="active" class="form-control" value="<?php echo $active; ?>">
                            <span class="help-block"><?php echo $active_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de publicacion:</label>
                            <input type="text" name="type" class="form-control" value="<?php echo $type; ?>">
                            <span class="help-block"><?php echo $type_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($father_err)) ? 'has-error' : ''; ?>">
                            <label>Seccion:</label>
                            <input type="text" name="father" class="form-control" value="<?php echo $father; ?>">
                            <span class="help-block"><?php echo $father_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Imagen:</label>
                            <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                            <span class="help-block"><?php echo $image_err;?></span>
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