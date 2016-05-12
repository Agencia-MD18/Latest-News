<?php
defined('_JEXEC') or die;
require_once JPATH_SITE . '/components/com_content/helpers/route.php';


class modMD18LastNewsHelper
{
	static function getMD18LastNewsOptions($catids, $maxlimit)
	{
		$db	    =   & JFactory::getDBO();
        $where  =   "";
        
        if($id!=0){
        	$_catids = implode(", ", array_map('intval', $catids));
        	$where = " AND b.catid IN (".$_catids.")";
        }

		// Create a new query object.
		$query = $db->getQuery(true);
		 
		$query
			->select(array('a.id', 'a.catid', 'a.title', 'a.introtext', 'a.fulltext', 'a.images', 'a.created', 'a.urls', 'b.title as category_title'))
			->from($db->quoteName('#__content', 'a'))
			->join('INNER', $db->quoteName('#__categories', 'b') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('b.id') . ')')
			->where($db->quoteName('a.state') . '="1" ' . $where)
			->order(array($db->quoteName('a.created') . ' DESC', $db->quoteName('a.id') . ' DESC'))
			->setLimit($maxlimit);

		$db->setQuery($query);
		$options = $db->loadObjectList();
		
		return $options;
	}

	static function getLink($row) {
		
		$link = '';
        $urls = json_decode($row->urls);
        $link = $urls->urla;

        if(!$link) {
            $route = ContentHelperRoute::getArticleRoute($row->id, $row->catid, JFactory::getLanguage()->getTag());
            $link = JRoute::_($route);
        }

        return $link;
	}

}
?>
