<?php
include './../inc/masterpage-backend/header.php';
include './../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declaring search terms variables    
    if(isset($_POST['inputSearchCountry'])) {
        $inputSearchCountry = $_POST['inputSearchCountry'];

        if ($inputSearchCountry == "") {
            $inputSearchCountry = '%';
        }
    }
   
    if(isset($_POST['inputSearchName'])) {
        $inputSearchName = $_POST['inputSearchName'];

        if ($inputSearchName == "") {
            $inputSearchName = '%';
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
if (isset($inputSearchCountry)) {
    $country = $inputSearchCountry;
} else {
    $country = '%';
}

if (isset($inputSearchName)) {
    $name = $inputSearchName;
} else {
    $name = '%';
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
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $sqlDeactivateUser = "UPDATE `user` SET `Active` = 0 WHERE `UserId` = $userId";
    $conn->query($sqlDeactivateUser);

    header('Location: ./index.php');
}


// Query to populate table with files
$sqlTable = "SELECT    `user`.`UserId`,
                            `country`.`FormattedName`,
                            `user`.`Name`,
                            `user`.`Username`,
                            `user`.`Email`
                    FROM    `user`
                    JOIN    `country` ON `country`.`CountryId` = `user`.`CountryId`
                    WHERE `country`.`FormattedName` LIKE '%$country%'
                        AND `user`.`Name` LIKE '%$name%'
                        AND `user`.`Username` LIKE '%$username%'
                        AND `user`.`Email` LIKE '%$email%'
                    ORDER BY `UserId` DESC;";
$resultTable = $conn->query($sqlTable);

$conn->close();
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">

            <!-- Search form -->
            <form class="col-md-12 mb-5" method="POST" action="" id="formSearch">
                <div class="form-row">

                    <!-- Search Country -->
                    <div class="col-md-3">
                        <input class="form-control text-center" type="text" id="inputSearchCountry" name="inputSearchCountry" value="<?php
                                    // Setting serchbox to empty if theres no chars in it
                                    if (isset($_POST['inputSearchCountry'])) {
                                        if ($inputSearchCountry == '%') {
                                            echo '';
                                        } else {
                                            echo $inputSearchCountry;
                                        }
                                    }
                                    ?>" placeholder="Procurar por País">
                    </div>

                    <!-- Search Name -->
                    <div class="col-md-3">
                        <input class="form-control text-center" type="text" id="inputSearchName" name="inputSearchName" value="<?php
                                    // Setting serchbox to empty if theres no chars in it
                                    if (isset($_POST['inputSearchName'])) {
                                        if ($inputSearchName == '%') {
                                            echo '';
                                        } else {
                                            echo $inputSearchName;
                                        }
                                    }
                                    ?>" placeholder="Procurar por Nome">
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
                                ?>" placeholder="Procurar por nome de utilizador">
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
                                    ?>" placeholder="Procurar por Email">
                    </div>
                </div>
            </form>

            <div class="col-md-12">
                <!-- <div class="bg-primary border-secondary"> -->

                    <!-- Table -->
                    <table class="table table-responsive table-hover table-dark mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>UserId</th>
                                <th>País</th>
                                <th>Nome</th>
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
                                    <?php echo $rowTable['UserId'] ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['FormattedName'] ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Name'] ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Username'] ?>
                                </td>
                                <td>
                                    <?php echo $rowTable['Email'] ?>
                                </td>
                                <td>
                                    <a href="./index-edit.php?userId=<?php echo $rowTable['UserId'] ?>" class="btn btn-warning">Editar</a>
                                </td>
                                <td>
                                    <a href="?userId=<?php echo $rowTable['UserId'] ?>" class="btn btn-danger">Eliminar</a>
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
        $("#inputSearchCountry").keyup(() => {
            delay(function () {
                $("#formSearch").submit();
            }, 1000);
        });

        $("#inputSearchName").keyup(() => {
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