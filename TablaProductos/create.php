<?php
// Incluimos nuestro archivo config 
require_once "config.php";
 
// Definimos las variables a utilizar 
$name = $category = $description = $price = $image = "";
$name_err = $category_err = $description_err = $price_err = $image_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


    // Validando el campo titulo
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Por favor ingrese un nombre para el producto.";     
    } else{
        $name = $input_name;
    }

    // Validando el campo de la descripcion
    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        $category_err = "Por favor ingrese una categoria para el producto.";     
    } else{
        $category = $input_category;
    }

    // Validando el campo de Imagen
    $input_description = trim($_POST["description"]);
    if(empty($input_description)){
        $description_err = "Por favor ingrese una descripcion acerca del producto.";     
    } else{
        $description = $input_description;
    }

    // Validando el campo costo del producto o servicio
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Por favor ingrese el costo del producto o servicio.";     
    } else{
        $price = $input_price;
    }


    // Validar el campo usuario
    $input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Por favor ingrese el usuario.";     
    } else{
        $image = $input_image;
    }

      

    // Check input errors before inserting in database
    if(empty($name_err) && empty($category_err) && empty($description_err) 
        && empty($price_err) && empty($image_err) ){
        // Prepare an insert statement
        $sql = "INSERT INTO products (name, category, descripcion, price, image) 
        VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_category, $param_description, 
                $param_price, $param_image);
            
            // Set parameters
            $param_name = $name;
            $param_category = $category;
            $param_description = $description;
            $param_price = $price;
            $param_image = $image;
            
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Algo salio mal. Intentelo mas tarde.";
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
    <title>Agregar Productos</title>
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
                        <h3>Agregar Productos al SistemaAP</h3>
                    </div>
                    <p>Favor de llenar el siguiente formulario, para agregar los productos.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label>Nombre del Producto:</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        
                        <div class="form-group <?php echo (!empty($category_err)) ? 'has-error' : ''; ?>">
                        <label>Categoria del Producto:</label>
                        <input type="text" name="category" class="form-control" value="<?php echo $category; ?>">
                        <span class="help-block"><?php echo $category_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                        <label>Descripcion del Producto:</label>
                        <input type="text" name="description" class="form-control" value="<?php echo $description; ?>">
                        <span class="help-block"><?php echo $description_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                            <label>Precio del Producto:</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                            <span class="help-block"><?php echo $price_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                            <label>Imagen del Producto:</label>
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

