<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
</head>

<body>

    <body style="font-size: 20px">

        <?php require_once 'master_page.php'; ?>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="input-group mb-3">
                        <input type="search" class="form-control" placeholder="Buscar..." id="search-input">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="search-button">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-white mb-3">
                <div class="card-header"><b>INVENTARIO</b></div>
                <?php
                require_once 'conexion.php';

                $query = $cnnPDO->prepare('SELECT * FROM usuarios');
                $query->execute();
                $count = $query->rowCount();

                if ($count) {
                    echo "<table class='table table-bordered' id='search-table'>";
                    echo "<thead class='thead-dark'>
            <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Nombre</th>
                <th scope='col'>Correo</th>
                <th scope='col'>Rol</th>
            </tr>
          </thead>";
                    echo "<tbody>";

                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                <td>" . $row['id_usuario'] . "</td>
                <td>" . $row['nombre'] . "</td>
                <td>" . $row['correo_electronico'] . "</td>
                <td>" . $row['roles'] . "</td>
              </tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                }
                ?>
            </div>

            <div class="col-12"></div>
        </div>

        <script>
            document.getElementById("search-button").addEventListener("click", function () {
                var input = document.getElementById("search-input").value.toLowerCase();
                var table = document.getElementById("search-table");
                var rows = table.getElementsByTagName("tr");

                for (var i = 0; i < rows.length; i++) {
                    var cells = rows[i].getElementsByTagName("td");
                    var found = false;

                    for (var j = 0; j < cells.length; j++) {
                        var cellValue = cells[j].textContent || cells[j].innerText;

                        if (cellValue.toLowerCase().indexOf(input) > -1) {
                            found = true;
                            break;
                        }
                    }

                    if (found) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            });
        </script>
    </body>

</body>

</html>