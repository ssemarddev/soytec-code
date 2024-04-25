<script>
    import Mixin from "./AlertMixin.js"

    export default {
        /**
         * @mixin: ./AlertMixin.js
        */
        mixins: [Mixin],
    }
</script>

<template>
    <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex position-relative">
            <div class="toast-body">
                <div>
                    <i :class="config.icon" :style="{ color: config.color }"></i>
                </div>
                <div>
                    <h6 class="mb-1">{{ config.title }}</h6>
                    <p class="mb-0">{{ config.text }}</p>
                </div>
            </div>
            <div :style="{ background: config.color }" class="toast-progress"></div>
            <button type="button" class="btn-close me-2 mt-2 ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</template>

<style scoped>
    .toast-body {
        display: flex;
        align-items: center;
    }
    .toast-body > div:last-child {
        border-left: solid 1px #d9d9d9;
        padding: 0.5rem 0.75rem;
    }
    .toast-body > div:first-child {
        margin-left: 0.5rem;
        margin-right: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    i {
        font-size: 4em;
    }
    h6 {
        color: #000;
        font-weight: 700;
    }
    p {
        color: #949494;
    }
    .toast-progress {
        position: absolute;
        width: 100%;
        height: 5px;
        bottom: 0;
        border-bottom-left-radius: var(--bs-toast-border-radius);
        border-bottom-right-radius: var(--bs-toast-border-radius);
        transition: width ease-in-out 0.1s;
    }
</style>
