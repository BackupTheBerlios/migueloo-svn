<?php
/*
      +----------------------------------------------------------------------+
      | miguel base                                                          |
      +----------------------------------------------------------------------+
      | Copyright (c) 2004, miguel Development Team                          |
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
 * @package miguel base
 * @subpackage control
 * @version 1.0.0
 *
 */
/**
 * Include libraries
 */


class miguel_CPageViewer extends miguel_Controller
{
        /**
         * This is the constructor.
         *
         */
        function miguel_CPageViewer()
        {
                $this->miguel_Controller();
                $this->setModuleName('pageViewer');
                $this->setViewClass('miguel_VPageViewer');
                $this->setCacheFlag(false);
        }

        function processPetition()
        {
            //Debug::oneVar($this->getViewVariable('url'), __FILE__, __LINE__);
            //Debug::oneVar($this->getViewVariable('name'), __FILE__, __LINE__);
            //Debug::oneVar($this->issetViewVariable('url'), __FILE__, __LINE__);
            /*
        if ($this->issetViewVariable('url')){
                         $this->addNavElement(Util::format_URLPath("pageViewer/index.php",  'url='.$this->getViewVariable('url').'&name='.$this->getViewVariable('name')),
                                                                   'Visor');
                } else {
            //$this->addNavElement(Util::format_URLPath("pageViewer/index.php"), 'Visor');
        }
              */
                $this->setPageTitle("miguel eLearning page");
                $this->setMessage("*");
                $this->clearNavBarr();
                //$this->setCacheFile("miguel_vParser");
                $this->setCacheFlag(true);
                $this->setHelp("");
        }
}
?>