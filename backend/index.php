<?php
include './../inc/masterpage-backend/header.php';
include './../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // declaring search terms variables    
    if(isset($_POST['formSearchCountry'])) {
        $inputSearchCountry = $_POST['inputSearchCountry'];

        if ($inputSearchCountry == "") {
            $inputSearchCountry = '%';
        }
    }
    
    if(isset($_POST['formSearchName'])) {
        $inputSearchName = $_POST['inputSearchName'];

        if ($inputSearchName == "") {
            $inputSearchName = '%';
        }    
    }

    if(isset($_POST['formSearchUsername'])) {
        $inputSearchUsername = $_POST['inputSearchUsername'];

        if ($inputSearchUsername == "") {
            $inputSearchUsername = '%';
        }
    }
    
    if(isset($_POST['formSearchEmail'])) {
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

// Query to populate table with files
$sqlTable = "SELECT    `user`.`UserId`,
                            `country`.`FormattedName`,
                            `user`.`Name`,
                            `user`.`Username`,
                            `user`.`Email`
                    FROM    `user`
                    JOIN    `country` ON `country`.`CountryId` = `user`.`CountryId`
                    WHERE   `Active` = 1
                        AND `country`.`FormattedName` LIKE '%$country%'
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

            <!-- Country search form -->
            <div class="col-md-3 mb-5">
                <form method="POST" action="" id="formSearchCountry">
                    <input class="form-control text-center" type="text" id="inputSearchCountry" name="inputSearchCountry"
                        value="<?php
                                // FIXME: searchfields not saving search terms
                                // Setting serchbox to empty if theres no chars in it
                                if (isset($_POST['formSearchCountry'])) {
                                    if ($inputSearchCountry == '%') {
                                        echo '';
                                    } else {
                                        echo $inputSearchCountry;
                                    }
                                }
                                ?>" placeholder="País">
                </form>
            </div>

            <!-- Name search form -->
            <div class="col-md-3 mb-5">
                <form method="POST" action="" id="formSearchName">
                    <input class="form-control text-center" type="text" id="inputSearchName" name="inputSearchName"
                        value="<?php
                                // Setting serchbox to empty if theres no chars in it
                                if (isset($_POST['inputSearchName'])) {
                                    if ($inputSearchName == '%') {
                                        echo '';
                                    } else {
                                        echo $inputSearchName;
                                    }
                                }
                                ?>" placeholder="Nome">
                </form>
            </div>

            <!-- Username search form -->
            <div class="col-md-3 mb-5">
                <form method="POST" action="" id="formSearchUsername">
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
                </form>
            </div>

            <!-- Email search form -->
            <div class="col-md-3 mb-5">
                <form method="POST" action="" id="formSearchEmail">
                    <input class="form-control text-center" type="text" id="inputSearchEmail" name="inputSearchEmail"
                        value="<?php
                                // Setting serchbox to empty if theres no chars in it
                                if (isset($_POST['inputSearchEmail'])) {
                                    if ($inputSearchEmail == '%') {
                                        echo '';
                                    } else {
                                        echo $inputSearchEmail;
                                    }
                                }
                                ?>" placeholder="Email">
                </form>
            </div>

            <div class="col-md-12">
                <div class="bg-primary border-secondary">

                    <!-- Table -->
                    <table class="table table-hover table-dark">
                        <thead class="thead-light">
                            <tr>
                                <th>UserId</th>
                                <th>País</th>
                                <th>Nome</th>
                                <th>Nome de utilizador</th>
                                <th>Email</th>
                                <th>Ação</th>
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
                                    <a href="?uploadId=<?php echo $rowTable['UserId'] ?>" class="btn btn-danger">Eliminar</a>
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
         $("#inputSearchCountry").keyup(() => {
            delay(function () {
                $("#formSearchCountry").submit();
            }, 1000);
        });

        $("#inputSearchName").keyup(() => {
            delay(function () {
                $("#formSearchName").submit();
            }, 1000);
        });

        $("#inputSearchUsername").keyup(() => {
            delay(function () {
                $("#formSearchUsername").submit();
            }, 1000);
        });

        $("#inputSearchEmail").keyup(() => {
            delay(function () {
                $("#formSearchEmail").submit();
            }, 1000);
        });
    });
</script>

<?php include './../inc/masterpage-backend/footer.php';?>