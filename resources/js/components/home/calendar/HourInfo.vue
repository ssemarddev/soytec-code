<script>
export default {
    props: {
        hour: Object,
        hours: Array,
        index: Number,
    }
}
</script>
<template>
    <div class="main">
        <div>
            {{ hour.hour }}
        </div>
        <div>
            <template v-for="(event, j) in hour.events">
                <div class="event event-none" v-if="event == null">
                    <div></div>
                </div>
                <div @click="showDetails(event)" class="event"
                    :class="{ start: event.type == 'start', middle: event.type == 'middle', end: event.type == 'end', unique: hours[index + 1].events[j] == null }"
                    v-else>
                    <div v-if="event.type == 'middle'"></div>
                    <div v-else :style="{ 'background-color': event.event.color }"></div>
                </div>
            </template>
        </div>
    </div>
</template>
<style scoped>
.main {
    display: flex;
    border-bottom: 1px solid rgb(238, 238, 238);
}

.main>div:nth-child(1) {
    font-weight: 700;
    color: rgb(185, 185, 185);
    font-size: 0.85em;
    margin-top: 0.35rem;
    margin-bottom: 0.35rem;
    width: 4rem;
}

.main>div:last-child {
    display: flex;
    margin-left: 0.5rem;
    align-items: center;
}

.event {
    width: 1.6rem;
    height: 100%;
    display: flex;
    align-items: center;
    position: relative;
}

.event>div {
    height: 1.2rem;
    width: 100%;
    border-radius: 50%;
    margin-left: 0.2rem;
    margin-right: 0.2rem;
    cursor: pointer;
    z-index: 100;
}

.start:not(.unique)::before {
    content: " ";
    position: absolute;
    width: 1.25rem;
    height: 1rem;
    top: 50%;
    right: 0.18rem;
    background-color: #aed9f6;
}

.middle::before {
    content: " ";
    position: absolute;
    width: 1.25rem;
    height: 2.1rem;
    right: 0.18rem;
    background-color: #aed9f6;
}

.end::before {
    content: " ";
    position: absolute;
    width: 1.25rem;
    height: 1rem;
    bottom: 50%;
    right: 0.18rem;
    background-color: #aed9f6;
}
</style>
