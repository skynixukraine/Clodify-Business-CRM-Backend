<?php
/**
 * Created by PhpStorm.
 * User: lera
 * Date: 06.04.16
 * Time: 13:01
 *
 */
 ?>
Hello <?=Yii::$app->params['applicationName']?>,
<p>
   <?=$name?> from <?=$company?> <?=$country?> has requested a quote for the following project
</p>

<h3>Details:</h3>
<ul>
   <?php if ( $websiteState ) : ?>
   <li>Website State : <?php echo $websiteState;?></li>
   <?php endif;?>
   <?php if ( $platform ) : ?>
   <li>Platform : <?php echo $platform;?></li>
   <?php endif;?>
   <li>Services : <?php echo ($services ? implode(", ", $services) : "");?></li>
   <?php if ( $frontendPlatform ) : ?>
   <li>Frontend Platform : <?php echo $frontendPlatform;?>
   <?php endif;?>
   <?php if ( $backendPlatform ) : ?>
   <li>Backend Platform : <?php echo $backendPlatform;?>
   <?php endif;?>
   <?php if ( $whenStart ) : ?>
   <li>Start : <?php echo $whenStart;?>
   <?php endif;?>
   <?php if ( $budget ) : ?>
      <li>Budget : <?php echo $budget;?>
   <?php endif;?>
 </ul>
<?php if ( $description ) : ?>
<h3>Detailed description:</h3>

    <?=nl2br( $description )?>

<?php endif; ?>


