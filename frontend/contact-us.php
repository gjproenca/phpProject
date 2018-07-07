<?php
include './../inc/masterpage-frontend/header.php';
include './../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["userId"];
    $subject = $_POST["inputSubject"];
    $message = $_POST["textAreaMessage"];

    // Check connection
    if ($conn->connect_error) {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Falha na ligação à base de dados, por favor tente mais tarde</div>';
    } else {
        //SQL query statement
        $sql = "INSERT INTO `messagefrontend` (`UserId`,`Subject`,`Message`)
            VALUES ('$userId','$subject','$message')";

        //SQL database query
        if ($conn->query($sql) === true) {
            echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                Mensagem enviada com sucesso</div>';
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao enviar a mensagem</div>';
        }

        $conn->close();
    }
}
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="p-5 card text-white bg-primary border-secondary">

                    <!--Form-->
                    <div class="card-body">
                        <form method="POST" action="">
                            <h1 class="mb-4 text-center text-white">Contactos</h1>
                            <div class="form-group">
                                <label for="InputName">Assunto</label>
                                <input class="form-control" name="inputSubject" type="text" placeholder="Introduza o assunto" MaxLength="70" pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$"
                                    required>
                                <small class="form-text text-muted">
                                    O assunto tem de conter no mínimo 3 carateres
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="Textarea">Mensagem</label>
                                <textarea class="form-control" name="textAreaMessage" Rows="3" placeholder="Introduza a sua mensagem, mínimo 20 carateres, máximo 250"
                                    minlength="20" maxlength="250" required></textarea>
                                <small class="form-text text-muted">
                                    A mensagem tem de conter no mínimo 20 carateres e no máximo 250 carateres
                                </small>
                            </div>
                            <button class="btn btn-dark text-white col-md-12" name="submitContacts" OnClick="submit_Click">Submeter</button>
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

<?php include './../inc/masterpage-frontend/footer.php'?>