<?php
/*
        include_once ('./include/miniXML/minixml.inc.php');

      	$xml = new MiniXMLDoc();

      	$xmlRoot =& $xml->getRoot();

		$config =& $xmlRoot->createChild('config');

      	$child =& $config->createChild('ddbbSgbd');
      	$child->text('Gestor');
      	$child =& $config->createChild('ddbbMainDb');
      	$child->text('Base');
      	$child =& $config->createChild('ddbbServer');
      	$child->text('Host');
      	$child =& $config->createChild('ddbbUser');
      	$child->text('Usuario');
      	$child =& $config->createChild('ddbbPassword');
      	$child->text('Clave');
      	
      	//$tree_make = $xml->toString();
      	print_r($xml);
*/
        include_once ('./model/classes/xml/base_xmlData.class.php');

      	$xml1 = new base_XMLData();

		$root = $xml1->rootElement('config');
		echo $root->addChild('config', 'primero');
		print_r($root);
		$xml1->addChild('config', 'primero');
		

/*
      	$child =& $config->addChild('ddbbSgbd', 'Gestor');
      	$child =& $config->addChild('ddbbMainDb', 'Base');
      	$child =& $config->addChild('ddbbServer', 'Host');
      	$child =& $config->addChild('ddbbUser', 'Usuario');
      	$child =& $config->addChild('ddbbPassword', 'Clave');
*/      	
      	//echo $xml1->dump();
      	//print_r($xml1);
/*
        $xml2 = new base_XMLData();	
      	$root = $xml2->getTreeFromString($tree_make);
      	//echo $xml2->dump();
      	print_r($xml2);
      	
      	//print_r($root);
      	//echo $root->get();
      	//$elem = $root2->getElement('ddbbSgbd');
        //echo $elem->dump();
*/
?>
