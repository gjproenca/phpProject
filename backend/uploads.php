<?php
include './../inc/masterpage-backend/header.php';
include './../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declaring search terms variables    
    if(isset($_POST['inputSearchFilename'])) {
        $inputSearchFilename = $_POST['inputSearchFilename'];

        if ($inputSearchFilename == "") {
            $inputSearchFilename = '%';
        }
    }
  
    if(isset($_POST['inputSearchActive'])) {
        $inputSearchActive = $_POST['inputSearchActive'];

        if ($inputSearchActive == 'Ativo') {
            $inputSearchActive = 1;
        } else {
            $inputSearchActive = 0;
        }
    }

    if(isset($_POST['inputSearchUsername'])) {
        $inputSearchUsername = $_POST['inputSearchUsername'];

        if ($inputSearchUsername == "") {
            $inputSearchUsername = '%';
        }
    }
    
    if(isset($_POST['inputSearchEmail'])) {
        $inputSearchEmail = $_POST['inputSearchEmail'];

        if ($inputSearchEmail == "") {
            $inputSearchEmail = '%';
        }
    }
}

// Setting search term for sql query
if (isset($inputSearchFilename)) {
    $filename = $inputSearchFilename;
} else {
    $filename = '%';
}

if (isset($inputSearchActive)) {
    $active = $inputSearchActive;
} else {
    $active = 1;
}

if (isset($inputSearchUsername)) {
    $username = $inputSearchUsername;
} else {
    $username = '%';
}

if (isset($inputSearchEmail)) {
    $email = $inputSearchEmail;
} else {
    $email = '%';
}

// Set active to 0 in databse
if (isset($_GET['uploadIdDelete'])) {
    $uploadIdDelete = $_GET['uploadIdDelete'];
    $sqlDeleteUpload = "UPDATE `upload` SET `Active` = 0 WHERE `UploadId` = $uploadIdDelete";
    $conn->query($sqlDeleteUpload);

    header('Location: ./uploads.php');
}

// Set active to 1 in databse
if (isset($_GET['uploadIdRestore'])) {
    $uploadIdRestore = $_GET['uploadIdRestore'];
    $sqlRestoreUpload = "UPDATE `upload` SET `Active` = 1 WHERE `UploadId` = $uploadIdRestore";
    $conn->query($sqlRestoreUpload);

    header('Location: ./uploads.php');
}

// Query to populate table with files
$sqlTable = "SELECT         `upload`.`UploadId`,
                            `upload`.`FileName`,
                            `upload`.`Path`,
                            `upload`.`Active` AS 'UploadActive',
                            `user`.`UserId`,
                            `user`.`Username`,
                            `user`.`Email`
                    FROM    `user` 
                    JOIN    `upload` ON `upload`.`UserId` = `user`.`UserId`
                    WHERE `upload`.`Active` = $active
                    AND `upload`.`FileName` LIKE '%$filename%'
                    AND `user`.`Username` LIKE '%$username%'
                    AND `user`.`Email` LIKE '%$email%'
                    ORDER BY `upload`.`UploadId` DESC;";
$resultTable = $conn->query($sqlTable);

$conn->close();
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">

            <!-- Search form -->
            <form class="col-md-12 mb-5" method="POST" action="" id="formSearch">
                <div class="form-row">

                    <!-- Search Filename -->
                    <div class="col-md-3">
                        <input class="form-control text-center" type="text" id="inputSearchFilename" name="inputSearchFilename"
                            value="<?php
                                    // Setting serchbox to empty if theres no chars in it
                                    if (isset($_POST['inputSearchFilename'])) {
                                        if ($inputSearchFilename == '%') {
                                            echo '';
                                        } else {
                                            echo $inputSearchFilename;
                                        }
                                    }
                                    ?>" placeholder="Ficheiro">
                    </div>

                    <!-- Search Active -->
                    <div class="col-md-3">
                        <select class="form-control text-center" id="inputSearchActive" name="inputSearchActive" required>

                            <!-- FIXME: after restoring, jumps to upload page again -->
                            <option selected>
                                <?php 
                                    if (isset($_POST['inputSearchActive'])) {
                                        if ($inputSearchActive == 1) {
                                            echo 'Ativo';
                                        } else {
                                            echo 'Não ativo';
                                        }
                                    } else {
                                        echo 'Ativo';
                                    }
                                ?>
                            </option>

                            <option>
                                <?php 
                                    if (isset($_POST['inputSearchActive'])) {
                                        if ($inputSearchActive == 1) {
                                            echo 'Não ativo';
                                        } else {
                                            echo 'Ativo';
                                        }
                                    } else {
                                        echo 'Não ativo';
                                    }
                                ?>
                            </option>

                        </select>
                    </div>

                    <!-- Search Username -->
                    <div class="col-md-3">
                        <input class="form-control text-center" type="text" id="inputSearchUsername" name="inputSearchUsername" value="<?php
                                // Setting serchbox to empty if theres no chars in it
                                if (isset($_POST['inputSearchUsername'])) {
                                    if ($inputSearchUsername == '%') {
                                        echo '';
                                    } else {
                                        echo $inputSearchUsername;
                                    }
                                }
                                ?>" placeholder="Nome de utilizador">
                    </div>

                    <!-- Search Email -->
                    <div class="col-md-3">
                        <input class="form-control text-center" type="text" id="inputSearchEmail" name="inputSearchEmail" value="<?php
                                    // Setting serchbox to empty if theres no chars in it
                                    if (isset($_POST['inputSearchEmail'])) {
                                        if ($inputSearchEmail == '%') {
                                            echo '';
                                        } else {
                                            echo $inputSearchEmail;
                                        }
                                    }
                                    ?>" placeholder="Email">
                    </div>
                </div>
            </form>

            <div class="col-md-12">
                <!-- <div class="bg-primary border-secondary"> -->

                    <!-- TODO: fix table having a gap on the right side-->
                    <!-- Table -->
                    <table class="table table-responsive table-hover table-dark mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>UploadId</th>
                                <th>Ficheiro</th>
                                <th>Caminho</th>
                                <th>Ativo</th>
                                <th>UserId</th>
                                <th>Nome de utilizador</th>
                                <th>Email</th>
                                <th class="text-center" colspan="2">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populate table with files -->
                            <?php while ($rowTable = $resultTable->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php echo $rowTable['UploadId']; ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['FileName']; ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Path']; ?>
                                </td>
                                <td>
                                    <?php
                                        if($rowTable['UploadActive'] == 1) {
                                            echo 'Sim';
                                        } else {
                                            echo 'Não';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['UserId']; ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Username']; ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Email']; ?>
                                </td>
                                <td>
                                    <a href="?uploadIdRestore=<?php echo $rowTable['UploadId']; ?>" class="btn btn-warning">Restaurar</a>
                                </td>
                                <td>
                                    <a href="?uploadIdDelete=<?php echo $rowTable['UploadId']; ?>" class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>
                            <?php endwhile;?>
                        </tbody>
                    </table>
                <!-- </div> -->
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
        $("#inputSearchFilename").keyup(() => {
            delay(function () {
                $("#formSearch").submit();
            }, 1000);
        });
        
        $("#inputSearchActive").change(() => {
            delay(function () {
                $("#formSearch").submit();
            }, 1000);
        });
        
        $("#inputSearchUsername").keyup(() => {
            delay(function () {
                $("#formSearch").submit();
            }, 1000);
        });

        $("#inputSearchEmail").keyup(() => {
            delay(function () {
                $("#formSearch").submit();
            }, 1000);
        });
    });
</script>

<?php include './../inc/masterpage-backend/footer.php';?>