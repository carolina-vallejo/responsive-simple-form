<?php
  session_start();
  include("simple-php-captcha.php");

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" /> 

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">

<title>A simple and responsive FORM </title>
<link rel="stylesheet" type="text/css" href="css/formstyles.css">
<style>
  body{
    margin: 0;
    padding: 0;
  }
</style>
</head>

<body>

<?php
  /*-------MAIL FORMATING--------*/
    $cabeceras = "From: " . strip_tags($_POST['email']) . "\r\n";
    $cabeceras .= "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/html; charset=ISO-8859-1";

    $mensaje='<div style="font-size:14px;font-family:Arial, Helvetica, sans-serif;">';

    $mensaje.='<p style="font-size:120%;margin-top:0px;margin-bottom:0px;margin-right:0px;margin-left:0px;" ><strong>'. _('Contact Form') .'</strong></p><br />';
    $mensaje.='<p style="margin-top:0px;margin-bottom:0px;margin-right:0px;margin-left:0px;" ><span style="color:#666">'. _('Name') .': </span> '.$_POST['nombre'].'</p>';
    $mensaje.='<p style="margin-top:0px;margin-bottom:0px;margin-right:0px;margin-left:0px;" ><span style="color:#666">'. _('Email') .':</span>'.$_POST['email'].'</p>';
    $mensaje.='<p style="margin-top:0px;margin-bottom:0px;margin-right:0px;margin-left:0px;" ><span style="color:#666">'. _('Message') .':</span></p>';
    $mensaje.='<p style="margin-top:0px;margin-bottom:0px;margin-right:0px;margin-left:0px;" >'.$_POST['mensaje'].' </p>';

    $mensaje.= '</div>';

    $destino= "example@example.com";
    $asunto = _('Message sent by') .': '.$_POST['nombre'];

    /*-----*/  
    $warning1="";
    $warning2="";

?>

<!-- FORM -->

<div class="wrap_form">
  <?php
  if (isset($_POST['submit1'])){
    if(!empty($_POST['captchacode'])){
      
      if(strtolower($_SESSION['captcha']['code']) == strtolower($_POST['captchacode'])){
        mail($destino,$asunto,$mensaje,$cabeceras);
        $warning1 = '<div class="aviso2"> ' . _('Your message was sent successfully. Thanks.') .' </div>';
      }else{
        $warning1 = '<div class="aviso1"> '._('Validation errors occurred. Please confirm the fields and submit it again.').'</div>';
      }
    }else{
      $warning2 = '<div class="aviso1">'._('Validation errors occurred. Please confirm the fields and submit it again.').'</div>';
    }
  }

   $_SESSION['captcha'] = simple_php_captcha( array(
    'min_length' => 5,
    'max_length' => 5,
    'backgrounds' => array('backgrounds/white-wave_p.png'),
    'min_font_size' => 21,
    'max_font_size' => 21,
    'color' => '#dadada',
    'angle_min' => 0,
    'angle_max' => 5,
    'shadow' => false,
    'shadow_color' => '#fff',
    'shadow_offset_x' => 0,
    'shadow_offset_y' => 0
    ));
  
  ?> 

  <form class="all_form" method="post" action="index.php" autocomplete="off">
    <div class="contacto_titulo">
    <?php echo _('CONTACT FORM') ?>
</div>
    <div class="group_form three">
      <label>Nombre:</label>
      <input name="nombre" type="text" placeholder='<?php echo _('Name') ?>' class="reset_form style_textinput"/>
      <label>Teléfono:</label>
      <input name="telefono" type="text" placeholder='<?php echo _('Phone number') ?>' class="reset_form style_textinput"/>
      <label>Email:</label>
      <input name="email" type="text"  placeholder='<?php echo _('Email') ?>' class="reset_form style_textinput"/>
    </div>
    <div class="group_form one">
      <label>Mensaje:</label>
      <textarea name="mensaje"  placeholder='<?php echo _('Message') ?>' class="reset_form style_textinput"></textarea>
      <div class="wrapcaptcha">
        <?php
          echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />';
        ?>
        <input id="inputcode" name="captchacode" placeholder="" type="text" class="reset_form style_textinput"/>
        
        <? echo $warning2; ?>
        <input type="submit" name="submit1" value='<?php echo _('Send') ?>' class="reset_form style_btn" />
      </div>
      <div>
        <? echo $warning1; ?>
      </div>            
    </div>   
  </form>


</div> 
<!-- FINAL FORM -->

</body>
</html>

