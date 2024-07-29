<?php if (isset($component)) { $__componentOriginal4cfb90355b4d8db71d1d51150ad88a4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4cfb90355b4d8db71d1d51150ad88a4f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout4','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout4'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <router-view></router-view>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4cfb90355b4d8db71d1d51150ad88a4f)): ?>
<?php $attributes = $__attributesOriginal4cfb90355b4d8db71d1d51150ad88a4f; ?>
<?php unset($__attributesOriginal4cfb90355b4d8db71d1d51150ad88a4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4cfb90355b4d8db71d1d51150ad88a4f)): ?>
<?php $component = $__componentOriginal4cfb90355b4d8db71d1d51150ad88a4f; ?>
<?php unset($__componentOriginal4cfb90355b4d8db71d1d51150ad88a4f); ?>
<?php endif; ?><?php /**PATH D:\Documents\stage\project\resources\views/TD/TD-services.blade.php ENDPATH**/ ?>