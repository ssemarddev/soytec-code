<script>
    export default {
        props: {
            avatar: String,
        },
        data() {
            return {
                active: this.avatar || "avatar_1.jpg",
            }
        },
        watch: {
            avatar() {
                this.active = this.avatar || "avatar_1.jpg"
            },
        },
        methods: {
            select(avatar) {
                this.active = avatar
            },
        },
    }
</script>

<template>
    <fieldset class="mb-4">
        <input type="hidden" name="avatar" v-model="active" />
        <legend><i class="bi bi-person-circle"></i> Avatar</legend>
        <div class="container-fluid">
            <div class="content">
                <div v-for="n in 20">
                    <label @click="select('avatar_' + n + '.jpg')"><img :class="{ active: active == 'avatar_' + n + '.jpg' }" :src="'src/img/avatars/' + 'avatar_' + n + '.jpg'" class="img-fluid radio-avatar-img" /></label>
                </div>
            </div>
        </div>
    </fieldset>
</template>

<style scoped>
    .content {
        text-align: center;
    }
    .content > div {
        display: inline-flex;
    }
    .radio-avatar-img {
        width: 125px;
        height: 125px;
        padding: 3px;
        margin: 0.4rem;
        border-radius: 1.5rem;
        cursor: pointer;
        transition: box-shadow ease-in-out 0.3s;
    }
    .radio-avatar-img.active {
        box-shadow: 0 0 0.5rem rgba(0, 110, 255, 0.507);
    }
</style>
