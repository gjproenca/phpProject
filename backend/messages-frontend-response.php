<?php
include './../inc/masterpage-backend/header.php';
include './../inc/connection.php';

if (isset($_GET['messageUserId'])) {
    $messageUserId = $_GET['messageUserId'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conn->connect_error) {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Falha na ligação à base de dados, por favor tente mais tarde</div>';
    } else {
        $postEmail = $_POST['inputEmail'];
        $postSubject = $_POST['inputSubject'];
        $postMessage = $_POST['message'];

        // Set active to 0 in databse
        if (isset($_GET['messageUserId'])) {
            $sqlDeleteUpload = "UPDATE `messagefrontend` SET `Active` = 0, `Modified` = NOW(3) WHERE `messageUserId` = $messageUserId";
        }

        include './../resources/PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPOptions = array
            (
            'ssl' => array
            (
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->isHTML(false);
        $mail->CharSet = "UTF-8";
        $mail->Username = 'webwarehouse13@gmail.com';
        $mail->Password = 'Ab-123456';
        $mail->setFrom('webwarehouse13@gmail.com', 'Webware');
        $mail->addReplyTo('webwarehouse13@gmail.com', 'Webware');
        $mail->Subject = "$postSubject";
        $mail->Body = "$postMessage";
        $mail->addAddress($postEmail);
        if ($mail->send() == true && $conn->query($sqlDeleteUpload) == true) {
            echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                Mensagem enviada com sucesso</div>';
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Não foi possível enviar a mensagem, por favor tente mais tarde</div>';
        }
    }
}

// Query to populate table with files
$sqlTable = "       SELECT  `messagefrontend`.`MessageUserId`,
                            `user`.`Name`,
                            `user`.`Username`,
                            `user`.`Email`,
                            `messageFrontend`.`Subject`,
                            `messageFrontend`.`Message`,
                            `messageFrontend`.`Active`,
                            `messageFrontend`.`CreationDate`
                    FROM    `messagefrontend` JOIN `user`
                    ON      `user`.`UserId` = `messageFrontend`.`UserId`
                    WHERE   `messageFrontend`.`MessageUserId` = $messageUserId";
$resultTable = $conn->query($sqlTable)->fetch_assoc();

$conn->close();
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">

            <!--Map-->
            <div class="col-md-6">
                <div class="p-5 card text-white bg-primary border-secondary">
                    <div class="card-body">

                            <h1 class="mb-4 text-center text-white">Mensagem</h1>
                            <div class="form-group">
                                <label for="inputName">Nome</label>
                                <input class="form-control" name="inputName" type="text" placeholder="Introduza o seu nome"
                                    MaxLength="100" pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$"
                                    value="<?php echo $resultTable['Name'] ?>" disabled>
                                <small class="form-text text-muted">
                                <br />
                                <br />
                                </small>
                                <div class="form-group">
                                    <label for="inputEmail">Endereço de email</label>
                                    <input class="form-control" name="inputEmail" type="email"
                                        placeholder="Introduza o seu endereço de email"
                                        MaxLength="70" pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"
                                        value="<?php echo $resultTable['Email'] ?>" disabled>
                                    <small class="form-text text-muted">
                                    <br />
                                    </small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSubject">Assunto</label>
                                <input class="form-control" name="inputSubject" type="text" placeholder="Introduza o assunto"
                                    MaxLength="70" pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$"
                                    value="<?php echo $resultTable['Subject'] ?>" disabled>
                                <small class="form-text text-muted">
                                <br />
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="textAreaMessage">Mensagem</label>
                                <textarea class="form-control" name="textAreaMessage" Rows="3"
                                    placeholder="Introduza a sua mensagem, mínimo 20 carateres, máximo 250"
                                    minlength="20" maxlength="250" disabled><?php echo $resultTable['Message'] ?></textarea>
                                <small class="form-text text-muted">
                                </small>
                            </div>
                    </div>
                </div>
            </div>

            <!--Form-->
            <div class="col-md-6">
                <div class="p-5 card text-white bg-primary border-secondary">
                    <div class="card-body">

                        <form method="POST" action="">
                            <h1 class="mb-4 text-center text-white">Resposta</h1>
                            <div class="form-group">
                                <label for="inputName">Nome</label>
                                <input class="form-control" name="inputName" type="text" placeholder="Introduza o nome"
                                    MaxLength="100" pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$"
                                    value="<?php echo $resultTable['Name'] ?>" readonly>
                                <small class="form-text text-muted">
                                <br />
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Endereço de email</label>
                                <input class="form-control" name="inputEmail" type="email"
                                    placeholder="Introduza o seu endereço de email"
                                    MaxLength="70" pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"
                                    value="<?php echo $resultTable['Email'] ?>" readonly>
                                <small class="form-text text-muted">
                                <br />
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="inputSubject">Assunto</label>
                                <input class="form-control" name="inputSubject" type="text" placeholder="Introduza o assunto"
                                    MaxLength="70" pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$"
                                    value="<?php echo $resultTable['Subject'] ?>" readonly>
                                <small class="form-text text-muted">
                                <br />
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="message">Mensagem</label>
                                <textarea class="form-control" name="message" Rows="3"
                                    placeholder="Introduza a sua mensagem, mínimo 20 carateres, máximo 250"
                                    minlength="20" maxlength="500" required></textarea>
                                <small class="form-text text-muted">
                                    A mensagem tem de conter no mínimo 20 carateres e no máximo 500 carateres
                                </small>
                            </div>
                            <button class="btn btn-dark text-white col-md-12" name="submitContacts">Submeter</button>
                            <br />
                            <br />
                            <button class="btn btn-dark text-white col-md-12" name="reset" id="reset" type="reset">Limpar</button>
                            <br />
                            <br />
                            <a class="btn btn-dark text-white col-md-12" href="./messages-frontend.php?messages-frontend">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-backend/footer.php';?>