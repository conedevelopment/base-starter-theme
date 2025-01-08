<?php
$base_title = $args['title'] ?? null;
$base_description = $args['description'] ?? null;
?>
<template x-teleport="body">
    <div
        class="modal-backdrop"
        x-show="open"
        x-transition.opacity
        @keydown.escape="close"
    >
        <div
            role="dialog"
            aria-modal="true"
            tabindex="0"
            class="modal"
            @click.away="close"
            x-show="open"
            x-transition
            x-trap.noscroll="open"
        >
            <div class="modal__header">
                <h2 class="modal__title"><?php echo $base_title; ?></h2>
                <button class="btn btn--primary btn--sm btn--icon modal__close" aria-label="<?php _e('Close modal', 'base'); ?>" @click="close">
                    <?php echo base_get_inline_svg_icon('close.svg', 'btn__icon'); ?>
                </button>
            </div>
            <div class="modal__body">
                <div class="post-content">
                    <?php echo $base_description; ?>
                </div>
            </div>
        </div>
    </div>
</template>
