<?php include './../inc/masterpage-public/header.php';?>

<div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card text-white p-5 bg-primary">
                        <div class="card-body">
                            <h1 class="mb-4">Entrar</h1>
                            <div class="form-group">
                                <label>Nome de utilizador</label>
                                <input class="form-control" name="inputUsername" placeholder="Mínimo 8 carateres" type="text"
                                pattern="^\w{8,}$" required></input>
                            </div>
                            <div class="form-group">
                                <label>Senha</label>
                                <input class="form-control" name="inputPassword" placeholder="Mínimo 8 carateres" type="password"
                                pattern="^[^\s].{6,}[^\s]$" required></input>
                            </div>
                            <button class="btn btn-dark text-white" name="signin" onclick="signin_Click"><i class="fa fa-sign-in"></i> Entrar</button>
                            <input class="btn btn-dark text-white float-sm-right" name="resetSignin" type="reset" value="Limpar" />
                            <br />
                            <br />
                            <a class="btn btn-dark text-white float-sm-right" name="forgotPassword" href="./forgot-password.php">Recuperar senha</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-public/footer.php';?>
