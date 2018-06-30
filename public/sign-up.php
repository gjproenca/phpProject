<?php include './../inc/masterpage-public/header.php';?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card text-white p-5 bg-primary">
                    <div class="card-body">
                        <h1 class="mb-4">Registar</h1>
                        <form method="POST" action="" onSubmit="return validate();">
                            <div class="form-group">
                                <label>Nome</label>
                                <input class="form-control" id="inputName" placeholder="Mínimo 3 carateres" type="text" pattern="^[A-Za-zÀ-Úà-ú]{2,}[A-Za-zÀ-Úà-ú\s]*[A-Za-zÀ-Úà-ú]$"
                                    required></input>
                            </div>
                            <div class="form-group">
                                <label>Nome de utilizador</label>
                                <input class="form-control" id="inputUsername" placeholder="Mínimo 8 carateres" type="text" pattern="^\w{8,}$" required></input>
                            </div>
                            <div class="form-group">
                                <label>Senha</label>
                                <input class="form-control" id="inputPassword" placeholder="Mínimo 8 carateres" type="password" pattern="^[^\s].{6,}[^\s]$"
                                    required></input>
                            </div>
                            <div class="form-group">
                                <!-- TODO: javascript confirm password -->
                                <label>Confirmar senha</label>
                                <input class="form-control" id="inputConfirmPassword" placeholder="Mínimo 8 carateres" type="password" required></input>
                            </div>
                            <div class="form-group">
                                <label>Endereço de email</label>
                                <input class="form-control" id="inputEmail" placeholder="Introduza o seu endereço de email" type="email" pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"
                                    required></input>
                            </div>
                            <button class="btn btn-dark text-white" id="submit" type="submit">Submeter</button>
                            <input class="btn btn-dark text-white float-sm-right" id="reset" type="reset" value="Limpar" />
                            <br />
                            <br />
                            <a class="btn btn-dark text-white float-sm-right" id="forgotPassword" href="TODO: forgot-password.aspx">Recuperar senha</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-public/footer.php';?>