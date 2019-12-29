      $("#popover").hover(function(){
          $("#popover").popover("show");
        }).on("mouseleave",function(){
          $("#popover").popover("hide");
        });
      $("#registerSubmit").click(function(){
        var username = $("#username");
        var email = $("#email");
        var password = $("#password");
        var repeatpassword = $("#repeatpassword");
        var sex = $("#sex");
        var job = $("#job");
        var description = $("#description");
        var errorDiv = $("#errorContent");
        var form = $("#register");
        errorDiv.empty();        
        if(username.val() != '')
        {
          username.css("border","5px solid #5aac41");
          if(email.val() != '')
          {
            email.css("border","5px solid #5aac41");
            if(password.val() != '')
            {
              password.css("border","5px solid #5aac41");
              if(repeatpassword.val() != '')
              {
                repeatpassword.css("border","5px solid #5aac41");
                if(sex.val() != '')
                {
                  sex.css("border","5px solid #5aac41");
                  if(job.val() != '')
                  {
                    job.css("border","5px solid #5aac41");
                    if(description.val() != '')
                    {
                      description.css("border","5px solid #5aac41");
                      if(password.val() != repeatpassword.val())
                      {
                        password.css("border","5px solid #dd4b39");
                        repeatpassword.css("border","5px solid #dd4b39");
                        errorDiv.append('<div class="alert alert-error">Vous n\'avez pas entré le même mot de passe.</div>');
                      }else
                      {
                        return true;
                      }
                    }else
                    {
                      description.css("border","5px solid #dd4b39");
                      errorDiv.append('<div class="alert alert-error">Vous devez vous décrire.</div>');
                    }
                  }else
                  {
                    job.css("border","5px solid #dd4b39");
                    errorDiv.append('<div class="alert alert-error">Vous devez préciser votre emploi.</div>');
                  }
                }else
                {
                  sex.css("border","5px solid #dd4b39");
                  errorDiv.append('<div class="alert alert-error">Vous devez préciser votre sexe.</div>');
                }
              }else
              {
                repeatpassword.css("border","5px solid #dd4b39");
                errorDiv.append('<div class="alert alert-error">Vous devez répétez le mot de passe choisi.</div>');
              }
            }else
            {
              password.css("border","5px solid #dd4b39");
              errorDiv.append('<div class="alert alert-error">Vous devez définir un mot de passe pour votre compte.</div>');
            }
          }else
          {
            email.css("border","5px solid #dd4b39");
            errorDiv.append('<div class="alert alert-error">Vous devez définir une adresse email pour votre compte.</div>');
          }
        }else
        {
          username.css("border","5px solid #dd4b39");
          errorDiv.append('<div class="alert alert-error">Vous devez définir un nom d\'utilisateur pour votre compte.</div>');
        }
      return false;
      });