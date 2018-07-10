<?php
include './../inc/masterpage-frontend/header.php';
include './../inc/connection.php';

$userId = $_SESSION['userId'];

// Upload files to folder and perform INSERT query on database
// Max file size 2MB, max files on single post 20
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submitUpload"])) {

        // File upload
        if (isset($_FILES['inputFile']) && $_FILES['inputFile']['error'] != UPLOAD_ERR_NO_FILE) {
            $fileName = $_FILES['inputFile']['name'];
            $path = date('dmY-His' . time()) . mt_rand() . '-' . $fileName;

            if (($_FILES['inputFile']['error'] == UPLOAD_ERR_OK)
                && ($_FILES['inputFile']['error'] != UPLOAD_ERR_INI_SIZE)) {
                if (move_uploaded_file($_FILES['inputFile']['tmp_name'], './../uploads/' . $path)) {
                    $sqlFiles = "INSERT INTO `upload` (`UserId`,`FileName`,`Path`)
                                    VALUES ($userId,'$fileName','$path')";

                    $conn->query($sqlFiles);
                }

                echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                    Ficheiro carregado com sucesso</div>';
            } else {
                echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                    Não foi possível carregar o ficheiro, tamanho máximo de carregamento 2MB (versão de teste)</div>';
            }
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Nenhum ficheiro selecionado</div>';
        }
    } else if(isset($_POST['inputSearch'])) {
        // Search bar form post
        $inputSearch = $_POST['inputSearch'];
        
        if($inputSearch == "") {
            $inputSearch = '%';
        }
    }
}

// Set active to 0 in databse
if (isset($_GET['uploadId'])) {
    $uploadId = $_GET['uploadId'];
    $sqlTableFiles = "UPDATE `upload` SET `Active` = 0 WHERE `UploadId` = $uploadId";
    $resultTableFiles = $conn->query($sqlTableFiles);

    header('Location: ./index.php');
}

// Setting search term for sql query
if (isset($inputSearch)) {
    $searchTerm = $inputSearch;
} else {
    $searchTerm = '%';
}

// Query to populate table with files
$sqlTableFiles = "SELECT    `UploadId`, 
                            `FileName` , 
                            `Path`
                    FROM `upload`
                    WHERE `Active` = 1
                    AND `FileName` LIKE '%$searchTerm%'
                    AND `UserId` = $userId 
                    ORDER BY `UploadId` DESC";
$resultTableFiles = $conn->query($sqlTableFiles);

$conn->close();
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">

            <!-- TODO: stylize file upload -->
            <!-- Upload form -->
            <div class="col-md-12 mb-5 text-center">
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="file" name="inputFile">
                    <input type="submit" value="Carregar" name="submitUpload">
                </form>
            </div>

            <!-- Search form -->
            <div class="col-md-12 mb-5">
                <form method="POST" action="" id="formSearch">
                    <input class="form-control text-center" type="text" id="inputSearch" name="inputSearch" 
                        value="<?php
                                // Setting serchbox to empty if theres no chars in it 
                                if (isset($_POST['inputSearch'])) { 
                                    if($inputSearch == '%'){
                                        echo '';
                                    } else {
                                        echo $inputSearch;
                                    }
                                }
                                ?>" placeholder="Procurar...">
                </form>
            </div>

            <div class="col-md-12">
                <div class="bg-primary border-secondary">

                    <!-- Table -->
                    <table class="table table-responsive table-hover table-dark">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" colspan="3">Ficheiros</th>
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
                                    <a href="<?php echo './../uploads/' . $rowTableFiles['Path'] ?>"
                                        class="btn btn-success" download> Descarregar</a>
                                </td>
                                <td>
                                    <a href="?uploadId=<?php echo $rowTableFiles['UploadId'] ?>"
                                        onclick="return confirm('Tem a certeza que quer eliminar este ficheiro?')"
                                        class="btn btn-danger">Eliminar</a>
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

<script>
    // creater timer function
    var delay = (() => {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

    // submit form after user finished pressing keys for 1 second
    $(document).ready(() => {
        $("#inputSearch").keyup(() => {
            delay(function () {
                $("#formSearch").submit();
            }, 1000);
        });
    });
</script>

<?php include './../inc/masterpage-frontend/footer.php'?>
