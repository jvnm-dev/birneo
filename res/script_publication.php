      <script src="../assets/js/jquery.js"></script>
      <script src="../assets/js/bootstrap-transition.js"></script>
      <script src="../assets/js/bootstrap-alert.js"></script>
      <script src="../assets/js/bootstrap-modal.js"></script>
      <script src="../assets/js/bootstrap-dropdown.js"></script>
      <script src="../assets/js/bootstrap-scrollspy.js"></script>
      <script src="../assets/js/bootstrap-tab.js"></script>
      <script src="../assets/js/bootstrap-tooltip.js"></script>
      <script src="../assets/js/bootstrap-popover.js"></script>
      <script src="../assets/js/bootstrap-button.js"></script>
      <script src="../assets/js/bootstrap-collapse.js"></script>
      <script src="../assets/js/bootstrap-carousel.js"></script>
      <script src="../assets/js/bootstrap-typeahead.js"></script>
      <script src="../assets/js/mention.js"></script>
      <script>
        function addlike(id,nbre){
            id_publication = id;
            $("#like"+id).removeClass("icon-heart-empty");
            $("#like"+id).addClass("icon-heart");
            $.post("../check/addlike.php",{id_publication:id_publication}, function(data){
                if(data.erreur=="no"){
                  $("#like"+id).removeClass("icon-heart-empty");
                  $("#like"+id).addClass("icon-heart");
                  $("#vote"+id).empty();
                  $("#vote"+id).append(parseInt(nbre+1));
                }else
                {
                  $("#error"+id).hide();
                  $("#error"+id).empty();
                  $("#error"+id).append("<div class='span3 alert alert-error'>Vous avez déjà aimé cette publication !</div>");
                  $("#error"+id).fadeIn();
                  $("#error"+id).delay(1500).fadeOut();
                }
            },"json");
          };
          function removeLike(id){
            $("#like"+id).removeClass("icon-heart");
            $("#like"+id).addClass("icon-heart-empty");
          };

          function removeComment(id)
          {
            $.post("../check/supprimerCommentaire.php",{id:id}, function(data){
              if(data.erreur=="no"){
                $("#commentaire"+id).fadeOut();
              }
            },"json");
          }

          function signaler(id,id_poster,type)
          {
              id_post = id;
              id_poster = id_poster;
              type = type;
              $.post("../check/signaler.php",{id_post:id_post,id_poster:id_poster,type:type}, function(data){
                    if(data.erreur=="no"){
                      console.log("ok");
                    }
                },"json");
          }

          function removePost(id)
          {
            $.post("../check/supprimerPublication.php",{id:id}, function(data){
              if(data.erreur=="no"){
                $("#publication"+id).fadeOut();
                location.reload();
              }
            },"json");
          }
      </script>
      <script>
        $("#infoPop").hover(function(){$("#infoPop").popover("toggle")});
      </script>
      <script>
        $("#publierSubmit").click(function(){
            form = $("#publier");
            content = $("#contenu").val();
            categorie = $("#categorie").val();
             $("#publicationFeedback").hide();
             $("#publicationFeedback").hide();
             if(content != '')
             {
               $.post("../check/publierPublication.php",{content:content,categorie:categorie}, function(data){
                if(data.erreur=="no"){
                  $("#publicationFeedback").fadeIn(1000);
                  console.log(categorie);
                }
               },"json");
             }
        });
        $("#publierVider").click(function()
        {
          $("#contenu").val("");
        });
      </script>
      <script>
        $("#searchFriend").focus(function(){
        $("#searchFriend").popover();
        }).on("mouseleave",function(){
          $("#searchFriend").popover("hide");
        });
        $("[name=addCommentaire]").focus(function(){
        $("[name=addCommentaire]").popover();
        }).on("mouseleave",function(){
          $("[name=addCommentaire]").popover("hide");
        });
      </script>
      <script>

        var doublon = true;

        function addComment(id)
        {
          $("#addCommentaire"+id).keyup(function(e) {
            if(e.keyCode == 13 && doublon) {
              doublon = false;
              content = $("#addCommentaire"+id).val();
              id_publication = id; 
              loader = $("#commentLoader"+id);
              loader.show();
              $.post("../check/publierCommentaire.php",{content:content,id_publication:id_publication}, function(data){
              if(data.erreur=="no"){

                  $("#CommentaireFeedback"+id).fadeIn(1000);
                  $("#addCommentaire"+id).val("");                        
                  $("#commentaireDiv"+id).append(data.comment);
                  doublon = true;
                  $("#addCommentaire"+id).blur();
                  loader.fadeOut(function(){

                      $("#commentLoader"+id).empty();
                      $("#commentLoader"+id).append("<i class='icon-black icon-ok'></i>");
                      $("#commentLoader"+id).fadeIn();

                });

                $("#commentCount"+id).empty();
                data.nombre = parseInt(data.nombre);
                $("#commentCount"+id).text(data.nombre+1);

              }
             },"json");
            }
          });
        }
        function removeComment(id)
        {
          $.post("../check/supprimerCommentaire.php",{id:id}, function(data){
            if(data.erreur=="no"){

             $("#commentaire"+id).fadeOut();

            }
          },"json");
        }

      </script>
      <script>
        $("#removeComment").click(function(){
          alert("kikou");
        });
      </script>
      <script>
      $(document).ready(function(){
        $("#search").mention({
          users: [
          <?php
              $mentionquery = $bdd->query("SELECT * FROM users");
              foreach($mentionquery as $row)
                {
                ?>
                  {
                    name: "<?php echo $row['surname'],' ',$row['name']; ?>",
                    username: "<?php echo $row['username'] ?>",
                  },
                <?php
                }
          ?>
          ]
        });
    });

    function unfollowpublication(id)
    {
      $.post("../check/unFollowPublication.php",{id:id}, function(data){
            if(data.erreur=="no"){

             $("#commentaire"+id).fadeOut();

            }
      },"json");

      $("#unfollow").fadeOut();
    }
    </script>
    <?php
      include("script_navbar.php");
    ?>