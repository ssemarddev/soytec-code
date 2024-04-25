<script>
    export default {
        props: {
            message: Object,
            selection: Array,
            sending: {
                type: Boolean,
                default: false,
            },
        },
    }
</script>
<template>
    <div class="message" :class="{ receive: message.user != null, send: message.user == null, selection: selection != null }">
        <div v-if="selection !== null" class="select">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="selection" @change="selection.push(message)" />
            </div>
        </div>
        <!-- <div class="message-avatar" v-if="message.user !== null">
            <img :src="'src/img/avatars/avatar_12.jpg'" />
        </div> -->
        <div>
            <img v-if="message.annexed !== null && message.annexed !== undefined" class="annexed" :src="message.annexed" />
            <p v-if="message.user == null" style="font-weight: bold">{{ message.client }}</p>
            <p>
                {{ message.message }}
                <span>
                    {{ Utils.getTime(message.created_at) }}
                    <i class="bi" :class="sending ? 'bi-clock' : 'bi-check'"></i>
                </span>
            </p>
        </div>
    </div>
</template>

<style scoped>
    .message {
        width: 100%;
        display: flex;
        align-items: flex-end;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        position: relative;
    }
    .send {
        justify-content: flex-end;
        padding-left: 20%;
    }
    .receive {
        padding-right: 20%;
    }
    .message-avatar {
        margin-right: 0.5rem;
    }
    .message > div:last-child {
        border-radius: 0.5rem;
        max-width: 100%;
        position: relative;
    }
    .message > div:last-child > p {
        margin-bottom: 0;
        color: white;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    .message > div:last-child > p:first-child {
        padding-top: 0.5rem;
    }
    .message > div:last-child > p:last-child {
        padding-bottom: 0.5rem;
    }
    .annexed {
        max-width: 100%;
    }
    .message > div:last-child > p > span {
        color: #eeeeee;
        font-size: 0.8em;
        float: right;
        margin-top: 0.3em;
        margin-left: 0.3rem;
    }
    .send > div > .annexed + p {
        position: absolute;
        width: 100%;
        background: linear-gradient(to bottom, black, transparent);
        border-top-left-radius: 0.5rem;
        top: 0;
        padding-top: 0.25rem;
    }
    .message > div:last-child {
        background-color: #1f8fff;
    }
    .send > div.message-avatar > img {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
    }
    .send > div > img.annexed {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.3rem;
    }
    .message::before {
        content: " ";
        position: absolute;
        width: 1rem;
        height: 1rem;
        top: -0.15rem;
    }
    .select {
        margin-right: 0.5rem;
    }
    .send.selection > .select {
        position: absolute;
        left: 0;
    }
    .receive > div > img.annexed {
        border-top-right-radius: 0.5rem;
        border-top-left-radius: 0.3rem;
    }
    .send::before {
        right: -0.6rem;
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="rgb(31, 143, 255)" class="bi bi-caret-right-fill" viewBox="0 0 16 16"><path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/></svg>');
    }
    .receive::before {
        left: -0.6rem;
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="rgb(31, 143, 255)" class="bi bi-caret-left-fill" viewBox="0 0 16 16"><path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/></svg>');
    }
    .receive.selection::before {
        left: 1.4rem;
    }
    .send > div:last-child {
        border-top-right-radius: 0;
    }
    .receive > div:last-child {
        border-top-left-radius: 0;
    }
    @media (max-width: 560px) {
        .send {
            padding-left: 10%;
        }
        .receive {
            padding-right: 10%;
        }
    }
</style>
