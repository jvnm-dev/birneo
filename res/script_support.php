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
		$("#searchFriend").focus(function(){
		$("#searchFriend").popover();
		}).on("mouseleave",function(){
		  $("#searchFriend").popover("hide");
		});
	  </script>
	  <script>
	  	$("#submitSupport").click(function(){
	  		content = $("#contentBug").val();
	  		titre = $("#titreBug").val();
	  		type = $("#typeBug").val();

	  		$.post("../check/publierBug.php",{content:content,titre:titre,type:type}, function(data){
	            if(data.erreur=="no"){
	              $("#formBug").fadeOut(1000);
	              $("#bugFeedback").fadeIn(1000);
	              $("#contentBug").val("");
	              $("#titreBug").val("");
	              $("#submitSupport").fadeOut(1000);
	            }
           },"json");
	  	});
	  </script>
	  <script>
	  	function supprimerBug(id)
	  	{
	  		var idBug = id;
		  	var supprimerBugButton = $("#supprimerBug");
		  	var archiverBugButton = $("#archiverBug");
		  	

		  		$.post("../check/supprimerBug.php",{idBug:idBug}, function(data){
		            if(data.erreur=="no"){
		             $("#bug"+idBug).fadeOut(1000,function(){
		              	$("#bug"+idBug).css("display", "none");
		             });
		            }
	           },"json");
		 }
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
    <?php
    	include("script_navbar.php");
    ?>