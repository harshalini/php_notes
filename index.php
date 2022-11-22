<?php 
$server = "localhost";
$username = "root";
$password = "";
$database = "notes";
$insert = false;
$update = false;
$delete = false;
$conn = mysqli_connect($server, $username, $password, $database);

/*if(!$conn) {
  die("failed to connect".mysqli_connect_error());
}

else echo "successfull";
echo $_SERVER['REQUEST_METHOD'];*/

if(isset($_GET['delete'])) {
  $sno = $_GET['delete'];

  $sql_delete = "DELETE FROM `notes` WHERE `notes`.`n_no` = $sno";
  $res = mysqli_query($conn, $sql_delete);
  if($res) $delete = true;
  //else echo "Not deleted";
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {



if(isset($_POST['sno-edit'])) {
  $n_title_edit = $_POST['n_title_edit'];
$n_desc_edit = $_POST['n_desc_edit'];
$sno_edit = $_POST['sno-edit'];

  $sql_update = "UPDATE `notes` SET `n_title` = '$n_title_edit', `n_desc` = '$n_desc_edit' WHERE `notes`.`n_no` = '$sno_edit'";
  $res = mysqli_query($conn, $sql_update);
  if($res) $update = true;
  //else echo "Not updated";

}
else {
  $n_title = $_POST['n_title'];
$n_desc = $_POST['n_desc'];
$sql_insert = "INSERT INTO `notes` (`n_title`, `n_desc`) VALUES ('$n_title', '$n_desc');";
$res = mysqli_query($conn, $sql_insert);
if($res) {$insert = true;}
//else echo "not inserted";
}
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Open Notes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="POST">
            <input type="hidden" id="sno-edit" name="sno-edit">
            <div class="mb-3 mt-3">
              <label for="n_title" class="form-label">Note title</label>
              <input type="text" class="form-control" id="n_title_edit" name="n_title_edit"
                aria-describedby="emailHelp">

            </div>

            <div class="form-floating">
              <textarea class="form-control" placeholder="Leave a comment here" id="n_desc_edit" name="n_desc_edit"
                rows="40"></textarea>
              <label for="n_desc">Note description</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update note</button>
          </form>
        </div>

      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">OpenNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <?php 
      if($insert == true) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role=''alert'>
        <strong>Note added successfully</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"
      ;
      }

      if($delete == true) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role=''alert'>
        <strong>Note deleted successfully</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"
      ;
      }

      if($update == true) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role=''alert'>
        <strong>Note updated successfully</strong>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>"
      ;
      }
      ?>
  <div class="container">

    <form action="index.php" method="POST">

      <div class="mb-3 mt-3">
        <h1>Add a note here!</h1>
        <label for="n_title" class="form-label">Note title</label>
        <input type="text" class="form-control" id="n_title" name="n_title" aria-describedby="emailHelp">

      </div>

      <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="n_desc" name="n_desc"
          rows="40"></textarea>
        <label for="n_desc">Note description</label>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Add note</button>
    </form>
  </div>

  <div class="container">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Update</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php 
       $sql = "SELECT * FROM `notes`";
       $result = mysqli_query($conn, $sql);
       $s_no = 0;
       while($row = mysqli_fetch_assoc($result)) {
        $s_no += 1;
        echo " <tr>
      <th scope='row'>".$s_no."</th>
      <td>".$row['n_title']."</td>
      <td>".$row['n_desc']."</td>
      <td><button class='btn btn-primary update-btn' id=".$row['n_no']." type=''button' data-bs-toggle='modal' data-bs-target='#exampleModal'>"."Yes"."</button></td>".
      "<td><button class='dlt-btn' method='GET' type='submit' id=d".$row['n_no'].">"."Yes"."</button></td>".
      "</tr>
    ";
       }

        ?>
      </tbody>
    </table>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
    integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk"
    crossorigin="anonymous"></script>

  <script>
    const updateBtn = document.querySelectorAll(".update-btn");
    const updateList = [...updateBtn];

    const workingFun = (e) => {
      //console.log("working");
      const par = e.target.parentNode.parentNode;
      const title = par.getElementsByTagName('td')[0].innerText;
      const desc = par.getElementsByTagName('td')[1].innerText;
      //console.log(title);
      const tEdit = document.querySelector("#n_title_edit");
      const dEdit = document.querySelector("#n_desc_edit");
      tEdit.value = title;
      dEdit.value = desc;
      const snoEdit = document.querySelector('#sno-edit');
      snoEdit.value = e.target.id;
      //console.log(snoEdit.value);
    }


    //dltBtn.addEventListener("click", workingFun);
    updateList.forEach(btn => btn.addEventListener("click", workingFun));

    const dltBtn = document.querySelectorAll(".dlt-btn");
    const dltList = [...dltBtn];
    const showConfirm = (e) => {
      let sno = e.target.id.substr(1,);
      if (confirm("Do you want to delete?")) {
        window.location = `/php_notes/index.php?delete=${sno}`;
      }
    }
    dltList.forEach(btn => btn.addEventListener("click", showConfirm));
  </script>
</body>

</html>