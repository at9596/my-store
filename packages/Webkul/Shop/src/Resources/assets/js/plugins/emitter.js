import mitt from "mitt";

export default {
    install: (app, options) => {
        if (!window.emitter) {
            window.emitter = mitt();
        }

        app.config.globalProperties.$emitter = window.emitter;
    },
};
