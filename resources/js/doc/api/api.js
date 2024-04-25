//import "./bootstrap"
import { createApp } from "vue";
import mitt from "mitt";
import Utils from "../../Utils";
import Root from "./components/Api.vue";
// stackoverflow-light
import "highlight.js/styles/stackoverflow-light.css";
import hljs from "highlight.js/lib/core";
import javascript from "highlight.js/lib/languages/javascript";
import json from "highlight.js/lib/languages/json";
import hljsVuePlugin from "@highlightjs/vue-plugin";

hljs.registerLanguage("javascript", javascript);
hljs.registerLanguage("json", json);

import Categories from "./components/Categories.vue";

const app = createApp(Root);
app.use(hljsVuePlugin);
app.component("categories", Categories);

app.config.globalProperties.Utils = Utils;

/** Implementar bus de eventos */
const emitter = mitt();
app.config.globalProperties.emitter = emitter;

app.mount("#app");
