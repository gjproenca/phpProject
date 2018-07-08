<?php
include './../inc/masterpage-backend/header.php';
include './../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declaring search terms variables    
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

    if(isset($_POST['inputSearchSubject'])) {
        $inputSearchSubject = $_POST['inputSearchSubject'];

        if ($inputSearchSubject == "") {
            $inputSearchSubject = '%';
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
}

// Setting search term for sql query
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

if (isset($inputSearchSubject)) {
    $subject = $inputSearchSubject;
} else {
    $subject = '%';
}

if (isset($inputSearchActive)) {
    $active = $inputSearchActive;
} else {
    $active = 1;
}

// Set active to 0 in databse
if (isset($_GET['messageUserId'])) {
    $messageIdDelete = $_GET['messageUserId'];
    $sqlDeleteUpload = "UPDATE `messagefrontend` SET `Active` = 0 WHERE `MessageUserId` = $messageIdDelete";
    $conn->query($sqlDeleteUpload);

    header('Location: ./messages-frontend.php');
}

// Query to populate table with files
$sqlTable = "       SELECT  `messagefrontend`.`MessageUserId`,
                            `user`.`Username`,
                            `user`.`Email`,
                            `messageFrontend`.`Subject`,
                            `messageFrontend`.`Message`,
                            `messageFrontend`.`Active`,
                            `messageFrontend`.`CreationDate`
                    FROM    `messagefrontend` JOIN `user`
                    ON      `user`.`UserId` = `messageFrontend`.`UserId`
                    WHERE   `user`.`Name` LIKE '%$username%'
                    AND     `user`.`Email` LIKE '%$email%'
                    AND     `messageFrontend`.`Subject` LIKE '%$subject%'
                    AND     `messageFrontend`.`Active` = $active
                    ORDER BY `MessageUserId` DESC;";
$resultTable = $conn->query($sqlTable);

$conn->close();
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">

            <!-- Search form -->
            <form class="col-md-12 mb-5" method="POST" action="" id="formSearch">
                <div class="form-row">

                    <!-- Search Name -->
                    <div class="col-md-3">
                        <input class="form-control text-center" type="text" id="inputSearchUsername" name="inputSearchUsername"
                            value="<?php
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

                     <!-- Search Subject -->
                     <div class="col-md-3">
                        <input class="form-control text-center" type="text" id="inputSearchSubject" name="inputSearchSubject" value="<?php
                                // Setting serchbox to empty if theres no chars in it
                                if (isset($_POST['inputSearchSubject'])) {
                                    if ($inputSearchSubject == '%') {
                                        echo '';
                                    } else {
                                        echo $inputSearchSubject;
                                    }
                                }
                                ?>" placeholder="Assunto">
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
                </div>
            </form>

            <div class="col-md-12">
                <!-- <div class="bg-primary border-secondary"> -->

                    <!-- TODO: fix table having a gap on the right side-->
                    <!-- Table -->
                    <table class="table table-responsive table-hover table-dark mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>MessageUserId</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Assunto</th>
                                <th>Data de envio</th>
                                <th>Ativo</th>
                                <th class="text-center" colspan="2">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populate table with files -->
                            <?php while ($rowTable = $resultTable->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php echo $rowTable['MessageUserId']; ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Username']; ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Email']; ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Subject']; ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['CreationDate']; ?>
                                </td>
                                <td>
                                    <?php
                                        if($rowTable['Active'] == 1) {
                                            echo 'Sim';
                                        } else {
                                            echo 'Não';
                                        }
                                    ?>
                                </td>
                                <td>
                                <!-- TODO: response page -->
                                    <a href="./messages-frontend-response.php?messageUserId=<?php echo $rowTable['MessageUserId']; ?>" class="btn btn-warning">Responder</a>
                                </td>
                                <td>
                                    <a href="?messageUserId=<?php echo $rowTable['MessageUserId']; ?>" class="btn btn-danger">Eliminar</a>
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
        
        $("#inputSearchSubject").keyup(() => {
            delay(function () {
                $("#formSearch").submit();
            }, 1000);
        });

        $("#inputSearchActive").change(() => {
            delay(function () {
                $("#formSearch").submit();
            }, 1000);
        });
        
    });
</script>

<?php include './../inc/masterpage-backend/footer.php';?>