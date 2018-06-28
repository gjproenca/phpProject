<?php include './../inc/masterpage-public/header.php'; ?>

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
                <!--TODO: form-->
                <form method="post" action="">
                    <h1>Contacte-nos</h1>
                    <p>Obrigado pelo seu interesse, responderemos assim que pudermos</p>
                    <div class="form-group">
                        <label for="InputName">Nome</label>
                        <asp:TextBox class="form-control" ID="textBoxName" runat="server" TextMode="SingleLine" placeholder="Introduza o seu nome" MaxLength="100"></asp:TextBox>
                        <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ErrorMessage="Campo obrigatório!" ControlToValidate="textBoxName"></asp:RequiredFieldValidator>
                    </div>
                    <div class="form-group">
                        <label for="InputEmail1">Endereço de email</label>
                        <asp:TextBox type="email" class="form-control" ID="textBoxEmail" runat="server" placeholder="Introduza o seu endereço de email" MaxLength="70"></asp:TextBox>
                        <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" ErrorMessage="Campo obrigatório!" ControlToValidate="textBoxEmail" CssClass="auto-style1"></asp:RequiredFieldValidator>
                        &nbsp;&nbsp;&nbsp;
                        <asp:RegularExpressionValidator ID="RegularExpressionValidator1" runat="server" ErrorMessage="Endereço de email inválido!" ControlToValidate="textBoxEmail" ValidationExpression="\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*"></asp:RegularExpressionValidator>
                    </div>
                    <div class="form-group">
                        <label for="Textarea">Mensagem</label>
                        <asp:TextBox class="form-control" ID="textBoxMessage" Rows="3" runat="server" placeholder="Introduza a sua mensagem, mínimo 20 carateres, máximo 250" TextMode="MultiLine"></asp:TextBox>
                        <asp:RequiredFieldValidator ID="RequiredFieldValidator3" runat="server" ErrorMessage="Campo obrigatório!" ControlToValidate="textBoxMessage"></asp:RequiredFieldValidator>
                    </div>
                    <asp:LinkButton class="btn btn-dark text-white" ID="submitContacts" runat="server" OnClick="submit_Click">Submeter</asp:LinkButton>
                    <input class="btn btn-dark text-white float-sm-right" id="resetContacts" type="reset" value="Limpar" />
                </form>
            </div>

        </div>
    </div>
</div>

<?php include './../inc/masterpage-public/footer.php'; ?>
