<?php
/*
      +----------------------------------------------------------------------+
      |bibliography                                                          |
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
      | Authors: Jesus A. Martinez Cerezal <jamarcer@inicia.es>              |
      |          miguel Development Team                                     |
      |                       <e-learning-desarrollo@listas.hispalinux.es>   |      
      +----------------------------------------------------------------------+
*/
/**
 * Define la clase base de miguel.
 *
 * @author Jesus A. Martinez Cerezal <jamarcer@inicia.es>
 * @author miguel development team <e-learning-desarrollo@listas.hispalinux.es>     
 * @package email
 * @subpackage model
 * @version 1.0.0
 *
 */ 
/**
 * Include libraries
 */

class miguel_MBibliography extends base_Model
{
	/**
	 * This is the constructor.
	 *
	 */
    function miguel_MBibliography() 
    { 
        //Llama al constructor de la superclase del Modelo	
        $this->base_Model();
    }
	
	function newBook($titulo, $autor, $f_edicion, $editorial, $lugar_pub, $descripcion, $indice, $isbn_cod, $file)
    {
        $ret_val = $this->Insert('book',
                                 'title, author, publishDate, editorial, publishPlace, description, content, isbn_cod, comment_num, comment_media, image',
                                 array($titulo, $autor, $f_edicion, $editorial, $lugar_pub, $descripcion, $indice, $isbn_cod, 0, 0, $file));

    	if ($this->hasError()) {
    		$ret_val = null;
    	}

    	return $ret_val;
    }
	
	function newComment($_book, $_user, $_comment, $_value)
    {
        $ret_val = $this->Insert('book_comment',
                                 'book_id, user_id, description, value',
                                 array($_book, $_user, $_comment, $_value));
		
    	if ($this->hasError()) {
    		$ret_val = false;
    	} else {
			$val = $this->getBookValoration($_book);
			
			if(!empty($val)){
				$com_num = $val['val_num'] + 1;
				$com_val = intval((($val['valoracion'] * $val['val_num']) + $_value)/$com_num);
				
				$ret_val = $this->updateBookValoration($_book, $com_num, $com_val);
			}
		}

    	return $ret_val;
    }
	
	function getComments($_book)
	{
		$sql_ret = $this->SelectMultiTable('book_comment, user, person', 
											'person.person_name, person.person_surname, book_comment.description, book_comment.value', 
											'book_id = '.$_book.' AND person.person_id = user.user_id AND user.user_id = book_comment.user_id');
		
		if ($this->hasError()) {
   			$ret_val = null;
   		} else {
			$j = 0;
    		for ($i=0; $i<count($sql_ret); $i++) {
				if($sql_ret[$i]['book_comment.description'] != ''){
					$ret_val[$j] = array ("autor" => ($sql_ret[$i]['person.person_name'].' '.$sql_ret[$i]['person.person_surname']),
									"comentario" => $sql_ret[$i]['book_comment.description'],
									"valoracion" => $sql_ret[$i]['book_comment.value']
									); 
					$j++;	
				}
            }
		}
        
    	return ($ret_val);
	}
	
	function getLinks()
	{
		$sql_ret = $this->Select('link', 'link_name, link_url, link_broken');
		
		if ($this->hasError()) {
   			$ret_val = null;
   		} else {
    		for ($i=0; $i<count($sql_ret); $i++) {
				$ret_val[$i] = array ("link_name" => $sql_ret[$i]['link.link_name'],
									"link_url" => $sql_ret[$i]['link.link_url'],
									"link_broken" => $sql_ret[$i]['link.link_broken']
									); 
            }
		}
        //Debug::oneVar($ret_val, __FILE__, __LINE__);
    	return ($ret_val);
	}
	
	function newLink($_name, $_url)
    {
        $ret_val = $this->Insert('link',
                                 'link_name, link_url, link_broken',
                                 array($_name, $_url,0));
		
    	if ($this->hasError()) {
    		$ret_val = false;
    	} else {
			$ret_val = true;
		}

    	return $ret_val;
    }
	
	
	function updateBookValoration($book_id, $_val_num, $_valor)
    {
        $sql_ret = $this->Update('book',
                                 'comment_num, comment_media',
								 "$_val_num, $_valor",
                                 "book_id = $book_id");

    	if ($this->hasError()) {
    		$ret_val = false;
    	} else {
			$ret_val = true;
		}

    	return $ret_val;
    }
	
