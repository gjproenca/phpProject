<?php
include './../inc/masterpage-public/header.php';
include '../inc/connection.php';

// TODO: update password to new temp GUID and send temp GUID password trough email
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
                                <input class="form-control" id="inputEmail" name="inputEmail" placeholder="Introduza o seu endereço de email" type="email"
                                    pattern="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*" required>
                                <small class="form-text text-muted">
                                    O endereço de email tem de ter pelo menos um '@' e um '.'
                                </small>
                            </div>
                            <button class="btn btn-dark text-white" id="submitForgotPassword" name="submitForgotPassword">Submeter</button>
                            &nbsp;&nbsp;&nbsp;
                            <input class="btn btn-dark text-white" id="resetSignup" type="reset" value="Limpar" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './../inc/masterpage-public/footer.php';?>