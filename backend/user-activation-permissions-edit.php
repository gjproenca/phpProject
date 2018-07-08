<?php
include './../inc/masterpage-backend/header.php';
include './../inc/connection.php';

if(isset($_GET['userId'])) {
    $userId = $_GET['userId'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postAdmin = $_POST["dropDownListAdmin"];
    $postActive = $_POST["dropDownListActive"];

    if ($conn->connect_error) {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Falha na ligação à base de dados, por favor tente mais tarde</div>';
    } else {
        if($postAdmin == 'Administrador'){
            $admin = 1;
        } else {
            $admin = 0;
        }

        if($postActive == 'Ativo'){
            $active = 1;
        } else {
            $active = 0;
        }

        // Update query
        $sqlUpdate = "UPDATE   `user`
                        SET     `Admin` = $admin,
                                `Active` = $active
                        WHERE   UserId = $userId";

        if ($conn->query($sqlUpdate) === true) {
            header('Location: ./user-activation-permissions.php');
            // echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
            //     Atualização efetuada com sucesso</div>';
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao atualizar, por favor tente mais tarde</div>';
        }
    }
}

// Get data input fields
$sqlInputFields = "SELECT   `user`.`Username`,
                            `user`.`Email`,
                            `user`.`Admin`,
                            `user`.`Active`
                    FROM    `user`
                    WHERE   `user`.`UserId` = $userId";

@$queryInputFields = $conn->query($sqlInputFields);

$resultInputFieldsTemp = $queryInputFields->fetch_assoc();

$resultInputFieldsUsername = $resultInputFieldsTemp['Username'];
$resultInputFieldsEmail = $resultInputFieldsTemp['Email'];
$resultInputFieldsAdmin = $resultInputFieldsTemp['Admin'];
$resultInputFieldsActive = $resultInputFieldsTemp['Active'];

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
                            
                            <!-- Username -->
                            <div class="form-group">
                                <label>Nome de utilizador</label>
                                <input class="form-control" id="inputUsername" name="inputUsername" placeholder="Mínimo 8 carateres"
                                    type="text" pattern="^\w{8,}$"
                                        value="<?php 
                                                    if (isset($postUsername)) {
                                                        echo $postUsername;
                                                    } else {
                                                        echo $resultInputFieldsUsername;
                                                    }
                                                ?>" disabled>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label>Endereço de email</label>
                                <input class="form-control" id="inputEmail" name="inputEmail" placeholder="Introduza o seu endereço de email"
                                    type="email" pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"
                                        value="<?php 
                                            if (isset($postEmail)) {
                                                echo $postEmail;
                                            } else {
                                                echo $resultInputFieldsEmail;
                                            } 
                                        ?>" disabled>
                            </div>

                            <!-- Admin -->
                            <div class="form-group">
                                <label for="dropDownListAdmin">Administrador</label>
                                <select class="form-control text-center" id="dropDownListAdmin" name="dropDownListAdmin" required>
                                        
                                        <option selected>
                                            <?php 
                                            if ($resultInputFieldsAdmin == '1') {
                                                echo 'Administrador';
                                            } else {
                                                echo 'Utilizador';
                                            }
                                            ?>
                                        </option>
            
                                        <option>
                                            <?php 
                                                if ($resultInputFieldsAdmin == '1') {
                                                    echo 'Utilizador';
                                                } else {
                                                    echo 'Administrador';
                                                }
                                            ?>
                                        </option>
            
                                    </select>
                            </div>

                            <!-- Active -->
                            <div class="form-group">
                                <label for="dropDownListActive">Ativo</label>
                                <select class="form-control text-center" id="dropDownListActive" name="dropDownListActive" required>
                                        
                                        <option selected>
                                            <?php 
                                            if ($resultInputFieldsActive == '1') {
                                                echo 'Ativo';
                                            } else {
                                                echo 'Não ativo';
                                            }
                                            ?>
                                        </option>
            
                                        <option>
                                            <?php 
                                                if ($resultInputFieldsActive == '1') {
                                                    echo 'Não ativo';
                                                } else {
                                                    echo 'Ativo';
                                                }
                                            ?>
                                        </option>
            
                                    </select>
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
                            <a class="btn btn-dark text-white col-12" href="./user-activation-permissions.php">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-backend/footer.php'?>