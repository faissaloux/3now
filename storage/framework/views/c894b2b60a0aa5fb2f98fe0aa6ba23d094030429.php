<!-- Header -->
<?php
$users = get_new_user();
$providers = get_new_provider();?>
<div class="site-header navbar-fixed-top">
   <nav class="navbar navbar-light">
      <div class="container-fluid">
         <div class="col-sm-1 col-xs-1">
            <div class="hamburger hamburger--3dy-r">
               <div class="hamburger-box">
                  <div class="hamburger-inner"></div>
               </div>
            </div>
         </div>
         <div class="col-sm-2 col-xs-2">
            <div class="navbar-left" style="background-color: #fff;">
               <a class="navbar-brand" href="<?php echo e(url('admin/dashboard')); ?>" style="background:white;">
                  <div class="logo">
                     <img  style="width: 132px;height: 40px;" src=" <?php echo e(asset(Setting::get('site_logo'))); ?>">
                  </div>
               </a>
               <div class="toggle-button-second dark float-xs-right hidden-md-up">
                  <i class="ti-arrow-left"></i>
               </div>
               <div class="toggle-button dark float-xs-right hidden-md-up" data-toggle="collapse" data-target="#collapse-1">
                  <span class="more"></span>
               </div>
            </div>
         </div>
         <div class="col-sm-9 col-xs-9">
            <div class="navbar-right navbar-toggleable-sm collapse" id="collapse-1">
               <ul class="nav navbar-nav float-md-right">
                  <li class="nav-item dropdown">
                     <a class="nav-link" href="<?php echo e(url('/')); ?>"  target="_blank">
                         Website
                     </a>
                  </li>
               <li class="nav-item dropdown">
               <a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
               <i class="ti-bell"></i>
               <span class="hidden-md-up ml-1">Trip</span>
               <span class="tag tag-success top">1</span>
               </a>
               <div class="dropdown-tasks dropdown-menu dropdown-menu-right animated fadeInUp">
                  
                  <div class="t-item">
                     <div class="mb-0-5">
                        <a class="text-black" href="#">New User Signup</a>
                        <!--<span class="float-xs-right text-muted">60%</span>-->
                     </div>
                     <progress class="progress progress-success progress-sm" value="100" max="100">100%</progress>
                     <a class="text-black" href="#"><?php echo e(ucwords($providers[0]['first_name'])); ?></a>
                  </div>
                  </a>
               </div>
            </li>
            <li class="nav-item dropdown">
                
               <a class="nav-link" href="#" data-toggle="dropdown" aria-expanded="false">
               <i class="ti-basketball"></i>
               <span class="hidden-md-up ml-1">Notifications</span>
               <span class="tag tag-danger top"><?php echo e($users->count()+$providers->count()); ?></span>
               </a>
               
                  
               <div class="dropdown-messages dropdown-tasks dropdown-menu dropdown-menu-right animated fadeInUp">
                   <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                   
                  <div class="m-item">
                     <div class="mi-icon bg-info"><span class="avatar box-32">
               <img src="/asset/img/placeholder_avatar.png" alt="">
               </span></div>
                     <div class="mi-text"><a class="text-black" href="#"><?php echo e(ucwords($user->first_name)); ?></a> <span class="text-muted">does sign up</span> <a class="text-black" href="#"></a></div>
                     <div class="mi-time"><?php echo e($user->created_at->diffForHumans()); ?></div>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                  <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                   
                  <div class="m-item">
                     <div class="mi-icon bg-info"><span class="avatar box-32">
               <img src="<?php echo e(img($provider->avatar)); ?>" alt="">
               </span></div>
                     <div class="mi-text"><a class="text-black" href="#"><?php echo e(ucwords($provider->first_name)); ?></a> <span class="text-muted">does sign up</span> <a class="text-black" href="#"></a></div>
                     <div class="mi-time"><?php echo e($provider->created_at->diffForHumans()); ?></div>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                 <!-- <span class="name"><?php echo e($user[0]['first_name']); ?></span>-->
                  <!--<a class="dropdown-more" href="#">
                  <strong>View all notifications</strong>
                  </a>-->
               </div>
               
            </li>
                  <li class="nav-item dropdown hidden-sm-down">
                     <a href="#" data-toggle="dropdown" aria-expanded="false">
                     <span class="avatar box-32">
                     <img src="<?php echo e(img(Auth::guard('admin')->user()->picture)); ?>" alt="">
                     </span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right animated fadeInUp">
                        <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                        <i class="ti-user mr-0-5"></i> Profile
                        </a>
                        <a class="dropdown-item" href="<?php echo e(route('admin.password')); ?>">
                        <i class="ti-settings mr-0-5"></i> Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo e(route('admin.help')); ?>"><i class="ti-help mr-0-5"></i> Help</a>
                        <a class="dropdown-item" href="<?php echo e(url('/admin/logout')); ?>"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();"><i class="ti-power-off mr-0-5"></i> Sign out</a>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </nav>
</div>