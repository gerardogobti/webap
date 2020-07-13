<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $title = $description = $active = $type = $father = $image = "";
$name_err = $title_err = $description_err = $active_err = $type_err = $father_err = $image_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese una fecha de registro.";     
    } else{
        $name = $input_name;
    }
    
    // Validate registration date
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Por favor ingrese una fecha de registro.";     
    } else{
        $title = $input_title;
    }

     
    // Validate description
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Por favor ingrese una description de la noticia.";     
    } else{
        $description = $input_description;
    }

    // Validate active
    $input_active = trim($_POST["active"]);
    if(empty($input_active)){
        $active_err = "Por favor ingrese un estado de noticia.";     
    } else{
        $active = $input_active;
    }

    // Validate user
    $input_type = trim($_POST["type"]);
    if(empty($input_type)){
        $type_err = "Por favor ingrese un usuario.";     
    } else{
        $type = $input_type;
    }

    // Validate publicationdate
    $input_father = trim($_POST["father"]);
    if(empty($input_father)){
        $father_err = "Por favor ingrese una fecha de publicacion.";     
    } else{
        $father = $input_father;
    }
  
    // Validate image
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Por favor ingrese una imagen.";     
    } else{
        $image = $input_image;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($title_err) && empty($description_err) && empty($active_err) && empty($type_err) && empty($father_err) && empty($image_err)){
        // Prepare an update statement
        $sql = "UPDATE aboutus SET name=?, title=?, description=?, active=?, type=?, father=?, image=? 
        WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_name, $param_title, $param_description, 
                $param_active, $param_type, $param_father, $param_image, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_title = $title;
            $param_description = $description;
            $param_active = $active;
            $param_type = $type;
            $param_father = $father;
            $param_image = $image;
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
        $sql = "SELECT * FROM aboutus WHERE id = ?";
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
                    $title = $row["title"];
                    $description = $row["description"];
                    $active = $row["active"];
                    $type = $row["type"];
                    $father = $row["father"];
                    $image = $row["image"];
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
    <title>Actualizar Datos</title>
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
                        <h2>Actualizar Datos</h2>
                    </div>
                    <p>Edite los datos de entrada y envíe para actualizar el registro de usuarios.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                            <label>Estado de la Informacion:</label>
                            <input type="text" name="active" class="form-control" value="<?php echo $active; ?>">
                            <span class="help-block"><?php echo $active_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($type_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de Informacion</label>
                            <input type="text" name="type" class="form-control" value="<?php echo $type; ?>">
                            <span class="help-block"><?php echo $type_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($father_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de publicacion:</label>
                            <input type="text" name="father" class="form-control" value="<?php echo $father; ?>">
                            <span class="help-block"><?php echo $father_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Imagen:</label>
                            <input type="text" name="image" class="form-control" value="<?php echo $image; ?>">
                            <span class="help-block"><?php echo $image_err;?></span>
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