	function getBookValoration($book_id)
    {
        $sql_ret = $this->Select('book',
                                 'book_id, comment_num, comment_media',
                                 "book_id = $book_id");

    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val = array ("book_id" => $sql_ret[0]['book.book_id'],
                              "val_num" => $sql_ret[0]['book.comment_num'],
							  "valoracion" => $sql_ret[0]['book.comment_media']
								); 
		}

    	return $ret_val;
    }
	
	function getBookInfo($book_id)
    {
        $sql_ret = $this->Select('book',
								 'book_id, title, author, publishDate, editorial, publishPlace, description, content, isbn_cod, comment_num, comment_media, image',
								 "book_id = $book_id");

    	if ($this->hasError()) {
    		$ret_val = null;
    	} else {
			$ret_val = array ("book_id" => $sql_ret[0]['book.book_id'],
                              "autor" => $sql_ret[0]['book.author'],
							  'ptabla01' => $sql_ret[0]['book.title'],
							  "año" => $sql_ret[0]['book.publishDate'],
							  "editorial" => $sql_ret[0]['book.editorial'],
							  "descripcion" => $sql_ret[0]['book.description'],
							  "place" => $sql_ret[0]['book.publishPlace'],
							  "isbn" => $sql_ret[0]['book.isbn_cod'],
							  "indice" => $sql_ret[0]['book.content'],
							  "imagen" => $sql_ret[0]['book.image'],
							  "val_num" => $sql_ret[0]['book.comment_num'],
							  "valoracion" => $sql_ret[0]['book.comment_media']
								); 
		}

    	return $ret_val;
    }
    
    function getCatalogo($_search_type = 0, $_search_value = '')
    {
		switch($_search_type){
			case 1:
				$where_cond = 'author LIKE %'.$_search_value.'%'; //LIKE '%value%';
				break;
			case 2:
				$where_cond = 'title LIKE %'.$_search_value.'%';
				break;
			case 3:
				$where_cond = 'editorial LIKE %'.$_search_value.'%';
				break;
			case 4:
				$where_cond = 'comment_media = '.$_search_value;
				break;
			case 5:
				$where_cond = 'isbn_cod LIKE %'.$_search_value.'%';
				break;
			default:
				$where_cond = '';
				break;
		}
		
		$sql_ret = $this->SelectOrder('book', 'book_id, title, comment_media', 'comment_media, title', $where_cond);

		if ($this->hasError()) {
   			$ret_val = null;
   		} else {
    		for ($i=0; $i<count($sql_ret); $i++) {
    			$ret_val[$i] = array ("book_id" => $sql_ret[$i]['book.book_id'],
                                "title" => $sql_ret[$i]['book.title'],
								"valoracion" => $sql_ret[$i]['book.comment_media']
								); 
            }
		}
            	
    	return ($ret_val);
    }
	
	function getReference($_search_type = 0, $_search_value = '')
    {
		switch($_search_type){
			case 1:
				$where_cond = 'author LIKE %'.$_search_value.'%'; //LIKE '%value%';
				break;
			case 2:
				$where_cond = 'title LIKE %'.$_search_value.'%';
				break;
			case 3:
				$where_cond = 'editorial LIKE %'.$_search_value.'%';
				break;
			case 4:
				$where_cond = 'comment_media = '.$_search_value;
				break;
			case 5:
				$where_cond = 'isbn_cod LIKE %'.$_search_value.'%';
				break;
			default:
				$where_cond = '';
				break;
		}
		
		$sql_ret = $this->Select('book', 'book_id, title, author, publishdate, publishplace, editorial, comment_media', $where_cond);

		if ($this->hasError()) {
   			$ret_val = null;
   		} else {
    		for ($i=0; $i<count($sql_ret); $i++) {
    			$ret_val[$i] = array ("book_id" => $sql_ret[$i]['book.book_id'],
                                "title" => $this->_formatReference($sql_ret[$i]['book.author'], $sql_ret[$i]['book.publishdate'], $sql_ret[$i]['book.title'], $sql_ret[$i]['book.editorial'], $sql_ret[$i]['book.publishplace']),
								"valoracion" => $sql_ret[$i]['book.comment_media']
								); 
            }
		}
            	
    	return ($ret_val);
    }
	
	function _formatReference($_autor, $_date, $_titulo, $_editorial, $_place)
	{
		return $_autor.' ('.$_date.') '.$_titulo.'. '.$_editorial.', '.$_place.'.';
	}
	}    
?>
