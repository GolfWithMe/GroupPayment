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
            <h3 class="joms-page__title"> <?php echo JText::_('Join Group Membership'); ?></h3>
        </div>
	</div>
        <div class="joms-gap"></div>
        
        <div id="joms-profile--information" class="joms-tab__content">
            <?php if ( $groups ) { ?>
            <form name="jsform-group-schedule" id="frmGroupSchedule" action="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=joinmembership') ?>" method="POST" class="js-form">
                <div class="joms-form__group has-privacy" for="field2">
                    <span title="Select Group">Membership Name</span>
                    <span><?php echo $membership->memname; ?></span>
                </div>
                <div class="joms-form__group has-privacy" for="field2">
                    <span title="Select Group">Membership Period</span>
                    <span><?php echo $membership->memmonth; ?> Months</span>
                </div>
                <div class="joms-form__group has-privacy" for="field2">
                    <span title="Select Group">Membership Amount</span>
                    <span>$<?php echo $membership->amount; ?></span>
                </div>
                <div class="joms-form__group has-privacy" for="field2">
                    <span title="Select Group">Payment Method</span>
                    <span><?php echo $membership->payname; ?></span>
                </div>
                <div class="joms-form__group has-privacy" for="field2">
                    <span></span>
                    <label><input type="checkbox" name="agree" value="notify" required /> Agree Terms and Conditions</label>
                </div>
                <div class="joms-form__group">
                    <span></span>
                    <input type="hidden" name="selstep" value="payment" />
                    <input type="hidden" name="groupid" value="<?php echo $groups[0]->id; ?>" />
                    <input type="submit" class="joms-button--primary joms-button--full-small" value="<?php echo "Join Now";?>">
                </div>
            </form>
        
        <?php } else { ?>
            <div class="cEmpty cAlert"><?php echo 'You have no join group.'; ?></div>
        <?php } ?>
        </div>
</div>
