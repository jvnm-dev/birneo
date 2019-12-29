<div id="addPhoto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Info" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Ajouter une photo au portfolio</h3>
  </div>
  <div class="modal-body">
    <div id="addPhoto" class="well" align="center" style="">
      <div id="addPhotoReply">
      </div>
      <form id="addPhotoForm" method="POST" enctype="multipart/form-data" action="../check/envoyerPhoto.php">
        <input type="file" name="photo" id="photo" class="input-block-level">
        <br />
        <textarea name="description" id="description" style="width:80%;" placeholder="Description pour cette photo"></textarea>
      <div class="pull-right"></div><br />
    </div>
   
  <div class="modal-footer">
    <button id="sendPhoto" type="submit" class="btn btn-large btn-primary birneo_unselectable"><i class="icon-white icon-plus"></i> Ajouter</button></form><button data-dismiss="modal" class="btn btn-large pull-right"><i class="icon-remove"></i> Fermer</button>
  </div>
</div>
</div>