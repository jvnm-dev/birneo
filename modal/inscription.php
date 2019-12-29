<div id="register" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Inscription" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Inscription sur Birneo</h3>
    <br />
    <!--<center>Tu as un compte Facebook ? <a href="test.php"><img src="assets/img/facebook.png" alt="Inscription avec Facebook" /></a></center>-->
  </div>
  <div class="modal-body">
    <div id="errorContent">
    </div>
    <form method="POST" action="check/register.php">
      <input id="name" name="name" type="text" placeholder="Nom" required/>
      <input id="surname" name="surname" type="text" placeholder="Prénom" required/>
      <input id="username" name="username" type="text" placeholder="Nom d'utilisateur" required/>
      <input id="email" name="email" type="email" placeholder="Adresse e-mail" required/>
      <input id="password" name="password" type="password" placeholder="Mot de passe" required/>
      <input id="repeatpassword" name="repeatpassword" type="password" placeholder="Répétez le mot de passe" required/>
      <select id="sex" name="sex">
        <option>Je suis un homme</option>
        <option>Je suis une femme</option>
      </select>
      <select id="situation" name="situation">
        <option>Célibataire</option>
        <option>En couple</option>
        <option>Marié(e)</option>
        <option>Divorcé(e)</option>
        <option>Veuf(ve)</option>
        <option>Ne pas préciser</option>
      </select>
      <input id="job" name="job" type="text" placeholder="Emploi" required />
      <textarea id="description" name="description" placeholder="Une brève description de vous" rows="3" class="span4"></textarea>
  </div>
  <div class="modal-footer">
  <p style="text-align:center">En cliquant sur "s'inscrire" vous acceptez les <a href="<?php echo $link; ?>conditions" target="_blank">conditions d'utilisation</a>.</p>
    <button id="registerSubmit" class="btn btn-large btn-block btn-danger">S'inscrire</button>
    </form>
  </div>
</div>
<div id="registerFacebook" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Inscription" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Inscription sur Birneo à l'aide de Facebook</h3>
    <br />
    <center>Tu as un compte facebook ?<br /><a href="test.php"><img src="assets/img/facebook.png" alt="Inscription avec Facebook" /></a></center>
  </div>
  <div class="modal-body">
    <div id="errorContent">
    </div>
    <form method="POST" action="check/register.php">
      <input id="name" name="name" type="text" placeholder="Nom" required/>
      <input id="surname" name="surname" type="text" placeholder="Prénom" required/>
      <input id="username" name="username" type="text" placeholder="Nom d'utilisateur" required/>
      <input id="email" name="email" type="email" placeholder="Adresse e-mail" required/>
      <input id="password" name="password" type="password" placeholder="Mot de passe" required/>
      <input id="repeatpassword" name="repeatpassword" type="password" placeholder="Répétez le mot de passe" required/>
      <select id="sex" name="sex">
        <option>Je suis un homme</option>
        <option>Je suis une femme</option>
      </select>
      <select id="situation" name="situation">
        <option>Célibataire</option>
        <option>En couple</option>
        <option>Marié(e)</option>
        <option>Divorcé(e)</option>
        <option>Veuf(ve)</option>
        <option>Ne pas préciser</option>
      </select>
      <input id="job" name="job" type="text" placeholder="Emploi" required />
        <textarea id="description" name="description" placeholder="Une brève description sur vous" rows="3" class="span4"></textarea>
  </div>
  <div class="modal-footer">
    
    <button id="registerSubmit" class="btn btn-large btn-block btn-danger">S'inscrire</button>
    </form>
  </div>
</div>