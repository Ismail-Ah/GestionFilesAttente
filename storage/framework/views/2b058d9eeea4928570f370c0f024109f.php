<?php if (isset($component)) { $__componentOriginalf88ba482e40fc6d764b7c81c73343262 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf88ba482e40fc6d764b7c81c73343262 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout3','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <style>
        body {
            background-color: #5f4dee; /* Replace with your desired color */
        }
    </style>
     <header id="header" class="ex-2-header">
    <div class="header-content">
    <div id="app">
        <router-view></router-view>
    </div>
    </div>
     </header>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf88ba482e40fc6d764b7c81c73343262)): ?>
<?php $attributes = $__attributesOriginalf88ba482e40fc6d764b7c81c73343262; ?>
<?php unset($__attributesOriginalf88ba482e40fc6d764b7c81c73343262); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf88ba482e40fc6d764b7c81c73343262)): ?>
<?php $component = $__componentOriginalf88ba482e40fc6d764b7c81c73343262; ?>
<?php unset($__componentOriginalf88ba482e40fc6d764b7c81c73343262); ?>
<?php endif; ?><?php /**PATH D:\Documents\stage\project\resources\views\ticketDispenser.blade.php ENDPATH**/ ?>