<!DOCTYPE html>
<html>

<head>
  <title>Tablas de Medidas</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    h2 {
      background-color: #666;
      color: white;
      padding: 10px;
      margin: 20px 0;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      background-color: white;
      border: 1px solid #ddd;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <?php require_once 'master_page.php'; ?>
  <div class="center-table">
    <h2>Medidas para Sacos</h2>
    <table>
      <tr>
        <th>Talla</th>
        <th>Pecho (cm)</th>
        <th>Cintura (cm)</th>
        <th>Cadera (cm)</th>
        <th>Largo de Manga (cm)</th>
      </tr>
      <tr>
        <td>S</td>
        <td>91-96</td>
        <td>76-81</td>
        <td>91-96</td>
        <td>60-62</td>
      </tr>
      <!-- Resto de las filas... -->
    </table>

    <h2>Medidas para Camisas</h2>
    <table>
      <tr>
        <th>Talla</th>
        <th>Pecho (cm)</th>
        <th>Cintura (cm)</th>
        <th>Largo de Manga (cm)</th>
        <th>Largo de Camisa (cm)</th>
      </tr>
      <tr>
        <td>S</td>
        <td>91-96</td>
        <td>76-81</td>
        <td>61-63</td>
        <td>71-73</td>
      </tr>
      <!-- Resto de las filas... -->
    </table>

    <h2>Medidas para Pantalones</h2>
    <table>
      <tr>
        <th>Talla</th>
        <th>Cintura (cm)</th>
        <th>Cadera (cm)</th>
        <th>Largo de Entrepierna (cm)</th>
      </tr>
      <tr>
        <td>S</td>
        <td>76-81</td>
        <td>91-96</td>
        <td>76-78</td>
      </tr>
      <!-- Resto de las filas... -->
    </table>

    <h2>Medidas para Chalecos</h2>
    <table>
      <tr>
        <th>Talla</th>
        <th>Pecho (cm)</th>
        <th>Cintura (cm)</th>
        <th>Largo (cm)</th>
      </tr>
      <tr>
        <td>S</td>
        <td>91-96</td>
        <td>76-81</td>
        <td>53-55</td>
      </tr>
      <!-- Resto de las filas... -->
    </table>
</body>

</html>