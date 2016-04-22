<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 06.04.16
 * Time: 13:01
 *
 */
 ?>

<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="36" style="padding: 0; margin: 0;">
      <table border="0" cellpadding="0" cellspacing="0" width="512" style="border-collapse: collapse;
     mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin-left: auto; margin-right: auto;">
         <tr>
            <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
            <td rowspan = "2" width = "262" height="25" style="padding: 0; margin: 0;
             font-family: 'HelveticaNeue UltraLight', sans-serif; font-size: 24px; text-align: center;
              vertical-align: middle;"> Hello, <span><?=Yii::$app->params['applicationName']?>,</span> </td>
            <td colspan = "2" width = "125" height="12" valign="top" style="padding: 0; margin: 0;"></td>
         </tr>
         <tr>
            <td colspan = "2" width = "125" height="0" valign="top" style="padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;"></td>
            <td colspan = "2" width = "125" height="0" valign="top" style="padding: 6px 0; margin: 0; border-top: solid 1px #a3d8f0;"></td>
         </tr>
         <tr>
            <td width = "29" style="padding: 0; margin: 0;"></td>
            <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;"><?=$name?> from <?=$company?> <?=$country?> has requested a quote for the following project</td>
            <td width = "29" style="padding: 0; margin: 0;"></td>
         </tr>
      </table>
   </td>

   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="16" style="padding: 19px 0 10px 0; margin: 0; font-family: 'HelveticaNeue Regular',
    sans-serif; font-size: 16px; font-weight: normal; text-align: center;">
      <strong style=" font-family: 'HelveticaNeue Bold', sans-serif; font-size: 16px; font-weight: bold;"><h3>Details:</h3></strong></td>
   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">
      <?php if ( $websiteState ) : ?>
      <span>Website State : <?php echo $websiteState;?></span>
      <?php endif;?></td>
   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">
      <?php if ( $platform  ) : ?>
         <span>Platform : <?php echo $platform;?></span>
      <?php endif;?></td>
   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">

         <span>Services :<?php echo ($services ? implode(", ", $services) : "");?></span>
   </td>
   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">
      <?php if ( $frontendPlatform ) : ?>
         <span>Frontend Platform : <?php echo $frontendPlatform;?></span>
      <?php endif;?></td>
   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">
      <?php if ( $backendPlatform ) : ?>
         <span>Backend Platform : <?php echo $backendPlatform;?></span>
      <?php endif;?></td>
   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">
      <?php if ( $whenStart) : ?>
         <span>Start :  <?php echo $whenStart;?></span>
      <?php endif;?></td>
   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td width = "29" style="padding: 0; margin: 0;"></td>
   <td colspan = "3"  height="15" style="padding: 10px 0 4px 0; margin: 0;
     font-family: 'HelveticaNeue Regular', sans-serif; font-size: 15px;
     font-weight: normal; text-align: center;">
      <?php if ( $budget ) : ?>
         <span>Budget : <?php echo $budget;?></span>
      <?php endif;?></td>
   <td width = "29" style="padding: 0; margin: 0;"></td>
</tr>
<tr>
   <td colspan = "2" width = "237" height="34" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>

   <td width = "96"  valign="top" style="padding:0; margin: 0; text-align: center; background-color: #a3d8f0;
        vertical-align: middle;">
      <?php if ( $description ) : ?>
      <span><h3>Detailed description:</h3></span>

         <?=nl2br( $description )?>

      <?php endif; ?>
   </td>

   <td colspan = "2" width = "237" height="34" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
</tr>

<tr>
   <td colspan = "5"  height="13" style="padding: 0; margin: 0; background-color: #a3d8f0;"></td>
</tr>



<!--Hello <?/*=Yii::$app->params['applicationName']*/?>,
<p>
   <?/*=$name*/?> from <?/*=$company*/?> <?/*=$country*/?> has requested a quote for the following project
</p>

<h3>Details:</h3>
<ul>
   <?php /*if ( $websiteState ) : */?>
   <li>Website State : <?php /*echo $websiteState;*/?></li>
   <?php /*endif;*/?>
   <?php /*if ( $platform ) : */?>
   <li>Platform : <?php /*echo $platform;*/?></li>
   <?php /*endif;*/?>
   <li>Services : <?php /*echo ($services ? implode(", ", $services) : "");*/?></li>
   <?php /*if ( $frontendPlatform ) : */?>
   <li>Frontend Platform : <?php /*echo $frontendPlatform;*/?>
   <?php /*endif;*/?>
   <?php /*if ( $backendPlatform ) : */?>
   <li>Backend Platform : <?php /*echo $backendPlatform;*/?>
   <?php /*endif;*/?>
   <?php /*if ( $whenStart ) : */?>
   <li>Start : <?php /*echo $whenStart;*/?>
   <?php /*endif;*/?>
   <?php /*if ( $budget ) : */?>
      <li>Budget : <?php /*echo $budget;*/?>
   <?php /*endif;*/?>
 </ul>
<?php /*if ( $description ) : */?>
<h3>Detailed description:</h3>

    <?/*=nl2br( $description )*/?>

--><?php /*endif; */?>


