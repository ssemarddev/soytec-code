<script>
    import Mixin from "./CarouselMixin.js"

    export default {
        /**
         * @mixin: ./CarouselMixin.js
         */
        mixins: [Mixin]
    }
</script>

<template>
    <div class="module-container p-3">
        <CarouselControl :windows="windows" />
        <div id="carousel" class="carousel slide">
            <div class="carousel-inner">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>
