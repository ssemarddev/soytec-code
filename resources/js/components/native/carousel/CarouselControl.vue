<script>
    import Mixin from "./CarouselControlMixin.js"

    export default {
        /**
         * @mixin: ./CarouselControlMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <div class="d-flex" style="font-size: 0.95em">
        <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-white border shadow-sm rounded-3">
            <div class="select"></div>
            <template v-for="(page, index) in windows">
                <button v-show="!page.hidden" :id="page.id" @click="changePage(index)" :class="{ select: page.active }" class="nav-link p-2 rounded-3" data-bs-target="#carousel" :data-bs-slide-to="index">
                    {{ page.name }}
                </button>
            </template>
        </ul>
    </div>
</template>

<style scoped>
    ul {
        position: relative;
    }
    div.select {
        content: " ";
        position: absolute;
        height: calc(100% - 0.5rem);
        background-color: var(--bs-nav-pills-link-active-bg);
        border-radius: var(--bs-border-radius-lg) !important;
        transition: left ease-in 0.2s, width ease-out 0.15s, top ease-out 0.15s;
    }
    button {
        z-index: 5;
    }
    button.select {
        color: var(--bs-nav-pills-link-active-color);
    }
</style>
