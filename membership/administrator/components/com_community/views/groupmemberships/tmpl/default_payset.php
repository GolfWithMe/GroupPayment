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
//print_r($this->paysettings);
$payset=$this->paysettings;
?>
<div class="widget-box">
	<div class="widget-body">
		<div class="widget-main">
        <fieldset class="adminform">
	<form action="index.php?option=com_community&view=groupmemberships&task=paymentsetting" method="post" name="adminForm" id="adminForm">
		<table>
			<tbody>
				<tr>
                    <td width="250" class="key">
                        <span class="js-tooltip" title="<?php echo JText::_('Membership Name'); ?>">
                            <?php echo JText::_( 'Membership Name' ); ?>
                        </span>
                    </td>
                    <td>
                        <input type="text" name="memname" value="<?php echo $payset->memname;?>" size="8" />
                    </td>
                </tr>
                <tr>
                    <td width="250" class="key">
                        <span class="js-tooltip" title="<?php echo JText::_('Membership Amount'); ?>">
                            <?php echo JText::_( 'Membership Amount' ); ?>
                        </span>
                    </td>
                    <td>
                        <input type="text" name="amount" value="<?php echo $payset->amount;?>" size="8" />
                    </td>
                </tr>
                <tr>
                    <td width="250" class="key">
                        <span class="js-tooltip" title="<?php echo JText::_('Membership Month'); ?>">
                            <?php echo JText::_( 'Membership Month' ); ?>
                        </span>
                    </td>
                    <td>
                        <input type="text" name="memmonth" value="<?php echo $payset->memmonth;?>" size="8" />
                    </td>
                </tr>
                <tr>
                    <td width="250" class="key">
                        <span class="js-tooltip" title="<?php echo JText::_('Payment Mode'); ?>">
                            <?php echo JText::_( 'Payment Mode' ); ?>
                        </span>
                    </td>
                    <td>
                        <input type="radio" name="paymode" value="Test" <?php if($payset->paymode=="Test") echo 'checked="checked"';  ?> style="opacity:100; position:inherit;"  /> Test
                        <input type="radio" name="paymode" value="Live" <?php if($payset->paymode=="Live") echo 'checked="checked"';  ?> style="opacity:100; position:inherit;" /> Live
                    </td>
                </tr>
                <tr>
                    <td width="250" class="key">
                        <span class="js-tooltip" title="<?php echo JText::_('Payment Method'); ?>">
                            <?php echo JText::_( 'Payment Method' ); ?>
                        </span>
                    </td>
                    <td>
                        <input type="text" name="payname" value="<?php echo $payset->payname;?>" size="8" />
                    </td>
                </tr>
                <tr>
                    <td width="250" class="key">
                        <span class="js-tooltip" title="<?php echo JText::_('API Username'); ?>">
                            <?php echo JText::_( 'API Username' ); ?>
                        </span>
                    </td>
                    <td>
                        <input type="text" name="apiuser" value="<?php echo $payset->apiuser;?>" size="8" />
                    </td>
                </tr>
                <tr>
                    <td width="250" class="key">
                        <span class="js-tooltip" title="<?php echo JText::_('API Password'); ?>">
                            <?php echo JText::_( 'API Password' ); ?>
                        </span>
                    </td>
                    <td>
                        <input type="text" name="apipassword" value="<?php echo $payset->apipassword;?>" size="8" />
                    </td>
                </tr>
                <tr>
                    <td width="250" class="key">
                        <span class="js-tooltip" title="<?php echo JText::_('API Signature'); ?>">
                            <?php echo JText::_( 'API Signature' ); ?>
                        </span>
                    </td>
                    <td>
                        <input type="text" name="apisignature" value="<?php echo $payset->apisignature;?>" size="8" />
                    </td>
                </tr>
                <tr>
                    <td width="250" class="key">
                    </td>
                    <td>
                      <input type="hidden" name="view" value="groupmemberships" />
                        <input type="hidden" name="option" value="com_community" />
                        <input type="hidden" name="task" value="paymentsetting" />
                      <input type="hidden" name="id" value="<?php echo $payset->id; ?>" />
                    <input type="reset" class="joms-button--primary joms-button--full-small" value="<?php echo "Reset";?>">&nbsp;
                    <input type="submit" class="joms-button--primary joms-button--full-small" value="<?php echo "Update";?>">
                    </td>
                </tr>
                
                
			</tbody>

			
		</table>
        </form>
    </fieldset>
    </div>
	</div>
</div>