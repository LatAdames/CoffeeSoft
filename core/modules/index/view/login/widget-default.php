<div class="modal-dialog text-center">
    <div class="col-sm-8 main-section">
        <div class="modal-content">
            <div class="col-12 user-img">
                 <img src="CoffeeSoft-Logo.jpg" th:src="@{/CoffeeSoft-Logo.jpg}"/>
            </div>
            <form class="col-12" action="index.php?view=processlogin"  method="post" name="iniciar_sesion" id="iniciar_sesion">
                <div class="form-group" id="user-group">
                    <input type="text" class="form-control" placeholder="Nombre de usuario" name="mail" id="username"/>
                </div>
                <div class="form-group" id="contrasena-group">
                    <input type="password" class="form-control" placeholder="Contraseña" name="password" id="password"/>
                </div>
                <button type="submit" class="btn btn-primary login"><i class="fas fa-sign-in-alt"></i>  Ingresar </button>
            </form>
            <div id="error"></div>
        </div>
    </div>
</div>