<div id="lancerDebat" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Info" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Lancer un débat</h3>
  </div>
  <div class="modal-body">
    <div id="addPhoto">
      <div id="addPhotoReply">
      </div>
      <form id="addDebat" method="POST" enctype="multipart/form-data" action="<?php echo $link; ?>check/lancerDebat.php">
        <input name="titre" id="titre" type="text" placeholder="Titre du débat"/>
        <br />
        <p class="label label-important">Dans la description, veuillez ne pas faire de saut de ligne. (Espaces autorisés)</p>
        <textarea name="contenu" id="contenu" style="width:80%;" rows="10" placeholder="Description du sujet"></textarea>
      <div class="pull-right"></div><br />
    </div>
   
  <div class="modal-footer">
    <a id="sendDebat" type="submit" class="btn btn-large btn-primary birneo_unselectable"><i class="icon-white icon-comment"></i> Lancer le débat</a></form><button data-dismiss="modal" class="btn btn-large pull-right"><i class="icon-remove"></i> Fermer</button>
  </div>
</div>
</div>