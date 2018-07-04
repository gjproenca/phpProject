<?php
include './../inc/masterpage-frontend/header.php';
include './../inc/connection.php';

$userId = $_SESSION['userId'];

// Upload files to folder and perform INSERT query on database
// Max file size 2MB, max files on single post 20
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['inputFile'])) {
        $fileName = $_FILES['inputFile']['name'];
        $path = date('dmY-His' . time()) . mt_rand() . '-' . $fileName;

        if (($_FILES['inputFile']['size'] < 2100000) && ($_FILES['inputFile']['error'] == 0)) {
            try {
                if (move_uploaded_file($_FILES['inputFile']['tmp_name'], './../uploads/' . $path)) {
                    $sqlFiles = "INSERT INTO `upload` (`UserId`,`FileName`,`Path`) 
                                    VALUES ($userId,'$fileName','$path')";

                    $conn->query($sqlFiles);
                }
            } catch (Exception $e) {
                echo $e;
            }
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Não foi possível carregar o ficheiro, tamanho máximo de carregamento 2MB (versão de teste)</div>';
        }
    }
}

// Set active to 0 in databse
if (isset($_GET['uploadId'])) {
    $sqlTableFiles = "UPDATE `upload` SET `Active` = 0 WHERE `UploadId` = '" . $_GET['uploadId'] . "'";
    $resultTableFiles = $conn->query($sqlTableFiles);

    header('Location: index.php');
}

// Variables to populate table with files
$sqlTableFiles = "SELECT `UploadId`, `FileName` , `Path` FROM `upload`
                    WHERE `Active` = 1 ORDER BY `UploadId` DESC";
$resultTableFiles = $conn->query($sqlTableFiles);

$conn->close();
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="inputFile">
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
        <!-- Populate table with files -->
        <?php while ($rowTableFiles = $resultTableFiles->fetch_assoc()): ?>
            <tr>
                <td width="70%">
                    <?php echo $rowTableFiles['FileName'] ?>
                </td>
                <td>
                    <!-- Sending file name ('name') and upload id ('id')  -->
                    <a href="<?php echo './../uploads/' . $rowTableFiles['Path'] ?>" class="btn btn-success" download> Descarregar</a>
                    <a href="?uploadId=<?php echo $rowTableFiles['UploadId'] ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
        <?php endwhile;?>
    </tbody>
</table>

<?php include './../inc/masterpage-frontend/footer.php'?>