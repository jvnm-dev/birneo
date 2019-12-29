<?php 
	class User extends Base
	{
		var $table = "users";
	}

	class Friends extends Base
	{
		var $table = "friends";
	}

	function is_friend($id)
	{
		global $bdd;
		$isfriend_query_exp = $bdd->query("SELECT count(*) FROM friends WHERE id_exp=:id",array("id"=>$id));
        $isfriend_exp = $isfriend_query_exp[0]['count(*)'];
        $isfriend_query_dest = $bdd->query("SELECT count(*) FROM friends WHERE id_dest=:id",array("id"=>$id));
        $isfriend_dest = $isfriend_query_dest[0]['count(*)'];

        $isfriend = $isfriend_exp + $isfriend_dest;
        return $isfriend;
	}

?>