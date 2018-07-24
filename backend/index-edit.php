<?php
include './../inc/masterpage-backend/header.php';
include './../inc/connection.php';

if(isset($_GET['userId'])) {
    $userId = $_GET['userId'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postName = $_POST["inputName"];
    $postUsername = $_POST["inputUsername"];
    $postEmail = $_POST["inputEmail"];
    $postCountry = $_POST["dropdownListCountries"];

    if ($conn->connect_error) {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Falha na ligação à base de dados, por favor tente mais tarde</div>';
    } else {
        // Get country id
        $sqlCountryId = "SELECT `CountryId` FROM `country` WHERE `FormattedName` LIKE '$postCountry'";
        @$queryCountryId = $conn->query($sqlCountryId);

        $resultCountryIdTemp = $queryCountryId->fetch_assoc();
        $resultCountryId = $resultCountryIdTemp['CountryId'];

        // Check if email exists
        $sqlEmail = "SELECT `Email` FROM `user`
            WHERE `Email` LIKE '$postEmail'
            AND `userId` != $userId";
        @$querySqlEmail = $conn->query($sqlEmail);

        // Check if username exists
        $sqlUsername = "SELECT `Username` FROM `user` WHERE `Username` LIKE '$postUsername'
        AND `userId` != $userId";
        @$queryUsername = $conn->query($sqlUsername);

        // Regiter query
        $sqlUpdate = "UPDATE   `user`
                        SET     `CountryId` = $resultCountryId,
                                `Name` = '$postName',
                                `Username` = '$postUsername',
                                `Email` = '$postEmail',
                                `Modified` = NOW(3)
                        WHERE   UserId = $userId";

        if ($queryUsername === false) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao verificar o nome de utilizador, por favor tente mais tarde</div>';
        } else if ($queryUsername->num_rows == 1) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Nome de utilizador já existente</div>';
        } else if ($querySqlEmail === false) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao verificar email, por favor tente mais tarde</div>';
        } else if ($querySqlEmail->num_rows == 1) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Email já existente</div>';
        } else if ($conn->query($sqlUpdate) === true) {
            header('Location: ./index.php?index');
            // echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
            //     Atualização efetuada com sucesso</div>';
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao atualizar, por favor tente mais tarde</div>';
        }
    }
}

// Get data input fields
$sqlInputFields = "SELECT   `user`.`Name`,
                            `user`.`Username`,
                            `user`.`Email`,
                            `country`.`FormattedName` AS 'CountryName'
                    FROM    `user`
                    JOIN    `country`
                    ON      `user`.`CountryId` = `country`.`CountryId`
                    WHERE   `user`.`UserId` = $userId";

@$queryInputFields = $conn->query($sqlInputFields);

$resultInputFieldsTemp = $queryInputFields->fetch_assoc();
$resultInputFieldsName = $resultInputFieldsTemp['Name'];
$resultInputFieldsUsername = $resultInputFieldsTemp['Username'];
$resultInputFieldsEmail = $resultInputFieldsTemp['Email'];
$resultInputFieldsCountry = $resultInputFieldsTemp['CountryName'];

// Populate country list query
$sqlCountries = "SELECT `FormattedName` FROM `country`";
@$resultCountries = $conn->query($sqlCountries);

if (!isset($resultCountries)) {
    echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
    Falha ao obter a lista de países, por favor tente mais tarde</div>';
}

$conn->close();
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="p-5 card text-white bg-primary border-secondary">

                    <!-- Form -->
                    <div class="card-body">
                        <h1 class="mb-4 text-center text-white">Editar dados</h1>
                        <form method="POST" action="">
                            
                            <!-- Name -->
                            <div class="form-group">
                                <label>Nome</label>
                                <input class="form-control" id="inputName" name="inputName" placeholder="Mínimo 3 carateres" type="text" pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$"
                                    value="<?php 
                                                if (isset($postName)) {
                                                    echo $postName;
                                                } else { 
                                                    echo $resultInputFieldsName;
                                                } 
                                            ?>" required>
                                <small class="form-text text-muted">
                                    O nome tem de conter no mínimo 3 carateres
                                </small>
                            </div>
                            
                            <!-- Username -->
                            <div class="form-group">
                                <label>Nome de utilizador</label>
                                <input class="form-control" id="inputUsername" name="inputUsername" placeholder="Mínimo 8 carateres" type="text" pattern="^\w{8,}$"
                                    value="<?php 
                                                if (isset($postUsername)) {
                                                    echo $postUsername;
                                                } else {
                                                    echo $resultInputFieldsUsername;
                                                }
                                            ?>" required>
                                <small class="form-text text-muted">
                                    O nome de utilizador tem de conter no mínimo 8 carateres
                                </small>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label>Endereço de email</label>
                                <input class="form-control" id="inputEmail" name="inputEmail" placeholder="Introduza o seu endereço de email" type="email"
                                    pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" value="<?php 
                                                                                                    if (isset($postEmail)) {
                                                                                                        echo $postEmail;
                                                                                                    } else {
                                                                                                        echo $resultInputFieldsEmail;
                                                                                                    } 
                                                                                                  ?>" required>
                                <small class="form-text text-muted">
                                    O endereço de email tem de ter pelo menos um '@' e um '.'
                                </small>
                            </div>

                            <!-- Country -->
                            <div class="form-group">
                                <label for="dropdownListCountries">País</label>
                                <select class="form-control" id="dropdownListCountries" name="dropdownListCountries" required>
                                    
                                    <option selected>
                                        <?php 
                                            if (isset($postCountry)) {
                                                echo $postCountry;
                                            } else {
                                                echo $resultInputFieldsCountry;
                                            } ?>
                                        </option>

                                    <!-- TODO: change post counry name and verify -->
                                    <!-- Populate dropdownlist with countries -->
                                    <?php while ($postCountry = $resultCountries->fetch_assoc()): ?>
                                    <option>
                                        <?php echo $postCountry['FormattedName']; ?>
                                    </option>
                                    <?php endwhile;?>

                                </select>
                                <small class="form-text text-muted">
                                    Escolha o país
                                </small>
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck3" required>
                                    <label class="form-check-label" for="invalidCheck3">
                                        Confirmar alteração dos dados
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-dark text-white col-12" id="submit" name="submit" type="submit">Submeter</button>
                            <br />
                            <br />
                            <button class="btn btn-dark text-white col-12" name="reset" id="reset" type="reset">Limpar</button>
                            <br />
                            <br />
                            <a class="btn btn-dark text-white col-12" href="./index.php">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-backend/footer.php'?>