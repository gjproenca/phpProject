<?php
include './../inc/masterpage-frontend/header.php';
include './../inc/connection.php';

$userId = $_SESSION['userId'];

// Upload files to folder and perform INSERT query on database
// Max file size 2MB, max files on single post 20
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['inputFile']) && $_FILES['inputFile']['error'] != UPLOAD_ERR_NO_FILE) {
        $fileName = $_FILES['inputFile']['name'];
        $path = date('dmY-His' . time()) . mt_rand() . '-' . $fileName;

        if (($_FILES['inputFile']['error'] == UPLOAD_ERR_OK) && ($_FILES['inputFile']['error'] != UPLOAD_ERR_INI_SIZE)) {
            if (move_uploaded_file($_FILES['inputFile']['tmp_name'], './../uploads/' . $path)) {
                $sqlFiles = "INSERT INTO `upload` (`UserId`,`FileName`,`Path`)
                                    VALUES ($userId,'$fileName','$path')";

                $conn->query($sqlFiles);
            }
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Não foi possível carregar o ficheiro, tamanho máximo de carregamento 2MB (versão de teste)</div>';
        }
    } else {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Nenhum ficheiro selecionado</div>';
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

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <!-- Form -->
            <div class="col-md-12">
                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="inputFile">
                    <input type="submit" value="Upload">
                </form>
            </div>

            <div class="col-md-12 mb-5">
            </div>

            <div class="col-md-12">
                <div class="bg-primary border-secondary">

                    <!-- Table -->
                    <table class="table table-hover table-dark">
                        <thead class="thead-light">
                            <tr>
                                <!-- TODO: see if text-center in file looks better or not -->
                                <th class="text-center">Ficheiro</th>
                                <th class="text-center" colspan="2">Acção</th>
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
                                </td>
                                <td>
                                    <a href="?uploadId=<?php echo $rowTableFiles['UploadId'] ?>" class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>
                            <?php endwhile;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-frontend/footer.php'?>