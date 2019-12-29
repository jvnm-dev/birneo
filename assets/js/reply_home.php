<?php 
        if(isset($_GET['reply']))
        {
          $reply = $_GET['reply'];
          if($reply == "ok")
          {
            ?>
            <script>
              var reply = $("#registerok");
              reply.fadeIn();
              reply.click(function(){
                reply.fadeOut();
              });
            </script>
            <?php
          }elseif ($reply == "notok1"){
            ?>
            <script>
              var reply = $("#registernotok1");
              reply.fadeIn();
              reply.click(function(){
                reply.fadeOut();
              });
            </script>
            <?php
          }elseif ($reply == "notok2"){
            ?>
            <script>
              var reply = $("#registernotok2");
              reply.fadeIn();
              reply.click(function(){
                reply.fadeOut();
              });
            </script>
            <?php
          }elseif ($reply == "notok3"){
            ?>
            <script>
              var reply = $("#registernotok3");
              reply.fadeIn();
              reply.click(function(){
                reply.fadeOut();
              });
            </script>
            <?php
          }elseif ($reply == "already")
          {
            ?>
              <script>
                var reply = $("#already");
                reply.fadeIn();
                reply.click(function(){
                  reply.fadeOut();
                });
              </script>
            <?php
          }
        }
      ?>