
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
      <script>
        $("#infoPop").hover(function(){$("#infoPop").popover("toggle")});
      </script>
      <script>
        $("#searchFriend").focus(function(){
        $("#searchFriend").popover();
        }).on("mouseleave",function(){
          $("#searchFriend").popover("hide");
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
      $(document).ready(function(){
        $("#destinataire").mention({
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
      $("#envoyerMessage").click(function()
      {
        message = $("#message").val();
        id_destinataire = $("#id_destinataire").val();
        discussion = $("#discussion").val();

        $.post("../check/envoyerMessage.php",{message:message,id_destinataire:id_destinataire,discussion:discussion}, function(data){
          if(data.erreur=="no"){
           // $("#CommentaireFeedback"+id).fadeIn(1000);
            $("#message").val("");
            window.location.reload(true);
          }
         },"json");
      });
      var antidoublon = true;
      $("#message").keyup(function(e) {

            if(antidoublon && e.keyCode == 13) {
              console.log(antidoublon);
                antidoublon = false;
                console.log(antidoublon);
                message = $("#message").val();
                id_destinataire = $("#id_destinataire").val();
                discussion = $("#discussion").val();
                if(message && message != ' ' && message != '')
                {
                  $.post("../check/envoyerMessage.php",{message:message,id_destinataire:id_destinataire,discussion:discussion}, function(data){
                    if(data.erreur=="no"){
                     // $("#CommentaireFeedback"+id).fadeIn(1000);
                      $("#message").val("");
                      envoyer = true;
                      window.location.reload(true);
                    }
                  },"json");
                }else
                {
                  $("#message").css("border","solid 1px red");
                }
                 
            }
          
    });

      function scrolldown() {
       var h=0;
           
       if (window.innerHeight) h = window.innerHeight;
       else if (document.body && document.body.offsetHeight) h = window.document.body.offsetHeight;
       else if (document.documentElement && document.documentElement.clientHeight) h = document.documentElement.clientHeight;
           
      this.scroll(1,h);
      }    


      $("#messageInboxSubmit").click(function()
      {
        
        message = $("#contenu").val();
        destinataire = $("#destinataire").val();

        if(message != '' && destinataire != '')
             {
               $.post("../check/envoyerMessage.php",{message:message,destinataire:destinataire}, function(data){
                if(data.erreur=="no"){
                  window.location.reload(true);
                }else
                {
                  $("#errorMessage").empty();
                  $("#errorMessage").append(data.erreur);
                  $("#errorMessage").show(function()
                  {
                    $("#errorMessage").delay(2500).fadeOut();
                  });
                }
               },"json");
             }else
             {
                $("#errorMessage").empty();
                $("#errorMessage").append("Remplissez les champs");
                $("#errorMessage").show(function()
                {
                  $("#errorMessage").delay(2500).fadeOut();
                });
             }
        });

        function archiver(id)
        {
          discussion = id;
          $.post("../check/archiverMessage.php",{discussion:discussion}, function(data){
            if(data.erreur=="no"){
             // $("#CommentaireFeedback"+id).fadeIn(1000);
              $("#discussion"+id).fadeOut();
              
            }
           },"json");
        }

    </script>

    <script>
      $("#publierVider").click(function()
      {
        $("#contenu").val("");
      });
    </script>

    <?php
      include("script_navbar.php");
    ?>