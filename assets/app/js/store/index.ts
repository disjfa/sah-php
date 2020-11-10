import {createStore} from 'vuex';

export default createStore({
    state: {
        categories: [],
        videos: {},
        currentVideo: {},
        randomVideo: {},
    },
    mutations: {
        setupCategories(state, categories) {
            state.categories = categories;
        },
        setupVideos(state, result) {
            const {data, meta} = result;
            state.videos = data;
        },
        setupCurrentVideo(state, video) {
            state.currentVideo = video;
        }
    },
    actions: {
        loadVideo({commit, state}, video) {
            fetch('/api/video/video/'+video)
                .then(response => response.json())
                .then(({data}) => commit('setupCurrentVideo', data));
        },
        loadVideos({commit}) {
            fetch('/api/video')
                .then(response => response.json())
                .then(result => commit('setupVideos', result));
        },
        loadCategories({commit, state}) {
            if (state.categories.count) {
                return;
            }

            fetch('/api/category')
                .then(response => response.json())
                .then(({data}) => commit('setupCategories', data));
        },
    },
    modules: {},
});
