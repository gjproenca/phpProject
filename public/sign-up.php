<?php
include './../inc/masterpage-public/header.php';
include '../inc/connection.php';

// Populate country list query
$sqlCountries = "SELECT `FormattedName` FROM `country`";
@$resultCountries = $conn->query($sqlCountries);

if (!isset($resultCountries)) {
echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
    Falha ao obter a lista de países, por favor tente mais tarde</div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postName = $_POST["inputName"];
    $postUsername = $_POST["inputUsername"];
    $postPassword = $_POST["inputPassword"];
    $postConfirmPassword = $_POST["inputConfirmPassword"];
    $postEmail = $_POST["inputEmail"];
    $postCountry = $_POST["dropdownListCountries"];
    
    $hashPassword = hash('sha512',$password);

    if ($conn->connect_error) {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Falha na ligação à base de dados, por favor tente mais tarde</div>';
    } else {
        if ($postPassword !== $postConfirmPassword) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Os campos senha não coincidem</div>';
        } else {
            // Get country id
            $sqlCountryId = "SELECT `CountryId` FROM `country` WHERE `FormattedName` LIKE '$postCountry'";
            @$queryCountryId = $conn->query($sqlCountryId);

            $resultCountryIdTemp = $queryCountryId->fetch_assoc();
            $resultCountryId = $resultCountryIdTemp['CountryId'];

            // Regiter query
            // TODO: add check existing for email
            $sqlRegisto = "INSERT INTO `user` (`CountryId`,`Name`,`Username`,`Password`,`Email`)
                        VALUES ('$resultCountryId','$postName','$postUsername','$hashPassword','$postEmail')";

            if ($conn->query($sqlRegisto) === true) {
                // TODO: add fade out or slide up aniamtion with jquery
                echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                            Registo efetuado com sucesso</div>';
            } else {
                echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                            Falha ao Registar</div>';
                // echo "Error: " . $sql . "<br>" . $conn->error; //to check query error
            }
        }
    }

    $conn->close();
}
?>

<div class="py-5 bg-primary text-white">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="p-5 card text-white bg-primary border-secondary">

                <!-- Form -->
                <div class="card-body">
                    <h1 class="mb-4">Registar</h1>
                    <form method="POST" action="" onSubmit="return validate();">
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
                                pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" value="<?php if (isset($postEmail)) {echo $postEmail;}?>" required>
                            <small class="form-text text-muted">
                                O endereço de email tem de ter pelo menos um '@' e um '.'
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="dropdownListCountries">País</label>
                            <select class="form-control" id="dropdownListCountries" name="dropdownListCountries" required>  

                                <!-- Populate dropdownlist with countries -->
                                <?php while ($postCountry = $resultCountries->fetch_assoc()): ?>
                                    <option><?php echo $postCountry['FormattedName']; ?></option>
                                <?php endwhile; ?>

                            </select>
                            <small class="form-text text-muted">
                                Escolha o seu país
                            </small>
                        </div>
                        <button class="btn btn-dark text-white" id="submit" name="submit" type="submit">Submeter</button>
                        <input class="btn btn-dark text-white float-sm-right" name="reset" id="reset" type="reset" value="Limpar" />
                        <br />
                        <br />
                        <a class="btn btn-dark text-white float-sm-right" id="forgotPassword" name="forgotPassword" href="TODO: forgot-password.aspx">Recuperar senha</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-public/footer.php';?>