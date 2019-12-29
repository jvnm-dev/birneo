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
          function choix(id,type){
            id_debat = id;
            type = type;
            $.post("../check/choice.php",{type:type,id_debat:id_debat}, function(data){
                if(data.erreur=="no"){
                  location.reload();
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
          $("#addCommentaire").keyup(function(e) {
            if(e.keyCode == 13 && doublon) {
              doublon = false;
              content = $("#addCommentaire").val();
              id_publication = id; 
              loader = $("#commentLoader");
              loader.show();
              $.post("../check/publierCommentaireDebat.php",{content:content,id_publication:id_publication}, function(data){
              if(data.erreur=="no"){

                  $("#CommentaireFeedback").fadeIn(1000);
                  $("#addCommentaire").val("");                        
                  $("#commentaireDiv").append(data.comment);
                  doublon = true;
                  $("#addCommentaire").blur();
                  loader.fadeOut(function(){

                      $("#commentLoader").empty();
                      $("#commentLoader").append("<i class='icon-black icon-ok'></i>");
                      $("#commentLoader").fadeIn();

                });

                $("#commentCount"+id).text(data.nombre+1);

              }
             },"json");
            }
          });
        }
        function removeComment(id)
        {
          $.post("../check/supprimerCommentaireDebat.php",{id:id}, function(data){
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

    <script>
      $("#sendDebat").click(function(){
        $("#addDebat").submit();
      });
    </script>
    <?php
      include("script_navbar.php");
    ?>