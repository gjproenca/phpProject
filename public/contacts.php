<?php
include './../inc/masterpage-public/header.php';
include './../inc/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["inputName"];
    $subject = $_POST["inputSubject"];
    $email = $_POST["inputEmail"];
    $message = $_POST["textAreaMessage"];

    // Check connection
    if ($conn->connect_error) {
        echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
            Falha na ligação à base de dados, por favor tente mais tarde</div>';
    } else {
        //SQL query statement
        $sql = "INSERT INTO `messagepublic` (`Name`,`Email`,`Subject`,`Message`)
            VALUES ('$name','$subject','$email','$message')";

        //SQL database query
        if ($conn->query($sql) === true) {
            // TODO: add fade out or slide up aniamtion with jquery
            echo '<div class="alert alert-success mb-0 rounded-0 text-center" role="alert">
                Mensagem enviada com sucesso</div>';
        } else {
            echo '<div class="alert alert-danger mb-0 rounded-0 text-center" role="alert">
                Falha ao enviar a mensagem</div>';
            //echo "Error: " . $sql . "<br>" . $conn->error; //to check query error
        }

        $conn->close();
    }
}
?>

<div class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row">

            <!--Map-->
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3112.1051384428206!2d-9.149991018320703!3d38.73834949593829!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa6833f2027bb59d4!2sCiteforma+-+Centro+de+Forma%C3%A7%C3%A3o+Profissional+dos+Trabalhadores+de+Escrit%C3%B3rio%2C+Com%C3%A9rcio%2C+Servi%C3%A7os+e+Novas+Tecnologias!5e0!3m2!1sen!2spt!4v1528056320966"
                        width="100%" height="100%" frameborder="0" style="border: 0" allowfullscreen></iframe>
            </div>

            <!--Form-->
            <div class="col-md-6">
                <form method="POST" action="">
                    <h1 class="mb-4 text-center text-white">Contactos</h1>
                    <div class="form-group">
                        <label for="InputName">Nome</label>
                        <input class="form-control" name="inputName" type="text" placeholder="Introduza o seu nome" MaxLength="100"
                            pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$" required>
                        <small class="form-text text-muted">
                            O nome tem de conter no mínimo 3 carateres
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="InputName">Assunto</label>
                        <input class="form-control" name="inputSubject" type="text" placeholder="Introduza o assunto" MaxLength="70"
                            pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$" required>
                        <small class="form-text text-muted">
                            O assunto tem de conter no mínimo 3 carateres
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail1">Endereço de email</label>
                        <input class="form-control" name="inputEmail" type="email" placeholder="Introduza o seu endereço de email" MaxLength="70"
                            pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" required>
                        <small class="form-text text-muted">
                            O endereço de email tem de ter pelo menos um '@' e um '.'
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
                    <button class="btn btn-dark text-white" name="submitContacts" OnClick="submit_Click">Submeter</button>
                    <input class="btn btn-dark text-white float-sm-right" id="resetContacts" type="reset" value="Limpar">
                </form>
            </div>

        </div>
    </div>
</div>

<?php include './../inc/masterpage-public/footer.php';?>
