<?php
include './../inc/masterpage-public/header.php';
include '../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postName = $_POST["inputName"];
    $postUsername = $_POST["inputUsername"];
    $postPassword = $_POST["inputPassword"];
    $postConfirmPassword = $_POST["inputConfirmPassword"];
    $postEmail = $_POST["inputEmail"];
    $postCountry = $_POST["dropdownListCountries"];

    $hashPassword = hash('sha512', $postPassword);

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
        $sqlEmail = "SELECT `Email` FROM `user` WHERE `Email` LIKE '$postEmail'";
        @$querySqlEmail = $conn->query($sqlEmail);

        // Check if username exists
        $sqlUsername = "SELECT `Username` FROM `user` WHERE `Username` LIKE '$postUsername'";
        @$queryUsername = $conn->query($sqlUsername);

        // Regiter query
        $sqlRegisto = "INSERT INTO `user` (`CountryId`,`Name`,`Username`,`Password`,`Email`)
                        VALUES ('$resultCountryId','$postName','$postUsername','$hashPassword','$postEmail')";

        if ($postPassword !== $postConfirmPassword) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Os campos senha não coincidem</div>';
        } else if ($queryUsername === false) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao verificar o nome de utilizador, por favor tente mais tarde</div>';
        } else if ($queryUsername->num_rows == 1) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Nome de utilizador já existente, se se esqueceu da senha e quiser recuperá-la, clique em \'Recuperar senha\'</div>';
        } else if ($querySqlEmail === false) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao verificar email, por favor tente mais tarde</div>';
        } else if ($querySqlEmail->num_rows == 1) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Email já existente, se se esqueceu da senha e quiser recuperá-la, clique em \'Recuperar senha\'</div>';
        } else if ($conn->query($sqlRegisto) === true) {
            // TODO: add fade out or slide up aniamtion with jquery
            echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                Registo efetuado com sucesso</div>';
            // echo "Error: " . $sql . "<br>" . $conn->error; // to check query error

            // TODO: send welcome email
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao efetuar o registo, por favor tente mais tarde</div>';
        }
    }
}

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
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="p-5 card text-white bg-primary border-secondary">

                <!-- Form -->
                <div class="card-body">
                    <h1 class="mb-4 text-center text-white">Registar</h1>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Nome</label>
                            <input class="form-control" id="inputName" name="inputName" placeholder="Mínimo 3 carateres" type="text" pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$"
                                value="<?php if (isset($postName)) {echo $postName;}?>" required>
                            <small class="form-text text-muted">
                                O nome tem de conter no mínimo 3 carateres
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Nome de utilizador</label>
                            <input class="form-control" id="inputUsername" name="inputUsername" placeholder="Mínimo 8 carateres" type="text" pattern="^\w{8,}$"
                                value="<?php if (isset($postUsername)) {echo $postUsername;}?>" required>
                            <small class="form-text text-muted">
                                O nome de utilizador tem de conter no mínimo 8 carateres
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Senha</label>
                            <input class="form-control" id="inputPassword" name="inputPassword" placeholder="Mínimo 8 carateres" type="password" pattern="^[^\s].{6,}[^\s]$"
                                value="<?php if (isset($password)) {echo $password;}?>" required>
                            <small class="form-text text-muted">
                                A senha tem de conter no mínimo 8 carateres
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Confirmar senha</label>
                            <input class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="Mínimo 8 carateres" type="password"
                                pattern="^[^\s].{6,}[^\s]$" required>
                            <small class="form-text text-muted">
                                As senhas têm de coincidir
                            </small>
                        </div>
                        <div class="form-group">
                            <label>Endereço de email</label>
                            <input class="form-control" id="inputEmail" name="inputEmail" placeholder="Introduza o seu endereço de email" type="email"
                                pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" value="<?php if (isset($postEmail)) {echo $postEmail;}?>"
                                required>
                            <small class="form-text text-muted">
                                O endereço de email tem de ter pelo menos um '@' e um '.'
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="dropdownListCountries">País</label>
                            <select class="form-control" id="dropdownListCountries" name="dropdownListCountries" required>

                                <!-- Populate dropdownlist with countries -->
                                <?php while ($postCountry = $resultCountries->fetch_assoc()): ?>
                                <option>
                                    <?php echo $postCountry['FormattedName']; ?>
                                </option>
                                <?php endwhile;?>

                            </select>
                            <small class="form-text text-muted">
                                Escolha o seu país
                            </small>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck3" required>
                                <label class="form-check-label" for="invalidCheck3">
                                    Declaro que li e aceito os Termos e Condições
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-dark text-white" id="submit" name="submit" type="submit">Submeter</button>
                        <input class="btn btn-dark text-white float-sm-right" name="reset" id="reset" type="reset" value="Limpar" />
                        <br />
                        <br />
                        <a class="btn btn-dark text-white float-sm-right" id="forgotPassword" name="forgotPassword" href="./forgot-password.php">Recuperar senha</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-public/footer.php';?>