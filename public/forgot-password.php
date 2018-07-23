<?php
include './../inc/masterpage-public/header.php';
include './../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conn->connect_error) {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Falha na ligação à base de dados, por favor tente mais tarde</div>';
    } else {
        // Set temporary password
        $tempPassword = bin2hex(random_bytes(13));
        $hashPassword = hash('sha512', $tempPassword);

        // Get post data
        $postEmail = $_POST['inputEmail'];

        // Get user data
        $sql = "SELECT `UserId` ,`Username`, `Password`,`Email`, `Admin`, `Active`
            FROM `user` WHERE `Email` LIKE '$postEmail'";
        @$query = $conn->query($sql);
        $result = $query->fetch_assoc();

        $resultUserId = $result['UserId'];
        $resultUsername = $result['Username'];
        $resultPassword = $result['Password'];
        $resultAdmin = $result['Admin'];
        $resultActive = $result['Active'];

        if (!isset($query)) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao obter a lista de utilizadores, por favor tente mais tarde</div>';
        } else if (!isset($result)) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Não existe um utilizador com este email</div>';
        } else if ($resultAdmin == 1) {
            if ($resultActive == 1) {
                try {
                    $sql = "INSERT INTO `user` SET `Password` = '$hashPassword'  WHERE `Email` LIKE '$postEmail'";
                    @$query = $conn->query($sql);

                    include './../resources/PHPMailer/PHPMailerAutoload.php';
                    $mail = new PHPMailer;
                    $mail->isSMTP();
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
                    $mail->isHTML(true);
                    $mail->CharSet = "UTF-8";
                    $mail->Username = 'webwarehouse13@gmail.com';
                    $mail->Password = 'Ab-123456';
                    $mail->setFrom('webwarehouse13@gmail.com', 'Webware');
                    $mail->addReplyTo('webwarehouse13@gmail.com', 'Webware');
                    $mail->Subject = 'Recuperação de senha';
                    $mail->Body = 'Obrigado por continuar a utilizar os nossos servicos,
                    <br />
                    <br />
                    A sua nova senha é: ' . $tempPassword . '<br />
                    <br />
                    Por favor, quando entrar não se esqueca de atualizar a mesma para uma à sua escolha.
                    <br />
                    <br />
                    Obrigado,
                    <br />
                    <br />
                    Webware';
                    $mail->addAddress($postEmail);
                    if (!$mail->send()) {
                        echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                            Recuperação de senha efetuada com sucesso, por favor verifique o seu email</div>';
                    } else {
                        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                        Não foi possível efetuar a recuperação de senha, por favor tente mais tarde</div>';
                    }
                } catch (Exception $e) {
                }
            } else {
                echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                    Conta de administrador não ativa</div>';
            }
        } else {
            if ($resultActive == 1) {
                try {
                    $sql = "UPDATE `user` SET `Password` = '$hashPassword'  WHERE `Email` LIKE '$postEmail'";
                    @$query = $conn->query($sql);

                    include './../resources/PHPMailer/PHPMailerAutoload.php';
                    $mail = new PHPMailer;
                    $mail->isSMTP();
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
                    $mail->isHTML(true);
                    $mail->Username = 'webwarehouse13@gmail.com';
                    $mail->Password = 'Ab-123456';
                    $mail->setFrom('webwarehouse13@gmail.com', 'Webware');
                    $mail->addReplyTo('webwarehouse13@gmail.com', 'Webware');
                    $mail->Subject = 'Recuperacao de senha';
                    $mail->Body = 'Obrigado por continuar a utilizar os nossos servicos,
                    <br />
                    <br />
                    A sua nova senha é: ' . $tempPassword . '<br />
                    <br />
                    Por favor, quando entrar não se esqueca de atualizar a mesma para uma à sua escolha.
                    <br />
                    <br />
                    Obrigado,
                    <br />
                    <br />
                    Webware';
                    $mail->addAddress($postEmail);
                    if ($mail->send()) {
                        echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                            Recuperação de senha efetuada com sucesso, por favor verifique o seu email</div>';
                    } else {
                        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                            Não foi possível efetuar a recuperação de senha, por favor tente mais tarde</div>';
                    }
                } catch (Exception $e) {
                }
            } else {
                echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                    Conta de utilizador não ativa</div>';
            }
        }
    }
}
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="p-5 card text-white bg-primary border-secondary">

                    <!-- Form -->
                    <div class="card-body">
                        <h1 class="mb-4 text-white">Recuperar senha</h1>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="inputEmail" placeholder="Introduza o seu endereço de email" type="email"
                                    pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" required>
                                <small class="form-text text-muted">
                                    O endereço de email tem de ter pelo menos um '@' e um '.'
                                </small>
                            </div>
                            <button class="btn btn-dark text-white col-md-12" name="submitForgotPassword">Submeter</button>
                            <br />
                            <br />
                            <button class="btn btn-dark text-white col-md-12" name="reset" id="reset" type="reset">Limpar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-public/footer.php';?>