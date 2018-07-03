<?php
include './../inc/masterpage-frontend/header.php';
include './../inc/connection.php';

$userId = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['inputFiles'])) {
        foreach ($_FILES['inputFiles']['name'] as $file => $name) {
            $path = date('dmY-His' . time()) . mt_rand() . '-' . $name;

            try {
                if (move_uploaded_file($_FILES['inputFiles']['tmp_name'][$file], './../uploads/' . $path)) {
                    //TODO: change sql column name from Path to filename
                    // TODO: add filename coll
                    $sqlFiles = "INSERT INTO `upload` (`UserId`,`FileName`,`Path`) VALUES ($userId,'$name','$path')";

                    $conn->query($sqlFiles);

                }
            } catch (Exception $e) {
                echo $e;
            }
        }
    }

}
if (isset($_GET['id'])) {
    // if (unlink('./../uploads/' . $_GET['name'])) {
    $sqlTableFiles = "UPDATE `upload` SET `Active` = 0 WHERE `UploadId` = '" . $_GET['id'] . "'";
    $resultTableFiles = $conn->query($sqlTableFiles);

    header('Location: index.php');
    // }
}

$sqlTableFiles = "SELECT `UploadId`, `FileName` , `Path` FROM `upload` WHERE `Active` = 1";
$resultTableFiles = $conn->query($sqlTableFiles);

$conn->close();
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="inputFiles[]" multiple>
    <input type="submit" value="Upload">
</form>

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Ficheiro</th>
            <th>Acção</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($rowTableFiles = $resultTableFiles->fetch_assoc()): ?>
            <tr>
                <td><?php echo $rowTableFiles['FileName'] ?></td>
                <td>
                    <a href="?name=<?php echo $rowTableFiles['Path']; ?>&id=<?php echo $rowTableFiles['UploadId'] ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
        <?php endwhile;?>
    </tbody>
</table>

<?php include './../inc/masterpage-frontend/footer.php'?>