<!doctype html>
<html lang="en">
   <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/all.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/plugins/datatables/datatables.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">        

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
   </head>
   <body>

        <nav class="navbar navbar-dark bg-dark navbar-expand-lg"> 
            <div class="container">
                <?php if(auth()->guard()->guest()): ?>
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>"><?php echo e(config('app.name', 'Laravel')); ?></a>
                <?php else: ?>
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>">Larajax</a>
                <?php endif; ?>
                
                <ul class="navbar-nav navbar-right ml-auto">    
                    <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                        </li>
                        <?php if(Route::has('register')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="create-contact" data-toggle="modal" data-target="#modal-create-contact"><i class="fas fa-user"></i> Create A Contact</a>
                        </li>       
                        <li class="nav-item pl-4 pl-1">
                            <span class="navbar-text text-white">Hi <span class="k"><?php echo e(Auth::user()->name); ?></span>!</span>
                        </li>         
                        <li class="nav-item">                            
                            <a class="nav-link" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Log out</a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                             </form>
                        </li>
                    <?php endif; ?>    
                </ul> 
            </div>         
        </nav>        

        <div class="content">
            <div class="container">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div> 

        <?php echo $__env->make('parts.modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- JavaScript -->       
        <script src="<?php echo e(asset('js/jquery-3.3.1.js')); ?>"></script>
        <script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/plugins/datatables/datatables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/plugins/mask/jquery.mask.min.js')); ?>"></script>       
        <?php echo $__env->yieldContent('extra-js'); ?>

   </body>
</html><?php /**PATH C:\mysql\htdocs\laravel-ajax\laravel-ajax\resources\views/layouts/app.blade.php ENDPATH**/ ?>