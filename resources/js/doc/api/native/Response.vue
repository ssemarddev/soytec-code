<script>
export default {
    props: {
        response: Object,
        background: String
    }
}
</script>
<template>
    <div>
        <div class="d-flex mb-2">
            <span class="badge me-1" :style="{background: background}">{{ response.code }}</span>
            <span class="badge" :style="{background: background}">{{ response.type }}</span>
        </div>
        <highlightjs autodetect :code="response.content" />
    </div>
</template>
