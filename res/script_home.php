      <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
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
      <script src="../message/messagerie.js"></script>
      <script>

        function insertTag(startTag, endTag, textareaId, tagType) {
            var field  = document.getElementById(textareaId); 
            var scroll = field.scrollTop;
            field.focus();
                
            if (window.ActiveXObject) { // C'est IE
                var textRange = document.selection.createRange();            
                var currentSelection = textRange.text;
                        
                textRange.text = startTag + currentSelection + endTag;
                textRange.moveStart("character", -endTag.length - currentSelection.length);
                textRange.moveEnd("character", -endTag.length);
                textRange.select();     
            } else { // Ce n'est pas IE
                var startSelection   = field.value.substring(0, field.selectionStart);
                var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
                var endSelection     = field.value.substring(field.selectionEnd);
                        
                field.value = startSelection + startTag + currentSelection + endTag + endSelection;
                field.focus();
                field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);
            } 
            field.scrollTop = scroll; // et on redéfinit le scroll.
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
            }
          },"json");
        }
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
      </script>
      <script>
      AnonymousButton = $("#goToAnonymous");
      removeAnonymousButton = $("#removeAnonymous");
      function goToAnonymous(){
        var req = 1;
        $.post("../check/goToAnonymous.php",{req:req}, function(data){
            if(data.erreur=="no"){
              AnonymousButton.empty();
              AnonymousButton.next().empty();
              removeAnonymousButton.removeClass("btn btn-primary");
              removeAnonymousButton.empty();
              AnonymousButton.empty();
              AnonymousButton.append("<i class='icon-white icon-user'></i> Votre profil est désormais anonyme !");
              AnonymousButton.next().text("Que faire maintenant ?");
              removeAnonymousButton.addClass("btn btn-primary");
              removeAnonymousButton.append("<i class='icon-white icon-unlock'></i> Passer en profil public</div>");
            }
          },"json");
      };
      function goToPublic(){
        var req = 2;
        $.post("../check/goToAnonymous.php",{req:req}, function(data){
            if(data.erreur=="no"){
              AnonymousButton.empty();
              AnonymousButton.append("<i class='icon-white icon-lock'></i> Passer en profil anonyme");
              AnonymousButton.next().empty();
              removeAnonymousButton.removeClass("btn btn-primary");
              removeAnonymousButton.empty();
            }
          },"json");
      };
      </script>
      <script>
        $("#infoPop").hover(function(){$("#infoPop").popover("toggle")});
      </script>
      <script>
        rechercherButton = $("#rechercher");
        inviterButton = $("#inviter");
        inputForm = $("#inputForm");
        iconForm = $("#iconForm");
        rechercherButton.click(function(){
          inputForm.val("Rechercher via pseudo");
          iconForm.removeClass("icon-envelope");
          iconForm.addClass("icon-search");
          rechercherButton.addClass("disabled");
          inviterButton.removeClass("disabled");
        });
        inviterButton.click(function(){
          inputForm.val("Inviter via pseudo");
          iconForm.removeClass("icon-search");
          iconForm.addClass("icon-envelope");
          inviterButton.addClass("disabled");
          rechercherButton.removeClass("disabled");
        });
        inputForm.click(function(){
          this.select();
        });
      </script>
      <script>
        function searchFriend(){
            error = $("#retourRecherche");
            if(inputForm.val() != '' && inputForm.val() != 'Recherche via pseudo')
            {
              var username = $("#inputForm").val();
              error.empty();
              $.post("../check/searchFriend.php",{username:username}, function(data){
                if(data.erreur=="no"){
                  error.append(data.retour);
                }
              },"json");
            }else
            {
              error.empty();
              error.append("<br /><div id='errorValid' style='display:none;' class='alert alert-error span2'>Votre recherche est invalide.</div>");
              $("#errorValid").fadeIn(function(){
                $(this).delay(1500).fadeOut(function(){
                  error.empty().fadeIn();
                });
              });
            }
          return false;
        };
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
                //  $("#publicationFeedback").fadeIn(1000);
                  $("#toutLeMondePublication").empty();
                  $("#toutLeMondePublication").append(data);
                  if(categorie != "Aucune")
                  {
                    $("#categorieEmplacement").empty();
                    $("#categorieEmplacement").append("<i class='icon-globe icon-white'></i> "+ categorie);
                  }
                  $("#emptyPublication").fadeOut();
                  $("#toutLeMondePublicationHide").fadeIn();
                  $("#contenu").val("");
                  location.reload(); 
               },"html");
             }else
             {
                $("#contenu").css("border","solid 2px red")
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
        $("#toutLeMonde").click(function(){
          $("#amis").removeClass("active");
          $("#toutLeMonde").addClass("active");
          $("#titreHome").empty();
          $("#titreHome").append("Publications de tout le monde");
          $("#amisPublication").fadeOut(500);
          $("#toutLeMondePublication").fadeIn(1000);
        });
        $("#amis").click(function(){
          $("#toutLeMonde").removeClass("active");
          $("#amis").addClass("active");
          $("#titreHome").empty();
          $("#titreHome").append("Publications de vos amis");
          $("#toutLeMondePublication").fadeOut(500);
          $("#amisPublication").fadeIn(1000);
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
    </script>

    <script>
      $("#publierVider").click(function()
      {
        $("#contenu").val("");
      });
    </script>

    <script>
      $(document).ready(function(){
      var load = 0;
      $(window).scroll(function()
      {
        var taille_doc = $(document).height();
        var taille_win = $(window).height();
        if(document.documentElement.clientHeight + $(document).scrollTop() >= document.body.offsetHeight)
        {
          load++;
          $.post('../check/takePublication.php',{load:load},function(data){
            $("#newPost").append(data);
          });
        }
      });
    });
      $(document).ready(function(){
      $("#instant").mention({
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
    </script>
    

    <?php
      include("script_navbar.php");
    ?>