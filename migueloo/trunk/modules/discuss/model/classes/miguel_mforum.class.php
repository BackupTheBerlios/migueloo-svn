<?php
/*
      +----------------------------------------------------------------------+
      |forum                                                                 |
      +----------------------------------------------------------------------+
      | Copyright (c) 2003, 2004, miguel Development Team                    |
      +----------------------------------------------------------------------+
      |   This program is free software; you can redistribute it and/or      |
      |   modify it under the terms of the GNU General Public License        |
      |   as published by the Free Software Foundation; either version 2     |
      |   of the License, or (at your option) any later version.             |
      |                                                                      |
      |   This program is distributed in the hope that it will be useful,    |
      |   but WITHOUT ANY WARRANTY; without even the implied warranty of     |
      |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
      |   GNU General Public License for more details.                       |
      |                                                                      |
      |   You should have received a copy of the GNU General Public License  |
      |   along with this program; if not, write to the Free Software        |
      |   Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA          |
      |   02111-1307, USA. The GNU GPL license is also available through     |
      |   the world-wide-web at http://www.gnu.org/copyleft/gpl.html         |
      +----------------------------------------------------------------------+
      | Authors: SHS Polar Sistemas Informáticos, S.L. <www.polar.es>        |
      |          Equipo de Desarrollo Software Libre <jmartinezc@polar.es>   | 
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author SHS Polar Equipo de Desarrollo Software Libre <jmartinezc@polar.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package forum
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_MForum extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MForum() 
    { 
        //Llama al constructor de la superclase del Modelo	
        $this->base_Model();
    }
    
    //Devuelve información de un foro
    function getForum($forum_id)
    {
				$ret_val = $this->Select('forum', 
                                 'forum_name, forum_description, forum_moderator, forum_access, forum_cat_id',
                                 "forum_id = $forum_id"); 				      
        if ($this->hasError()) 
				{
        	$ret_val = null;
        } 
        
				return($ret_val);			 		
    }

	//Devuelve información de un foro
	function getForums()
	{
		$ret_val = $this->Select('forum', 
								'forum_id, forum_name, forum_description, forum_moderator, forum_access, forum_cat_id, forum_date');
		if ($this->hasError()) {
			$ret_val = null;
		} else {
			for($i=0; $i < count($ret_val); $i++){
				$sql_val = $this->SelectCount('forum_topic',"forum_id = ".$ret_val[$i]['forum.forum_id']);
				
				if ($this->hasError()) {
					$ret_val[$i]['forum.forum_num'] = 0;
				} else {
					$ret_val[$i]['forum.forum_num'] = $sql_val;
				}
			}
		}
		
		return $ret_val;
	}
    
    //Crea un foro
    function insertForum($name, $descripcion)
    {
		$now = date('Y-m-d H:i:s');
						
		$ret_val = $this->Insert('forum', 
                                 'forum_name, forum_description, forum_date',
                                 "$name,$descripcion,$now"); 	
		if ($this->hasError()) { 
        	$ret_val = null;
        } 
		
		return($ret_val);			 			
    }

	function insertTopic($forum_id, $title)
	{
		$now = date('Y-m-d H:i:s');
		$iMyId = Session::getValue('USERINFO_USER_ID');
				
		$ret_val = $this->Insert('forum_topic', 
								'forum_id, forum_topic_title, forum_topic_poster, forum_topic_date',
								array($forum_id, $title, $iMyId, $now)); 	
			
		if ($this->hasError()) { 
			$ret_val = null;
		} 
		
		return $ret_val;
	}
   
     
		//Inserta un mensaje
    function insertPost($topic_id, $forum_id, $text, $ip, $title, $parent_id = 0)
    {
    
	        $now = date("Y-m-d H:i:s");
			$iMyId = Session::getValue('USERINFO_USER_ID');
		
    		$post_id = $this->Insert('forum_post', 
                                 'forum_topic_id, forum_id, forum_post_text, forum_post_poster, forum_post_time, forum_post_ip, forum_post_title, forum_post_parent',
                                 array($topic_id,$forum_id,$text,$iMyId,$now,$ip,$title,$parent_id)); 	
                                 
 				if ($parent_id == 0)
				{
 			   		$this->Update('forum_post', 
                        		'forum_post_parent',
		                   		"$post_id",
		 					  "forum_post_id = $post_id"); 	
				}

	      if ($this->hasError()) 
				{
        	$post_id = null;
        } 
        
        //Actualizamos el último mensaje del foro
        $this->Update ('forum_topic', 
											'last_post_id',
											"$post_id", 
											"forum_id = $forum_id");
											
				return($post_id);			 			
    }

	function getTopic($topic_id)
    {

				$ret_val = $this->SelectMultiTable('forum_topic,forum',
                                 'forum_topic.forum_topic_title, forum.forum_name',
                                 "forum_topic.forum_topic_id = $topic_id AND forum_topic.forum_id = forum.forum_id"); 	

	      if ($this->hasError()) 
				{
        	$ret_val = null;
        } 
				return($ret_val);			 			   		
		}

	function getTopicName($topic_id)
	{
		$sql_val = $this->Select('forum_topic',
								'forum_topic_title',
								"forum_topic_id = $topic_id");
	
		if ($this->hasError()) {
			$ret_val = '';
		} else {
			$ret_val = $sql_val[0]['forum_topic.forum_topic_title'];
		}
		
		return $ret_val;
	}
	
	function getPostName($post_id)
	{
		$sql_val = $this->Select('forum_post',
								'forum_post_title',
								"forum_post_id = $post_id");
	
		if ($this->hasError()) {
			$ret_val = '';
		} else {
			$ret_val = $sql_val[0]['forum_post.forum_post_title'];
		}
		
		return $ret_val;
	}
	
	function getPost($topic_id)
	{
		$ret_val = $this->SelectMultiTable('forum_topic,forum',
									'forum_topic.forum_topic_title, forum.forum_name',
									"forum_topic.forum_topic_id = $topic_id AND forum_topic.forum_id = forum.forum_id"); 	
	
		if ($this->hasError()) {
			$ret_val = null;
		} 
		
		return $ret_val;
	}
   
	 	//Inserta un mensaje
    function getPostForum($forum_id, $topic_id, $orden=null)
    {
		switch($orden) {
			case 'tema': 
						$campo_orden = 'forum_post_parent,forum_post_time';
						break;
			case 'autor': 
						$campo_orden = 'forum_post_poster';
						break;
			case 'fecha': 
			default:
						$campo_orden = 'forum_post_time';
						break;
		}
		
		if ($forum_id != '' && $topic_id!= '') {
			$ret_val = $this->SelectOrder('forum_post',
							'forum_topic_id, forum_post_text, forum_post_poster, forum_post_time, forum_post_ip, forum_post_id, forum_id, forum_post_parent, forum_post_title',
							$campo_orden,
							"forum_id = $forum_id AND forum_topic_id = $topic_id"); 	
	
			if ($this->hasError()) {
				$ret_val = null;
			} else {
				for($i=0; $i<count($ret_val);$i++){
				$ret_val[$i]['is_logged'] = $this->isLogged($ret_val[$i]['forum_post.forum_post_poster']);
			}			
			}
		}
			
		return $ret_val ;			 			
    }
    
	function getUsers()
	{
		$arrUsers = $this->SelectMultiTable('user, person', 'user.user_id, person.person_name, person.person_surname',
											"user.user_id = person.person_id");
		
		if ($this->hasError() || count($arrUsers) == 0) {
			$ret_val = null;
		} else {
			for ($i=0; $i<count($arrUsers);$i++) {
				$ret_val[$arrUsers[$i]['user.user_id']] = $arrUsers[$i]['person.person_name'].' '.$arrUsers[$i]['person.person_surname'];
			}
		}
		
		return $ret_val;
	}
    
    function deleteTopic($topic_id)
    {
		 	$this->Delete('forum_topic',"forum_topic_id = $topic_id");
		}

    function deletePost($post_id)
    {
		 	$this->Delete('forum_post',"forum_post_id = $post_id");
		}
 

     function getTopics($forum_id)
    {
			//Obtenemos primero los topics correspondientes al foro
	 		$ret_val = $this->Select('forum_topic', 	   	 'forum_topic_id,forum_topic_title,forum_topic_numview,forum_topic_replies,forum_topic_notify,forum_topic_status,forum_topic_poster,forum_topic_date,number_of_visits,number_of_posts, last_post_id',
			 "forum_id = $forum_id");

			//Obtenemos el ultimo mensaje de cada topic si lo tiene (No se puede hacer con un multiselect
			for ($i=0; $i<count($ret_val); $i++)	{
				$topic_id = $ret_val[$i]['forum_topic.forum_topic_id'];
				$last_post_id = $ret_val[$i]['forum_topic.last_post_id'];
				if ($topic_id != null)	{
					$last_post = $this->Select('forum_post',
													'forum_post_poster, forum_post_time',
													"forum_post_id = $last_post_id AND forum_topic_id = $topic_id AND forum_id = $forum_id");
					$ret_val[$i]['forum_post.forum_post_poster'] = $last_post[0]['forum_post.forum_post_poster'];
					$ret_val[$i]['forum_post.forum_post_time'] =  $last_post[0]['forum_post.forum_post_time'];
					}
			}

		 	if ($this->hasError()) {
    			$ret_val = null;
    		}
    		return ($ret_val);
    }
	
	function isLogged($_nick)
    {
		$log_sql = $this->Select('user_logged', 'is_logged', 'user_id = '.$_nick);

		if ($this->hasError()) {
			$ret_val = false;
		} else {
			if($log_sql[0]['user_logged.is_logged'] == null){
				$ret_val = false;
			} else {
				$ret_val = true;
			}	
		}
		
		return $ret_val;
    }
}
?>