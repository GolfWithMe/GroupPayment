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

jimport( 'joomla.application.component.view' );

/**
 * Configuration view for JomSocial
 */
class CommunityViewGroupMemberships extends JViewLegacy
{
	/**
	 * The default method that will display the output of this view which is called by
	 * Joomla
	 *
	 * @param	string template	Template file name
	 **/
	public function display( $tpl = null )
	{
		$document	= JFactory::getDocument();
		$mainframe	= JFactory::getApplication();
		
		foreach($_REQUEST['cid'] as $val) {
			//echo $val;
			$model				= $this->getModel( 'GroupMemberships' );
			$savedate			= $model->deleteMembership($val);
			$mainframe->enqueueMessage('Membership delete successfully.', 'success');
		}
		
		$memberships	= $this->get( 'Memberships' );
		$pagination	= $this->get( 'Pagination' );

		$filter_order		= $mainframe->getUserStateFromRequest( "com_community.filter_order",		'filter_order',		'id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( "com_community.filter_order_Dir",	'filter_order_Dir',	'',			'word' );

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;
		//print_r($memberships);
		
		$this->set( 'lists' 	, $lists );
		$this->set( 'memberships'	, $memberships );
		$this->set( 'pagination'	, $pagination );
		parent::display( $tpl );
	}

	public function setToolBar()
	{
		// Set the titlebar text
		JToolBarHelper::title( JText::_('Membership List'), 'groupmemberships');

		// Add the necessary buttons
		JToolBarHelper::trash( 'removemembership', JText::_('COM_COMMUNITY_DELETE'));
		//JToolBarHelper::addNew( 'newcategory' , JText::_('COM_COMMUNITY_NEW') );
	}
	
	public function paymentsetting( $data )
	{
		$tpl="payset";	
		$document	= JFactory::getDocument();
		$mainframe	= JFactory::getApplication();
		$jinput = $mainframe->input;
		
		$fields=$data->fields;
		//print_r($fields);
		
		if($fields[id]>0) {
			$model				= $this->getModel( 'GroupMemberships' );
			$savedate			= $model->updatePaymentSet($fields[id], $fields);
			$mainframe->enqueueMessage('Payment Setting update successfully.', 'success');
		}
		
		$paysettings	= $this->get( 'PaymentSettings' );
		//print_r($paysettings);
		
		//echo $paysettings->id;

		$this->set( 'paysettings'	, $paysettings );
		parent::display( $tpl );
	}
	
	public function setToolBarPay()
	{
		// Set the titlebar text
		JToolBarHelper::title( JText::_('Membership Settings'), 'groupmemberships');

	}
}