
<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <div class="comments-section">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?> 
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    comments
                </div> 
            </div>
    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="comment" style="margin-left: <?php echo $comment["depth"] * 20 ."px" ?>"  data-comment-depth ="<?php echo $comment["depth"]?>" data-comment-id ="<?php echo $comment["id"]?>">
            <header class="comment__header">
                <span class="users-messages"><?php echo  $comment["name"] ?></span>
                <hr class ="line-user">
                <span class="date-messages"> <?php echo  $comment["created_at"]  ?> </span>
            </header>
            <div class="comment__body"><?php echo  $comment["message"] ?></div>

            <?php if ($comment["depth"] < 3 ):?> 
                <footer class="comment__footer">
                    <p class="comment__reply">Reply</p>
                </footer>
                <form class="form-reply" method="post" action ="<?php echo route('reply.add'); ?>">
                <?php echo csrf_field(); ?>
                    <input class="hidden" name="parent_id" value ="<?php echo $comment["id"]?>">
                    <textarea class="form-control form-reply__textarea"   name="answer-reply" rows="3"></textarea>
                    <button class="btn btn-primary form-reply__btn" id ="btn-answer-reply" type="button" name="btn-answer-reply">Reply a comment</button>
                </form>
            <?php endif;?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class ="parent-answer">
            <form  class = "form-reply-answer" method ="post" action="<?php echo route('reply.add'); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <textarea class ="textarea-id" cols="100" rows="10" id="comment-answer" name="comment"></textarea>
                </div>
                    <button id = "btn-answer-id" class="btn-answer" type="button" name="submit"> Отправить </button>
            </form>
        </div>
    </div>
</div>
 <?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>

<?php /**PATH C:\OpenServer\domains\guestbook\resources\views/answer.blade.php ENDPATH**/ ?>