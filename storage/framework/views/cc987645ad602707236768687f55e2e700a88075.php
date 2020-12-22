<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
	
    <title><?php echo e(Setting::get('site_title')); ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo e(Setting::get('site_icon')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="<?php echo e(asset('asset/front/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('asset/front_dashboard/css/bootstrap.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('asset/front_dashboard/css/custom.css')); ?>?v=dmrfzdjtkmzektjlmz" rel="stylesheet">  
    <link href="<?php echo e(asset('asset/front_dashboard/css/hamburgers.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('asset/front_dashboard/css/owl.carousel.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('asset/front_dashboard/css/owl.theme.css')); ?>" rel="stylesheet">
	<link href="<?php echo e(asset('asset/front/css/slick.css')); ?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo e(asset('asset/front/css/slick-theme.css')); ?>"/>
	<link href="<?php echo e(asset('asset/front/css/dashboard-style.css')); ?>" rel="stylesheet">
   
   <?php echo $__env->yieldContent('styles'); ?>
   <style>
       .hboynas {
    visibility: hidden !important;
}

.hboynas2 {
    display: none !important;
}
   </style>
</head>
<body>
<div class="index">
	
	<?php echo $__env->make('website.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
	<?php echo $__env->yieldContent('content'); ?>
	
	<?php echo $__env->make('website.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script>
		base_url = "<?php echo e(env('APP_URL')); ?>"; 
	</script>
    <script src="<?php echo e(asset('asset/front_dashboard/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/front_dashboard/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/front_dashboard/js/owl.carousel.js')); ?>"></script>
    <script>
        $("#left_menu_open").click(function(){
            $("#left_menu").addClass("open");
        });
        $(".close").click(function(){
            $("#left_menu").removeClass("open");
        });
        
        $(".hamburger").click(function(){
            $(".side_menu").toggleClass("open");
			$(this).toggleClass("is-active");
        }); 
         $(document).click(function(event) {    

          //if you click on anything except the modal itself or the "open modal" link, close the modal
          if (!$(event.target).closest(".hamburger,.is-active").length) {
            $("body").find("#left_menu").removeClass("open");
            $("body").find(".hamburger").removeClass("is-active");
          }
        });
		var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

		var	site_url ="<?php echo e(url('/')); ?>";
  
</script>

<?php echo $__env->yieldContent('scripts'); ?>
   
</body>
</html>

