<script>
      $("#showOldNotification").click(function(){
            $("#NewNotification").fadeOut();
            $("#NewNotificationText").fadeOut();
            $("#showOldNotification").fadeOut();
            $("#oldNotification").fadeIn();
      });
      $("#voirSource").click(function(){
            $.post("../check/voirSource.php",{id_notification:id_notification}, function(data){
                  if(data.erreur=="no"){
                        $("#formBug").fadeOut(1000);
                        $("#bugFeedback").fadeIn(1000);
                        $("#contentBug").val("");
                        $("#titreBug").val("");
                        $("#submitBug").fadeOut(1000);
                  }
           },"json");
      });
      
      $("#notifNavbar").click(function(){
        $("#notifAGet").empty();
        $("#notifAGet").append('<center><span align="center" id="loader" style="display:none;text-align:center;"> <img  name="loader" src="http://127.0.0.1/assets/img/loader.gif" width="16"> </span></center>');
        $("#loader").show();
        $("#notifAGet").load("../res/notification.php",function(){
            $.post("../res/ReadNotif.php",{}, function(data){
              if(data.erreur=="no"){
                    $("#nbreNotif").fadeOut();
              }
            },"json");
        });
      });

      $("#messageNavbar").click(function(){
        $("#messageAGet").empty();
        $("#messageAGet").append('<center><span align="center" id="loader" style="display:none;text-align:center;"> <img  name="loader" src="http://127.0.0.1/assets/img/loader.gif" width="16"> </span></center>');
        $("#loader").show();
        $("#messageAGet").load("../res/message.php",function(){
           // $.post("../res/ReadNotif.php",{}, function(data){
             // if(data.erreur=="no"){
                  //  $("#nbreNotif").fadeOut();
             // }
            //},"json");
        });
      });
      
        function getAlert()
        {
          $.ajax({
            type: 'POST',
            dataType:"json",
            url: '../res/countNotif.php',
            success: function(data){
              if(data.notification>0){
                $("#nbreNotif").fadeOut();
                $("#nbreNotif").html(data.notification);
                $("#nbreNotif").fadeIn();
              }

              if(data.message>0)
              {
                $("#nbreMessage").fadeOut();
                $("#counterDiscussion").fadeOut();
                $("#nbreMessage").html(data.message);
                $("#counterDiscussion").html(data.message);
                $("#nbreMessage").fadeIn();
                $("#counterDiscussion").fadeIn();
              }
            }
          });
          setTimeout('getAlert()',8000);
        }
    $(document).ready(function(){
      getAlert();
    });

</script>