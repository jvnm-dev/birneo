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
      <script src="../assets/js/bootstrap-lightbox.js"></script>
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

        function addBold(type,id)
        {
          if(type == 1)
          {
            $("#contenu").append("[b]Texte en gras[/b]");
          }else
          {
            $("#addCommentaire"+id).append("[b]Texte en gras[/b]");
          }
        }

        function addQuote(type,id)
        {
          if(type == 1)
          {
            $("#contenu").append("[quote]Citation[/quote]");
          }else
          {
            $("#addCommentaire"+id).append("[quote]Citation[/quote]");
          }
        }

        function addItalic(type,id)
        {
          if(type == 1)
          {
            $("#contenu").append("[i]Texte en italique[/i]");
          }else
          {
            $("#addCommentaire"+id).append("[i]Texte en italique[/i]");
          }
        }

        function addUnderline(type,id)
        {
          if(type == 1)
          {
            $("#contenu").append("[u]Texte sougliné[/u]");
          }else
          {
            $("#addCommentaire"+id).append("[u]Texte sougliné[/u]");
          }
        }

        function addColor(type,id)
        {
          if(type == 1)
          {
            $("#contenu").append("[color=VotreCouleurEnAnglais]Texte en couleur[/color]");
          }else
          {
            $("#addCommentaire"+id).append("[color=VotreCouleurEnAnglais]Texte en couleur[/color]");
          }
        }

        function addProgress(type,id)
        {
          if(type == 1)
          {
            $("#contenu").append("[progress=50%]Texte en dessous de la barre de progression[/progress]");
          }else
          {
            $("#addCommentaire"+id).append("[progress=50%]Texte en dessous de la barre de progression[/progress]");
          }
        }

        function addVimeo(type,id)
        {
          if(type == 1)
          {
            $("#contenu").append("[vimeo]Texte en dessous de la barre de progression[/vimeo]");
          }else
          {
            $("#addCommentaire"+id).append("[vimeo]Texte en dessous de la barre de progression[/vimeo]");
          }
        }

        // Bloquer Enter

        $('#name').keyup(function(e) { //remplacez {id_img} par l'id de votre image
          if(e.keyCode == 13) {
                e.preventDefault();
           }
        });

        $('#surname').keyup(function(e) { //remplacez {id_img} par l'id de votre image
          if(e.keyCode == 13) {
                e.preventDefault();
           }
        });

        $('#job').keyup(function(e) { //remplacez {id_img} par l'id de votre image
          if(e.keyCode == 13) {
                e.preventDefault();
           }
        });

        $('#situation').keyup(function(e) { //remplacez {id_img} par l'id de votre image
          if(e.keyCode == 13) {
                e.preventDefault();
           }
        });

        $('#description').keyup(function(e) { //remplacez {id_img} par l'id de votre image
          if(e.keyCode == 13) {
                e.preventDefault();
           }
        });

        $('#oldpassword').keyup(function(e) { //remplacez {id_img} par l'id de votre image
          if(e.keyCode == 13) {
                e.preventDefault();
           }
        });
        
        $('#newpassword').keyup(function(e) { //remplacez {id_img} par l'id de votre image
          if(e.keyCode == 13) {
                e.preventDefault();
           }
        });

        //


        $("#changeNameButton").click(function(){
          $("#changeName").toggle(function()
            {
              $("#changeName").fadeIn();
              $("#changeNameButton").addClass("disabled");
            });
          $("#closeChangeName").click(function(){
            $("#changeName").fadeOut();
            $("#changeNameButton").removeClass("disabled");
            $("#changeNameReply").empty();
            $("#sendChangeName").removeClass("disabled");
          });
          $("#sendChangeName").click(function(){
              $("#changeNameReply").empty();
              $("#changeNameReply").append("Vérification...");
              $("#sendChangeName").addClass("disabled");
              var name = $("#name").val();
              var surname = $("#surname").val();
              if(name != '')
              {
                if(surname != '')
                {
                  form = $("#changeNameForm");
                  url = form.attr("action");
                  $.post(url,{name:name,surname:surname}, function(data){
                    if(data.erreur=="no"){
                      $("#changeNameReply").empty();
                      $("#changeNameReply").append(data.retour).delay(2500).fadeOut(1000, function(){
                        $(this).empty().fadeIn();
                      });
                      $("#sendChangeName").removeClass("disabled");
                    }
                  },"json");
                  return false;
                }else
                {
                  $("#changeNameReply").empty();
                  $("#changeNameReply").append("<div class='alert alert-error'>Vous devez remplir tout les champs</div>");
                  $("#sendChangeName").removeClass("disabled");
                  return false;
                }
              }else
              {
                $("#changeNameReply").empty();
                $("#changeNameReply").append("<div class='alert alert-error'>Vous devez remplir tout les champs</div>");
                $("#sendChangeName").removeClass("disabled");
                return false;
              }
          });
        });

        $("#changeSexButton").click(function(){
          $("#changeSex").toggle(function()
            {
              $("#changeSex").fadeIn();
              $("#changeSexButton").addClass("disabled");
            });
          $("#closeChangeSex").click(function(){
            $("#changeSex").fadeOut();
            $("#changeSexButton").removeClass("disabled");
          });
          $("#sendChangeSex").click(function(){
              $("#changeSexReply").empty();
              $("#changeSexReply").append("Vérification...");
              $("#sendChangeSex").addClass("disabled");
              var sex = $("#sex").val();
              if(sex != '')
              {
                  form = $("#changeSexForm");
                  url = form.attr("action");
                  $.post(url,{sex:sex}, function(data){
                    if(data.erreur=="no"){
                      $("#changeSexReply").empty();
                      $("#changeSexReply").append(data.retour).delay(2500).fadeOut(1000, function(){
                        $(this).empty().fadeIn();
                      });
                      $("#sendChangeSex").removeClass("disabled");
                    }
                  },"json");
                  return false;
                }else
                {
                  $("#changeSexReply").empty();
                  $("#changeSexReply").append("<div class='alert alert-error'>Vous devez remplir tout les champs</div>");
                  $("#sendChangeSex").removeClass("disabled");
                  return false;
                }
          });
        });

        $("#changeJobButton").click(function(){
          $("#changeJob").toggle(function()
            {
              $("#changeJob").fadeIn();
              $("#changeJobButton").addClass("disabled");
            });
          $("#closeChangeJob").click(function(){
            $("#changeJob").fadeOut();
            $("#changeJobButton").removeClass("disabled");
          });
          $("#sendChangeJob").click(function(){
              $("#changeJobReply").empty();
              $("#changeJobReply").append("Vérification...");
              $("#sendChangeJob").addClass("disabled");
              var job = $("#job").val();
              if(job != '')
              {
                  form = $("#changeJobForm");
                  url = form.attr("action");
                  $.post(url,{job:job}, function(data){
                    if(data.erreur=="no"){
                      $("#changeJobReply").empty();
                      $("#changeJobReply").append(data.retour).delay(2500).fadeOut(1000, function(){
                        $(this).empty().fadeIn();
                      });
                      $("#sendChangeJob").removeClass("disabled");
                    }
                  },"json");
                  return false;
                }else
                {
                  $("#changeJobReply").empty();
                  $("#changeJobReply").append("<div class='alert alert-error'>Vous devez remplir le champ</div>");
                  $("#sendChangeJob").removeClass("disabled");
                  return false;
                }
          });
        });

        function sendTheme(id)
        {
          $("#theme"+id).submit();
        }
        

        $("#changeSituationButton").click(function(){
          $("#changeSituation").toggle(function()
            {
              $("#changeSituation").fadeIn();
              $("#changeSituationButton").addClass("disabled");
            });
          $("#closeChangeSituation").click(function(){
            $("#changeSituation").fadeOut();
            $("#changeSituationButton").removeClass("disabled");
          });
          $("#sendChangeSituation").click(function(){
              $("#changeSituationReply").empty();
              $("#changeSituationReply").append("Vérification...");
              $("#sendChangeSituation").addClass("disabled");
              var situation = $("#situation").val();
              if(situation != '')
              {
                  form = $("#changeSituationForm");
                  url = form.attr("action");
                  $.post(url,{situation:situation}, function(data){
                    if(data.erreur=="no"){
                      $("#changeSituationReply").empty();
                      $("#changeSituationReply").append(data.retour).delay(2500).fadeOut(1000, function(){
                        $(this).empty().fadeIn();
                      });
                      $("#sendChangeSituation").removeClass("disabled");
                    }
                  },"json");
                  return false;
                }else
                {
                  $("#changeSituationReply").empty();
                  $("#changeSituationReply").append("<div class='alert alert-error'>Vous devez remplir le champ</div>");
                  $("#sendChangeSituation").removeClass("disabled");
                  return false;
                }
          });
        });

        $("#changeDescriptionButton").click(function(){
          $("#changeDescription").toggle(function()
            {
              $("#changeDescription").fadeIn();
              $("#changeDescriptionButton").addClass("disabled");
            });
          $("#closeChangeDescription").click(function(){
            $("#changeDescription").fadeOut();
            $("#changeDescriptionButton").removeClass("disabled");
          });
          $("#sendChangeDescription").click(function(){
              $("#changeDescriptionReply").empty();
              $("#changeDescriptionReply").append("Vérification...");
              $("#sendChangeDescription").addClass("disabled");
              var description = $("#description").val();
              if(description != '')
              {
                  form = $("#changeDescriptionForm");
                  url = form.attr("action");
                  $.post(url,{description:description}, function(data){
                    if(data.erreur=="no"){
                      $("#changeDescriptionReply").empty();
                      $("#changeDescriptionReply").append(data.retour).delay(2500).fadeOut(1000, function(){
                        $(this).empty().fadeIn();
                      });
                      $("#sendChangeDescription").removeClass("disabled");
                    }
                  },"json");
                  return false;
                }else
                {
                  $("#changeDescriptionReply").empty();
                  $("#changeDescriptionReply").append("<div class='alert alert-error'>Vous devez remplir le champ</div>");
                  $("#sendChangeDescription").removeClass("disabled");
                  return false;
                }
          });
          
        });
        $("#changePasswordButton").click(function(){
          $("#changePassword").toggle(function()
            {
              $("#changePassword").fadeIn();
              $("#changePasswordButton").addClass("disabled");
            });
          $("#closeChangePassword").click(function(){
            $("#changePassword").fadeOut();
            $("#changePasswordButton").removeClass("disabled");
          });
          $("#sendChangePassword").click(function(){
              $("#changePasswordReply").empty();
              $("#changePasswordReply").append("Vérification...");
              $("#sendChangePassword").addClass("disabled");
              var oldpassword = $("#oldpassword").val();
              var newpassword = $("#newpassword").val();
              if(oldpassword != '' && newpassword != '')
              {
                  form = $("#changePasswordForm");
                  url = form.attr("action");
                  $.post(url,{oldpassword:oldpassword,newpassword:newpassword}, function(data){
                    if(data.erreur=="no"){
                      $("#changePasswordReply").empty();
                      $("#changePasswordReply").append(data.retour).delay(2500).fadeOut(1000, function(){
                        $(this).empty().fadeIn();
                      });
                      $("#sendChangePassword").removeClass("disabled");
                    }else if(data.erreur=="code1"){
                      $("#changePasswordReply").empty();
                      $("#changePasswordReply").append(data.retour).delay(2500).fadeOut(1000, function(){
                        $(this).empty().fadeIn();
                      });
                      $("#sendChangePassword").removeClass("disabled");
                    }
                  },"json");
                  return false;
                }else
                {
                  $("#changePasswordReply").empty();
                  $("#changePasswordReply").append("<div class='alert alert-error'>Vous devez remplir les champs</div>");
                  $("#sendChangePassword").removeClass("disabled");
                  return false;
                }
          });
          
        });

      $("#changeAvatarButton").click(function(){
          $("#changeAvatar").toggle(function()
            {
              $("#changeAvatar").fadeIn();
              $("#changeAvatarButton").addClass("disabled");
            });
          $("#closeChangeAvatar").click(function(){
            $("#changeAvatar").fadeOut();
            $("#changeAvatarButton").removeClass("disabled");
          });
          $("#sendChangeAvatar").click(function(){
              $("#changeAvatarReply").empty();
              $("#changeAvatarReply").append("Vérification...");
              $("#sendChangeAvatar").addClass("disabled");
              $("#changeAvatarForm").submit();
          });
          
        });

      $("#changeCoverButton").click(function(){
          $("#changeCover").toggle(function()
            {
              $("#changeCover").fadeIn();
              $("#changeCoverButton").addClass("disabled");
            });
          $("#closeChangeCover").click(function(){
            $("#changeCover").fadeOut();
            $("#changeCoverButton").removeClass("disabled");
          });
          $("#sendChangeCover").click(function(){
              $("#changeCoverReply").empty();
              $("#changeCoverReply").append("Vérification...");
              $("#sendChangeCover").addClass("disabled");
              $("#changeCoverForm").submit();
          });
          
        });
      </script>
      <script>
        $( document ).ready(function() {
            var img = $("img");
            img.fadeIn();
        });
      </script>
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
      </script>
      <script>
      function enleverAmisOver()
      {
          $("#enleverAmis").removeClass("disabled");
          $("#enleverAmis").addClass("btn-danger");
          $("#enleverAmis").empty();
          $("#enleverAmis").append("<i class='icon-trash'></i> Retirer de ma liste d'amis");
      }
      
      function enleverAmisOut()
      {
          $("#enleverAmis").removeClass("btn-danger");
          $("#enleverAmis").addClass("disabled");
          $("#enleverAmis").empty();
          $("#enleverAmis").append("<i class='icon-ok'></i> Amis");
      }  
        



        
        function sendFriendRequest()
        {
          var id_exp = "<?php echo $id_exp; ?>";
          var id_dest = "<?php echo $id_dest; ?>";
          $.post("../check/sendFriendRequest.php",{id_exp:id_exp,id_dest:id_dest}, function(data){
            if(data.erreur=="no"){
             $("#sendFriendRequest").empty();
              $("#sendFriendRequest").append("Demande envoyée");
              $("#sendFriendRequest").removeClass("btn-danger");
              $("#sendFriendRequest").addClass("disabled");
              this.enabled=false;
            }
          },"json");
        };
        function removeFriends()
        {
          var id_exp = "<?php echo $id_exp; ?>";
          var id_dest = "<?php echo $id_dest; ?>";
          $.post("../check/removeFriends.php",{id_exp:id_exp,id_dest:id_dest}, function(data){
            if(data.erreur=="no"){
              $("#enleverAmis").empty("Amitié rompue");
              $("#enleverAmis").append("Amitié rompue");
              $("#enleverAmis").removeClass("btn-primary");
              $("#enleverAmis").addClass("disabled");
              location.reload();
              this.enabled=false;
            }
          },"json");
        };
        function cancelRequestFriends()
        {
          var id_exp = "<?php echo $id_exp; ?>";
          var id_dest = "<?php echo $id_dest; ?>";
          $.post("../check/removeFriends.php",{id_exp:id_exp,id_dest:id_dest}, function(data){
            if(data.erreur=="no"){
              $("#cancelRequestFriends").val("Demande annulée");
              $("#cancelRequestFriends").removeClass("btn-success");
              $("#cancelRequestFriends").addClass("disabled");
              this.enabled=false;
              location.reload();
            }
          },"json");
        };
        function acceptRequestFriends()
        {
          var id_exp = "<?php echo $id_exp; ?>";
          var id_dest = "<?php echo $id_dest; ?>";
          id_exp = parseInt(id_exp);
          id_dest = parseInt(id_dest);
          $.post("../check/acceptFriends.php",{id_exp:id_exp,id_dest:id_dest}, function(data){
            if(data.erreur=="no"){
              $("#acceptOrDecline").empty();
              $("#acceptOrDecline").removeClass("btn-danger");
              $("#acceptOrDecline").addClass("disabled");
              $("#acceptOrDecline").append('<i class="icon-ok"></i>');
              this.enabled=false;
              location.reload();
            }
          },"json");
        };
        function declineRequestFriends()
        {
          var id_exp = "<?php echo $id_exp; ?>";
          var id_dest = "<?php echo $id_dest; ?>";
          $.post("../check/removeFriends.php",{id_exp:id_exp,id_dest:id_dest}, function(data){
            if(data.erreur=="no"){
              $("#Decline").empty();
              $("#Decline").removeClass("btn-danger");
              $("#Decline").addClass("disabled");
              $("#Decline").append('<i class="icon-remove"></i>');
              this.enabled=false;
            }
          },"json");
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
            type = $("#type").val();
            dest = $("#dest").val();
             $("#publicationFeedback").hide();
             $("#publicationFeedback").hide();
             if(content != '')
             {
               $.post("../check/publierPublication.php",{content:content,categorie:categorie,type:type,dest:dest}, function(data){
                //  $("#publicationFeedback").fadeIn(1000);
                  $("#toutLeMondePublication").empty();
                  $("#toutLeMondePublication").append(data);
                  $("#emptyPublication").fadeOut();
                  $("#contenu").val("");
                  $("#toutLeMondePublicationHide").fadeIn();
                  location.reload(); 
               },"html");
             }
        });
        $("#publierVider").click(function()
        {
          $("#contenu").val("");
        });
      </script>
      <script>
        $("#search").focus(function(){
        $("#search").popover();
        }).on("mouseleave",function(){
          $("#search").popover("hide");
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

      $("#ajouterAmiSubmitAnonyme").click(function(){
        $("#ajouterAmi").submit();
      });

    $("#sendPhoto").click(function(){
      if($("#photo").val() == '')
      {
        $("#photo").css("border","1px solid red");
      }
      if($("#description").val() == '')
      {
        $("#description").css("border","1px solid red");
      }else
      {
        $("#addPhotoForm").submit();
      }
    });

    $(".lightbox-caption").onmouseenter(
      function () {
        $(this).fadeOut();
      },
      function () {
        $(this).fadeIn();
      }
    );
    </script>

    <script>
      $("#publierVider").click(function()
      {
        $("#contenu").val("");
      });
    </script>

    <script>
      function unfollow(id)
      {
        $.post("../check/unFollow.php",{id:id}, function(data){
              if(data.erreur=="no"){

               location.reload();

              }
        },"json");
      }
      function follow(id)
      {
        $.post("../check/follow.php",{id:id}, function(data){
              if(data.erreur=="no"){

               location.reload();

              }
        },"json");
      }
    </script>

    <?php
      include("script_navbar.php");
    ?>