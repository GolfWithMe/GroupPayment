<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class CommunityModelGroupMemberships extends JModelLegacy
{
	/**
	 * Configuration data
	 *
	 * @var object	JPagination object
	 **/
	var $_pagination;

	/**
	 * Configuration data
	 *
	 * @var int	Total number of rows
	 **/
	var $_total;

	/**
	 * Configuration data
	 *
	 * @var int	Total number of rows
	 **/
	var $_data;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$mainframe	= JFactory::getApplication();

		// Call the parents constructor
		parent::__construct();

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->get('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( 'com_community.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	/**
	 * Method to get a pagination object for the events
	 *
	 * @access public
	 * @return integer
	 */
	public function getPagination()
	{
		// Lets load the content if it doesn't already exist
		if ( empty( $this->_pagination ) )
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}

	/**
	 * Method to return the total number of rows
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Load total number of rows
		if( empty($this->_total) )
		{
			//$this->_total	= $this->_getListCount( $this->_buildQuery() );
			$this->_total	= $this->_getListCount( $this->_buildQueryMem() );
		}

		return $this->_total;
	}

	/**
	 * Build the SQL query string
	 *
	 * @access	private
	 * @return	string	SQL Query string
	 */
	public function _buildQuery()
	{
		$db			= JFactory::getDBO();
		$mainframe	= JFactory::getApplication();
		$ordering		= $mainframe->getUserStateFromRequest( "com_community.filter_order",		'filter_order',		'name',	'cmd' );
		$orderDirection	= $mainframe->getUserStateFromRequest( "com_community.filter_order_Dir",	'filter_order_Dir',	'',	'word' );

		switch( $ordering )
		{
			case 'members':
				$orderby		= ' ORDER BY memberscount '. $orderDirection;
				break;
			case 'groups':
				$orderby		= ' ORDER BY groupscount '. $orderDirection;
				break;
			case 'id':
				$orderby		= ' ORDER BY a.id '. $orderDirection;
				break;
			default:
				$orderby		= ' ORDER BY name '. $orderDirection;
				break;
		}

		$query		= 'SELECT a.*,'
					. 'COUNT(DISTINCT(b.id)) AS groupscount,'
					. 'COUNT(c.memberid) AS memberscount FROM '
					. $db->quoteName( '#__community_groups_category' ) . ' AS a '
					. 'LEFT JOIN ' . $db->quoteName( '#__community_groups' ) . ' AS b '
					. 'ON a.id=b.categoryid '
					. 'LEFT JOIN ' . $db->quoteName( '#__community_groups_members' ) . ' AS c '
					. 'ON b.id=c.groupid '
					. 'GROUP BY a.id';
		$query	.= $orderby;
		return $query;
	}

	/**
	 * Returns the Groups Categories list
	 *
	 * @return Array An array of group category objects
	 **/
	public function &getCategories()
	{
		$mainframe	= JFactory::getApplication();
        $jinput = $mainframe->input;

		if(empty($this->_data))
		{

			$view = $jinput->get('view');

			if(is_null($view)){
				$limit = 0;
			} else {
				$limit = $this->getState('limit');
			}

			$query = $this->_buildQuery();

			$this->_data	= $this->_getList( $this->_buildQuery() , $this->getState('limitstart'), $limit );
		}
		return $this->_data;
	}

    /**
     * Given an id, check all the descendant of the category based on the given list
     * @param $id
     * @param $categories
     * @param array $list
     * @return array
     */
    public function getCategoryChilds($id, $categories, $list = array()){
        foreach($categories as $category){
            if($category->parent == $id){
                $list[] = $category->id;
                $list = $this->getCategoryChilds($category->id, $categories, $list);
            }
        }

        return $list;
    }
	
	public function _buildQueryMem()
	{
		$db			= JFactory::getDBO();
		$mainframe	= JFactory::getApplication();
		$ordering		= $mainframe->getUserStateFromRequest( "com_community.filter_order",		'filter_order',		'id',	'cmd' );
		$orderDirection	= $mainframe->getUserStateFromRequest( "com_community.filter_order_Dir",	'filter_order_Dir',	'',	'word' );
		
		$orderby		= ' ORDER BY a.id desc ';
		
		//echo $ordering;
		
		switch( $ordering )
		{
			case 'adddate':
				$orderby		= ' ORDER BY a.adddate '. $orderDirection;
				break;
			case 'expdate':
				$orderby		= ' ORDER BY a.expdate '. $orderDirection;
				break;
			case 'name':
				$orderby		= ' ORDER BY a.id desc ';
				break;
			case 'id':
				$orderby		= ' ORDER BY a.id desc ';
				break;
			case 'a.id':
				$orderby		= ' ORDER BY a.id desc ';
				break;
			default:
				$orderby		= ' ORDER BY a.id '. $orderDirection;
				break;
		}
		
		//$orderby		= ' ORDER BY a.id desc ';

		$query		= 'SELECT a.* FROM '
					. $db->quoteName( '#__community_groups_membership' ) . ' AS a '
					. ' WHERE 1 ';
		$query	.= $orderby;
		return $query;
	}
	
	public function &getMemberships()
	{
		$mainframe	= JFactory::getApplication();
        $jinput = $mainframe->input;

		if(empty($this->_data))
		{

			$view = $jinput->get('view');

			if(is_null($view)){
				$limit = 0;
			} else {
				$limit = $this->getState('limit');
			}

			$query = $this->_buildQueryMem();

			$this->_data	= $this->_getList( $this->_buildQueryMem() , $this->getState('limitstart'), $limit );
		}
		return $this->_data;
	}
	
	public function &getPaymentSettings()
	{
		$mainframe	= JFactory::getApplication();
        $jinput = $mainframe->input;
		
		$db			= JFactory::getDBO();
		
		$orderby		= ' ORDER BY id desc ';

		$querySql	= 'SELECT a.* FROM '
					. $db->quoteName( '#__community_groups_paymentsetting' ) . ' AS a '
					. 'WHERE 1';
		$querySql	.= $orderby;

		$db->setQuery( $querySql );
		$result = $db->loadObject();
		
		
		return $result;
	}
	
	public function updatePaymentSet($id, $fieldset)
	{
		$mainframe	= JFactory::getApplication();
        $jinput = $mainframe->input;
		
		$db			= JFactory::getDBO();

		$query	= 'UPDATE '. $db->quoteName('#__community_groups_paymentsetting')
            .' SET ' . $db->quoteName('memname').' = '.$db->Quote($fieldset['memname'])
			.' , ' . $db->quoteName('amount').' = '.$db->Quote($fieldset['amount'])
			.' , ' . $db->quoteName('memmonth').' = '.$db->Quote($fieldset['memmonth'])
			.' , ' . $db->quoteName('paymode').' = '.$db->Quote($fieldset['paymode'])
			.' , ' . $db->quoteName('payname').' = '.$db->Quote($fieldset['payname'])
			.' , ' . $db->quoteName('apiuser').' = '.$db->Quote($fieldset['apiuser'])
			.' , ' . $db->quoteName('apipassword').' = '.$db->Quote($fieldset['apipassword'])
			.' , ' . $db->quoteName('apisignature').' = '.$db->Quote($fieldset['apisignature'])
			.' WHERE '.$db->quoteName('id').'='.$db->Quote($fieldset['id']);
			
			//echo $query;
			//die();

        $db->setQuery($query);
        try {
            $db->execute();
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        return $this;
	}
	
	public function getGroupdata($gid)
	{
		$mainframe	= JFactory::getApplication();
        $jinput = $mainframe->input;
		
		$db			= JFactory::getDBO();
		

		$querySql	= 'SELECT a.* FROM '
					. $db->quoteName( '#__community_groups' ) . ' AS a '
					. 'WHERE '. $db->quoteName('id').' = '.$db->Quote($gid);

		$db->setQuery( $querySql );
		$result = $db->loadObject();
		
		
		return $result;
	}
	
	public function getUserdata($uid)
	{
		$mainframe	= JFactory::getApplication();
        $jinput = $mainframe->input;
		
		$db			= JFactory::getDBO();
		

		$querySql	= 'SELECT a.* FROM '
					. $db->quoteName( '#__users' ) . ' AS a '
					. 'WHERE '. $db->quoteName('id').' = '.$db->Quote($uid);

		$db->setQuery( $querySql );
		$result = $db->loadObject();
		
		
		return $result;
	}
	
	public function deleteMembership($id)
	{
		$mainframe	= JFactory::getApplication();
        $jinput = $mainframe->input;
		
		$db			= JFactory::getDBO();

		$query	= 'DELETE FROM '. $db->quoteName('#__community_groups_membership')
			.' WHERE '.$db->quoteName('id').'='.$db->Quote($id);
			
			//echo $query;
			//die();

        $db->setQuery($query);
        try {
            $db->execute();
        } catch (Exception $e) {
            JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
        }

        return $this;
	}

}