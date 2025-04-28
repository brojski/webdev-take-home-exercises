<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Manage Contact</title>
  <style>
    .form-group {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }

    .form-group label {
      width: 150px;
      text-align: right;
      margin-right: 10px;
    }

    #studno {
      width: 200px;
    }

    #name {
      width: 300px;
    }

    .form-group #cpno {
      margin-top: -10px;
      width: 140px;
    }

    .form-group input[type="submit"] {
      max-width: 100px;
      padding: 5px 10px;
      margin-left: 160px;
    }

    .hidden {
      display: none;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table,
    th,
    td {
      border: 1px solid black;
    }

    th,
    td {
      padding: 10px;
      text-align: left;
    }
  </style>
  <script>
    function toggleFormFields() {
      const action = document.getElementById("action").value;
      const formFields = document.getElementById("form-fields");
      if (action === "add" || action === "update" || action === "delete") {
        formFields.classList.remove("hidden");
      } else {
        formFields.classList.add("hidden");
      }
    }

    function handleFormSubmission(event) {
      event.preventDefault(); // Prevent the form from submitting to the server

      const studno = document.getElementById("studno").value;
      const name = document.getElementById("name").value;
      const cpno = document.getElementById("cpno").value;

      const table = document.getElementById("data-table");
      const newRow = table.insertRow();

      const studnoCell = newRow.insertCell(0);
      const nameCell = newRow.insertCell(1);
      const cpnoCell = newRow.insertCell(2);

      studnoCell.textContent = studno;
      nameCell.textContent = name;
      cpnoCell.textContent = cpno;

      // Clear the form fields after submission
      document.getElementById("studno").value = "";
      document.getElementById("name").value = "";
      document.getElementById("cpno").value = "";
    }
  </script>
</head>

<body>
  <form onsubmit="handleFormSubmission(event)">
    <div class="form-group">
      <label for="action">Action:</label>
      <select
        id="action"
        name="action"
        onchange="toggleFormFields()"
        required>
        <option value="">Select an action</option>
        <option value="add">Add Record</option>
        <option value="update">Update Record</option>
        <option value="delete">Delete Record</option>
      </select>
    </div>

    <div id="form-fields" class="hidden">
      <div class="form-group">
        <label for="studno">Student Number:</label>
        <input type="text" id="studno" name="studno" required />
      </div>

      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />
      </div>

      <div class="form-group">
        <label for="cpno">Cellphone Number:</label>
        <input type="text" id="cpno" name="cpno" required />
        <p><em>(ex. 09123456789)</em></p>
      </div>
    </div>

    <div class="form-group">
      <input type="submit" value="Submit" />
    </div>
  </form>

  <table id="data-table">
    <thead>
      <tr>
        <th>Student Number</th>
        <th>Name</th>
        <th>Cellphone Number</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Database connection details
      $servername = "sql304.infinityfree.com";
      $username = "if0_38844347";
      $password = "xAdT8UwyR8";
      $dbname = "if0_38844347_dbcontacts";

      // Connect to the database
      $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Fetch data from the database
      $sql = "SELECT studno, name, cpno FROM tblSMS";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row["studno"]) . "</td>";
          echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
          echo "<td>" . htmlspecialchars($row["cpno"]) . "</td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='3'>No records found</td></tr>";
      }

      $conn->close();
      ?>
    </tbody>
  </table>
</body>

</html>
