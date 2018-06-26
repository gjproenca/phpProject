<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link type="text/css" href="../bootstrap-4-1-1-dist/css/bootstrap.min.css" rel="stylesheet">

        <title>Webware</title>
    </head>
    <body>
        <div> <!--body container-->

            <nav class="navbar navbar-expand-md bg-primary navbar-dark">
                <div class="container">
                    <asp:HyperLink class="navbar-brand" ID="HyperLink1" runat="server" NavigateUrl="~/default.aspx">Webware</asp:HyperLink>
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <asp:HyperLink class="nav-link" ID="contacts" runat="server" NavigateUrl="~/frontend/contact.aspx"><i class="fa fa-envelope"></i> Contactos</asp:HyperLink>
                            </li>
                        </ul>
                        <asp:HyperLink class="btn navbar-btn btn-dark ml-2 text-white" ID="signin" runat="server" NavigateUrl="~/frontend/signin.aspx"><i class="fa fa-sign-in"></i> Entrar</asp:HyperLink>
                        <asp:HyperLink class="btn navbar-btn btn-dark ml-2 text-white" ID="signup" runat="server" NavigateUrl="~/frontend/signup.aspx"><i class="fa fa-user-plus"></i> Registar</asp:HyperLink>
                    </div>
                </div>
            </nav>