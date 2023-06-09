<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //Inicio de recupera variable por el url
    //$variableDeUrl = "";
    //if (isset($_GET["variable"])){
    //  $variableDeUrl = $_GET["variable"];
    //}
    //echo "El valor de la variable de la url es " . $variableDeUrl;
    //Final de recuperar variable por el URL

    //abrir la conexion a la base de datos
    //pdo lo que hace es interctuar con base de datos
    $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
    $conexion = new PDO('mysql:host=localhost;dbname=prueba01', 'root', '', $pdo_options);

    if (isset($_POST["accion"])){
        //echo "Quieres " . $_POST["accion"];
        if  ($_POST["accion"] == "Crear"){
            $insert = $conexion->prepare("INSERT INTO alumno (carnet,nombre,dpi,direccion) VALUES
            (:carnet,:nombre,:dpi,:direccion)");
            $insert->bindValue('carnet', $_POST['carnet']);
            $insert->bindValue('nombre', $_POST['nombre']);
            $insert->bindValue('dpi', $_POST['dpi']);
            $insert->bindValue('direccion', $_POST['direccion']);
            $insert->execute();

         }
            if  ($_POST["accion"] == "Editado"){
                $update = $conexion->prepare("UPDATE alumno SET nombre=:nombre, dpi=:dpi, 
                direccion=:direccion WHERE carnet=:carnet ");
                $update->bindValue('carnet', $_POST['carnet']);
                $update->bindValue('nombre', $_POST['nombre']);
                $update->bindValue('dpi', $_POST['dpi']);
                $update->bindValue('direccion', $_POST['direccion']);
                $update->execute();
                header("Refresh: 0");
            }
        }

    

    //Ejecutamos la consulta
    $select = $conexion->query("SELECT carnet, nombre, dpi, direccion FROM alumno");

    ?> 
    
    <?php if (isset($_POST["accion"]) && $_POST["accion"] == "Editar"  ) { ?>
        <form method="POST">
            <input type="text" name="carnet" value="<?php echo $_POST["carnet"] ?>" placeholder="Ingresa el carnet"/>
            <input type="text" name="nombre" placeholder="Ingresa el nombre"/>
            <input type="text" name="dpi" placeholder="Ingresa el dpi"/>
            <input type="text" name="direccion" placeholder="Ingresa la direccion"/>
            <input type="hidden" name="accion" value="Editado"/>
            <button type="submit">Guardar</button>
        </form>
    <?php }else { ?>
        <form method="POST">
            <input type="text" name="carnet" placeholder="Ingresa el carnet"/>
            <input type="text" name="nombre" placeholder="Ingresa el nombre"/>
            <input type="text" name="dpi" placeholder="Ingresa el dpi"/>
            <input type="text" name="direccion" placeholder="Ingresa la direccion"/>
            <input type="hidden" name="accion" value="Crear"/>
            <button type="submit">Crear</button>
        </form>
    <?php } ?>

    <table border="1">
        <thead>
            <tr>
                <th>Carnet</th>
                <th>Nompre</th>
                <th>DPI</th>
                <th>Direccion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach($select->fetchAll() as $alumno) { ?>
                <tr>
                    <td> <?php echo $alumno["carnet"] ?> </td>
                    <td> <?php echo $alumno["nombre"] ?> </td>
                    <td> <?php echo $alumno["dpi"] ?> </td>
                    <td> <?php echo $alumno["direccion"] ?> </td>
                    <td> <form method="POST">
                        <button type="submit">Editar</button>
                        <input type="hidden" name="accion" value="Editar"/>
                        <input type="hidden" name="carnet" value="<?php echo $alumno["carnet"] ?>"/>
                    </form> 
                </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>