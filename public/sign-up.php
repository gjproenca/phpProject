<?php
include './../inc/masterpage-public/header.php';
include '../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["inputName"];
    $username = $_POST["inputUsername"];
    $password = $_POST["inputPassword"];
    $confirmPassword = $_POST["inputConfirmPassword"];
    $email = $_POST["inputEmail"];

    if ($conn->connect_error) {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Falha na ligação à base de dados, por favor tente mais tarde.</div>';
    } else {
        if ($password !== $confirmPassword) {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Os campos senha não coincidem.</div>';
        } else {
            //SQL query statement TODO: querys
            $sql = "INSERT INTO `user` (`Name`,`Email`,`Subject`,`Message`)
                        VALUES ('$name','$subject','$email','$message')";

            //SQL database query
            if ($conn->query($sql) === true) {
                // TODO: add fade out or slide up aniamtion with jquery
                echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                            Registo efetuado com sucesso.</div>';
            } else {
                echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                            Falha ao enviar a mensagem!</div>';
                //echo "Error: " . $sql . "<br>" . $conn->error; //to check query error
            }
        }

        $conn->close();
    }
}
?>

<div class="py-5 bg-primary text-white">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card text-white p-5 bg-primary">
                <div class="card-body">
                    <h1 class="mb-4">Registar</h1>
                    <form method="POST" action="" onSubmit="return validate();">
                        <div class="form-group">
                            <label>Nome</label>
                            <input class="form-control" id="inputName" name="inputName" placeholder="Mínimo 3 carateres" type="text"
                            pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$" value="<?php if (isset($name)) {
    echo $name;
}
?>" required></input>
                        </div>
                        <div class="form-group">
                            <label>Nome de utilizador</label>
                            <input class="form-control" id="inputUsername" name="inputUsername" placeholder="Mínimo 8 carateres" type="text"
                            pattern="^\w{8,}$" value="<?php if (isset($username)) {
    echo $username;
}
?>" required></input>
                        </div>
                        <div class="form-group">
                            <label>Senha</label>
                            <input class="form-control" id="inputPassword" name="inputPassword" placeholder="Mínimo 8 carateres" type="password"
                            pattern="^[^\s].{6,}[^\s]$" value="<?php if (isset($password)) {
    echo $password;
}
?>" required></input>
                        </div>
                        <div class="form-group">
                            <label>Confirmar senha</label>
                            <input class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="Mínimo 8 carateres" type="password"
                            pattern="^[^\s].{6,}[^\s]$" required></input>
                        </div>
                        <div class="form-group">
                            <label>Endereço de email</label>
                            <input class="form-control" id="inputEmail" name="inputEmail" placeholder="Introduza o seu endereço de email" type="email"
                                pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" value="<?php if (isset($email)) {
    echo $email;
}
?>" required></input>
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