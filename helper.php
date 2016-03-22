<?php
defined('_JEXEC') or die;
require_once JPATH_SITE . '/components/com_content/helpers/route.php';


class modMD18LastNewsHelper
{
	static function getMD18LastNewsOptions($id, $maxlimit)
	{
		$db	    =   & JFactory::getDBO();
        $where  =   "";
        
        if($id!=0){
          $where    =   "AND a.catid = ".(int)$id."";
        }

		$query = 'SELECT a.id, a.catid, a.title, a.introtext, a.fulltext, a.images, a.created, a.urls' .
			' FROM #__content AS a' .
			' WHERE a.state="1" '.$where.'  ORDER BY a.created DESC, a.id DESC' .
			' LIMIT ' . $maxlimit;

		$db->setQuery($query);

		if (!($options = $db->loadObjectList())) {
			echo "MD ".$db->stderr();
			return;
		}

		return $options;
	}

	static function getLink($row, $menuitem) {
		
		$link = '';
        $urls = json_decode($row->urls);
        $link = $urls->urla;

        if(!$link) {
            $route = ContentHelperRoute::getArticleRoute($row->id, $row->catid, JFactory::getLanguage()->getTag());

            $app = JFactory::getApplication();
			$menu = $app->getMenu();
			$Itemid = $menu->getItem( $menuitem );

            $link = JRoute::_($route . '&Itemid=' . $Itemid->id);
        }

        return $link;
	}
}
?>
