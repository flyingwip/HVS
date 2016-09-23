<header class="banner">

  <a href="/">
    <header class="container-fluid logo">

    </header>
</a>    

<?php if( !is_front_page() && is_page('hint')!=1 && is_page('form')!=1 && is_page('bedankt')!=1 && is_page('bedank')!=1 ): ?>  
  <div class="container-fluid hvs-header <?php echo $_SESSION['hint'] ; ?>">
<?php else: ?>  
  <div class="container-fluid hvs-header">
<?php endif; ?>
  <div class="row">
        <div class="pay_off vcenter">
          <h1 >Herfsthints</h1>   
          <h4 >Kies en win je favoriete verwenmoment</h4>
        </div>  
        <div class="inivitation">

         <?php if ($_SESSION['ontvanger'] ): ?>
           <label class="name ontvanger">Hallo <?php echo $_SESSION['ontvanger']; ?> ,</label>
        <?php else: ?>
           <label class="name ontvanger">Hallo ...</label> 
        <?php endif; ?> 

          

          <?php
          $text = array(
            'breakfast' => 'in een gezond ontbijt op bed...' , 
            'fiets' => 'om lekker uit te waaien op de fiets...' , 
            'treatment' => 'in een ontspannende facial treatment...' , 
            'dinner' => "in zo'n romantisch diner voor 2..." , 
          );

          $images = array(
            'breakfast' => 'breakfast.png' , 
            'fiets' => 'fiets.png' , 
            'treatment' => 'treatment.png' , 
            'dinner' => "dinner.png" 
          );

          $threelines = '';
          if($_SESSION['hint']=='treatment'){
             $threelines = 'three_lines'; 
          }

          ?>

           <label class="type">Ik heb wel zin <?php echo $text[$_SESSION['hint']] ;?> </label>
          <!-- 160x100 -->


          <img class="img-center" src="<?php echo get_template_directory_uri(); ?>/dist/images/<?php echo $images[$_SESSION['hint']] ;?>"  alt="">
  
          <?php if ($_SESSION['voornaam'] ): ?>
             <label class="name afzender <?php echo $threelines;?>">Liefs <?php echo $_SESSION['voornaam']; ?></label>
          <?php else: ?>
             <label class="name afzender <?php echo $threelines;?>">Liefs ...</label>
          <?php endif; ?> 

          
        </div>
  </div>      
 </div>

  <!-- <div class="container">
    <a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    <nav class="nav-primary">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div> -->
</header>
