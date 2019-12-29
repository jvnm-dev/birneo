<div id="report" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Inscription" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Rapporter un problème</h3>
  </div>
  <div class="modal-body">
    <div id="formBug">
      <label>Type de problème:</label>
      <select id="typeBug">
          <option>Bug</option>
          <option>Erreur fatale</option>
          <option>Indéfini</option>
      </select>
      <label>Donnez un titre au problème</label>
      <input id="titreBug" type="text" placeholder="Titre du problème"/>
      <label>Décrivez le problème en quelques lignes:</label>
      <textarea id="contentBug" style="resize:none;width:90%" rows="5" placeholder="Détails sur le problème..."></textarea>
    </div>
    <div id="bugFeedback" style="display:none;">
      <div class="alert alert-success" >
        <h2>Votre problème a été envoyé</h2>
        <p>Nous allons tenter de le résoudre le plus vite possible.</p>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button id="submitSupport" class="btn btn-block btn-danger">Rapporter le problème</button>
  </div>
</div>