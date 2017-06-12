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

?>
<script type="text/javascript" language="javascript">
/**
 * This function needs to be here because, Joomla calls it
 **/
Joomla.submitbutton = function(action){
	submitbutton( action );
}

function submitbutton(action)
{
	if(action == 'newcategory')
	{
		azcommunity.editGroupCategory( 0 , '<?php echo JText::_('COM_COMMUNITY_CATEGORY_NEW'); ?>');
	}

	if(action == 'removemembership')
	{
		submitform(action);
	}
}
</script>
	<form action="index.php?option=com_community&view=groupmemberships&act=del" method="post" name="adminForm" id="adminForm">
	<table class="table table-bordered table-hover">
		<thead>
			<tr class="title">
				<th width="10"><?php echo JText::_('COM_COMMUNITY_NUMBER'); ?></th>
				<th width="10">
					<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
					<span class="lbl"></span>
				</th>
				<th width="100" >
                    <?php echo JText::_('Group'); ?>
				</th>
				<th >
					<?php echo JText::_('Member'); ?>
				</th>
				<th>
					<?php echo JText::_('Amount'); ?>
				</th>
				<th >
					<?php echo JText::_('Transaction ID'); ?>
				</th>
				<th >
					<?php echo JHTML::_('grid.sort',   JText::_('Join Date'), 'adddate', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
				<th >
					<?php echo JHTML::_('grid.sort',   JText::_('Expiry Date'), 'expdate', $this->lists['order_Dir'], $this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>
<?php
		$i		= 0;

		foreach($this->memberships as $membership)
		{
			
			$model				= $this->getModel( 'GroupMemberships' );
			$groupdata			= $model->getGroupdata($membership->groupid);
			$userpdata			= $model->getUserdata($membership->userid);
			//print_r($groupdata);
?>
			<tr>
				<td align="center"><?php echo $i + 1; ?></td>
				<td>
					<?php echo JHTML::_('grid.id', $i++, $membership->id); ?>
					<span class="lbl"></span>
				</td>
				<td>
					<?php echo $groupdata->name;?>
				</td>
				<td><?php echo $userpdata->name; ?></td>
				<td>
					<?php echo $membership->amount;?>
				</td>
				<td>
					<?php echo $membership->transactionId;?>
				</td>
				<td align="center"><?php echo $membership->adddate; ?></td>
				<td align="center" ><?php echo $membership->expdate; ?></td>
			</tr>
<?php
		}
		
		if($i==0) { echo '<tr><td align="center" colspan="10">Membership Not Found.</td></tr>'; }
?>


	</table>

	<div class="pull-left">
	<?php echo $this->pagination->getListFooter(); ?>
	</div>

	<div class="pull-right">
	<?php echo $this->pagination->getLimitBox(); ?>
	</div>

	<input type="hidden" name="view" value="groupmemberships" />
	<input type="hidden" name="option" value="com_community" />
	<input type="hidden" name="task" value="groupmemberships" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	</form>