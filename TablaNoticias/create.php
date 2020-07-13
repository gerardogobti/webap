<?php
// Incluimos nuestro archivo config 
require_once "config.php";
 
// Definimos las variables a utilizar 
$title = $registrationdate = $description = $image = $active = $user = $publicationdate = "";
$title_err = $registrationdate_err = $description_err = $image_err = $active_err = 
$user_err = $publicationdate_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validando el campo Nombre(s) 
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Por favor ingrese el titulo de la Noticia.";
    } elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $title_err = "Por favor ingrese un nombre valido para la noticia.";
    } else{
        $title = $input_title;
    }
    
    // Validando el campo de la fecha de registro
    $input_registrationdate = trim($_POST["registrationdate"]);
    if(empty($input_registrationdate)){
        $registrationdate_err = "Por favor ingrese una fecha de registro.";     
    } else{
        $registrationdate = $input_registrationdate;
    }

    // Validando el campo descripcion
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Por favor ingrese una descripcion de noticia.";     
    } else{
        $description = $input_description;
    }

    // Validando el campo de Imagen
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Por favor ingrese una imagen.";     
    } else{
        $image = $input_image;
    }

    // Validando el campo noticia activa o inactiva 
    $input_active = trim($_POST["active"]);
    if(empty($input_active)){
        $active_err = "Por favor ingrese el estado actual de la noticia.";     
    } else{
        $active = $input_active;
    }


    // Validar el campo Usuario
    $input_user = trim($_POST["user"]);
    if(empty($input_user)){
        $user_err = "Por favor ingrese un usuario.";     
    } else{
        $user = $input_user;
    }

    // Validando el campo Fecha de publicacion
    $input_publicationdate = trim($_POST["publicationdate"]);
    if(empty($input_publicationdate)){
        $publicationdate_err = "Por favor ingrese una fecha de publicacion.";     
    } else{
        $publicationdate = $input_publicationdate;
    }

    

    // Check input errors before inserting in database
    if(empty($title_err) && empty($registrationdate_err) && empty($description_err) && empty($image_err) && empty($active_err) && empty($user_err) && empty($publicationdate_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO notice (title, registrationdate, description, image, active, user, publicationdate) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_title, $param_registrationdate, $param_description, $param_image, $param_active, $param_user, $param_publicationdate);
            
            // Set parameters
            $param_title = $title;
            $param_registrationdate = $registrationdate;
            $param_description = $description;
            $param_image = $image;
            $param_active = $active;
            $param_user = $user;
            $param_publicationdate = $publicationdate;
            
            
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
                        <h3>Agregar Noticias al SistemaAP</h3>
                    </div>
                    <p>Favor de llenar el siguiente formulario, para agregar las noticias.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($title_err)) ? 'has-error' : ''; ?>">
                            <label>Titulo:</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                            <span class="help-block"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($registrationdate_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Registro:</label>
                            <input type="text" name="registrationdate" class="form-control" value="<?php echo $registrationdate; ?>">
                            <span class="help-block"><?php echo $registrationdate_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                            <label>Descripcion:</label>
                            <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                            <span class="help-block"><?php echo $description_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Image:</label>
                            <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                            <span class="help-block"><?php echo $image_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($active_err)) ? 'has-error' : ''; ?>">
                            <label>Estado de la Noticia:</label>
                            <input type="text" name="active" class="form-control" value="<?php echo $active; ?>">
                            <span class="help-block"><?php echo $active_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($user_err)) ? 'has-error' : ''; ?>">
                            <label>Usuario:</label>
                            <input type="text" name="user" class="form-control" value="<?php echo $user; ?>">
                            <span class="help-block"><?php echo $user_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($publicationdate_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Publicacion:</label>
                            <input type="text" name="publicationdate" class="form-control" value="<?php echo $publicationdate; ?>">
                            <span class="help-block"><?php echo $publicationdate_err;?></span>
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