<?php
/**
* @copyright (C) 2013 iJoomla, Inc. - All rights reserved.
* @license GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
* @author iJoomla.com <webmaster@ijoomla.com>
* @url https://www.jomsocial.com/license-agreement
* The PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0
* More info at https://www.jomsocial.com/license-agreement
*/
defined('_JEXEC') or die();
?>

<div class="joms-page">
    <div class="joms-list__search">
        <div class="joms-list__search-title">
            <h3 class="joms-page__title"> <?php echo JText::_('My Memberships'); ?></h3>
        </div>
	</div>
    
    <?php if($submenu){ ?>
        <?php echo $submenu;?>
        <div class="joms-gap"></div>
    <?php } ?>
    
        <div class="joms-gap"></div>
        
        <div id="joms-profile--information" class="joms-tab__content">
            <table class="table table-bordered table-hover">
		<thead>
			<tr class="title">
				<th width="100" >
                    <?php echo JText::_('Group'); ?>
				</th>
				<th>
					<?php echo JText::_('Amount'); ?>
				</th>
				<th >
					<?php echo JText::_('Transaction ID'); ?>
				</th>
				<th >
					<?php echo JText::_('Join Date'); ?>
				</th>
				<th >
					<?php echo JText::_('Expiry Date'); ?>
				</th>
			</tr>
		</thead>
<?php
		$i		= 0;

		foreach($membership as $memberships)
		{
			
			$model				= CFactory::getModel('groups');
			$groupdata			= $model->getGroupdata($memberships->groupid);
			//print_r($groupdata);
			$i++;
?>
			<tr>
				<td>
					<?php echo $groupdata->name;?>
				</td>
				<td>
					<?php echo $memberships->amount;?>
				</td>
				<td>
					<?php echo $memberships->transactionId;?>
				</td>
				<td align="center"><?php echo $memberships->adddate; ?></td>
				<td align="center" ><?php echo $memberships->expdate; ?></td>
			</tr>
<?php
		}
		
		if($i==0) { echo '<tr><td align="center" colspan="10">You have no Memberships.</td></tr>'; }
?>


	</table>
        </div>
</div>
