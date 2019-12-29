<div id="notification" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Inscription" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Notifications</h3>
  </div>
  <div class="modal-body">
    <?php get_notifications(); ?>
  </div>
  <div class="modal-footer">
    <button id="submitBug" class="btn btn-block btn-danger">Marquer tout comme lu</button>
  </div>
</div>