<?php if (isset($component)) { $__componentOriginalc5aa37dc5fe6d26bb482e7431ed136b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc5aa37dc5fe6d26bb482e7431ed136b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout2','data' => ['action' => 'login']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => 'login']); ?>
    <style>
        body {
            background-image: url('/img/blob2.svg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .card {
            background-color: #023047;
            color: #FFFFFF; 
            border-radius: 20px;
        }

        .card-header,
        .card-body,
        .form-control,
        .form-check-label {
            color: #FFFFFF; /* Set the text color to white */
        }

        .form-control {
            background-color: #023047; /* Matching the background of the input fields to the card */
            border: 1px solid #FFFFFF; /* Optional: Add a white border for the input fields */
        }

        .form-control::placeholder {
            color: #FFFFFF; /* Set the placeholder text color to white */
        }

        .btn-primary {
            background-color: #FB8500; /* Adjust button color if needed */
            border: none;
        }

        .btn-primary:hover {
            background-color: #FF9C2F; /* Optional: Add a hover color for the button */
        }

        .btn-link {
            color: #FFFFFF; /* Set the link color to white */
        }

        .btn-link:hover {
            color: #FF9C2F; /* Optional: Add a hover color for the link */
        }
    </style>

    <header id="header" class="ex-2-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header"><?php echo e(__('Se Connecter')); ?></div>

                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>
        
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Email Address')); ?></label>
        
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
        
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
        
                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end"><?php echo e(__('Password')); ?></label>
        
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">
        
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
        
                               
        
                                <div class="row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <?php echo e(__('Se Connecter')); ?>

                                        </button>
        
                                        
                                            <a class="btn btn-link" href="<?php echo e(route('register')); ?>">
                                                <?php echo e(__('J\'ai pas un compte?')); ?>

                                            </a>
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of header-content -->
    </header> <!-- end of header -->


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc5aa37dc5fe6d26bb482e7431ed136b9)): ?>
<?php $attributes = $__attributesOriginalc5aa37dc5fe6d26bb482e7431ed136b9; ?>
<?php unset($__attributesOriginalc5aa37dc5fe6d26bb482e7431ed136b9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc5aa37dc5fe6d26bb482e7431ed136b9)): ?>
<?php $component = $__componentOriginalc5aa37dc5fe6d26bb482e7431ed136b9; ?>
<?php unset($__componentOriginalc5aa37dc5fe6d26bb482e7431ed136b9); ?>
<?php endif; ?><?php /**PATH D:\Documents\stage\project\resources\views\auth\login.blade.php ENDPATH**/ ?>