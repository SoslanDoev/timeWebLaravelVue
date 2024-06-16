<template>
    <div class="wrapper">

        <!-- <AppHeader v-if="route.meta.headerFooterVisible !== false"/>
        <main class="main" id="main">
            <router-view></router-view>
        </main>
        <AppFooter v-if="route.meta.headerFooterVisible !== false"/> -->


        <TransitionGroup name="list">
            <template v-if="userLoaded === true">
                <AppHeader v-if="route.meta.headerFooterVisible !== false"/>
                <main class="main" id="main">
                    <router-view></router-view>
                </main>

                <!-- <AppFooter v-if="route.meta.headerFooterVisible !== false"/> -->
                <div style="background-color: #343434; padding: 5px 0; color: white;">
                    <div class="container">
                        <h4>User: {{ user }}</h4>
                    </div>
                </div>

            </template>
            <template v-else>
                <AppOnLoad />
            </template>
        </TransitionGroup>
    </div>
</template>
  
<script setup>
    import { ref, computed } from "vue"
    import { useStore, mapState, mapGetters, mapMutations } from 'vuex';
    import AppHeader from "./components/AppHeader.vue" // Header
    import AppFooter from "./components/AppFooter.vue" // Footer
    import { useRoute } from 'vue-router'
    import AppOnLoad from "./components/AppOnLoad.vue" // AppOnLoad
    const route = useRoute()
    const store = useStore();
    const user = computed(() => store.state.user)
    const userLoaded = computed(() => store.state.userLoaded)
</script>
  
<style>
    *, *::after, *::before {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        outline: none;
    }
    :root {
        --clr-primary: #fff;
        --clr-secondary: #343434;
        --clr-tertiary: #666666;

        --container-width: 1130px;

        --border-radius-default: 4px;
        
        --opacity-default: 0.8;

        --transition-default: all 200ms linear;
    }
    html, body {
        height: 100%;
    }
    html {
        font-size: 16px;
    }
    body {
        font-size: 1rem;
        color: var(--clr-secondary);
        background-color: var(--clr-primary);
        overflow-x: hidden;
    }
    .container {
        max-width: var(--container-width);
        margin: 0 auto;
        padding: 0 15px;
        height: 100%;
    }
    .wrapper, #app {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    ul, li, ol {
        list-style: none;
    }
    a {
        text-decoration: none;
        color: inherit;
    }
    main {
        flex: 1 1 auto;
    }
    .title {
        font-size: 1.5rem;
        margin: 0 0 10px;
    }
    .hover {
        opacity: 1;
        transition: var(--transition-default);
    }
    .hover:hover {
        opacity: var(--opacity-default);
        transition: var(--transition-default);
    }

    .list-move, /* apply transition to moving elements */
    .list-enter-active,
    .list-leave-active {
        transition: all 0.5s linear;
    }
    .list-enter-from,
    .list-leave-to {
        opacity: 0;
        transform: translateY(-50%);
    }
    .input {
        font-weight: 800;
    }
    .input, .button {
        width: 100%;
        padding: 10px 5px;
        background-color: rgba(255, 255, 255, 0.5);
        color: var(--clr-secondary);
        border: 2px solid var(--clr-secondary); 
        border-radius: var(--border-radius-default);
    }
    .input::placeholder {
        color: var(--clr-secondary);
    }
    input[type=radio] {
        /* display: none; */
    }
    input[type=radio]:checked + label::before {
        background-color: var(--clr-secondary);
    }
    .label-radio {
        display: inline-block;
        cursor: pointer;
        position: relative;
        padding-left: 20px;
        margin-right: 0;
        user-select: none;
    }
    .label-radio::before {
        content: "";
        display: inline-block;
        width: 15px;
        height: 60%;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 0;
        bottom: 1px;
        background-color: var(--clr-primary);
        border: 2px solid var(--clr-secondary);
        border-radius: 2px;
    }
    .button {
        cursor: pointer;
        background-color: var(--clr-secondary);
        color: var(--clr-primary);
        font-weight: 900;
    }

    .arrow-6 svg {
        width: 20px;
        height: auto;
        margin: 0 2rem;
        cursor: pointer;
        overflow: visible;
    }
    .arrow-6 svg polygon, 
    .arrow-6 svg path {
        transition: all 0.5s cubic-bezier(0.2, 1, 0.3, 1);
        fill: var(--clr-secondary);
    }
    .arrow-6 svg:hover polygon, 
    .arrow-6 svg:hover path {
        transition: all 1s cubic-bezier(0.2, 1, 0.3, 1);
        fill: #000;
    }
    .arrow-6 svg:hover .arrow-6-pl {
        animation: arrow-6-anim 1s cubic-bezier(0.2, 1, 0.3, 1) infinite;
    }
    .arrow-6 svg:hover .arrow-6-pl-fixed {
        animation: arrow-6-fixed-anim 1s cubic-bezier(0.2, 1, 0.3, 1) infinite;
    }
    
    @keyframes arrow-6-anim {
        0% {
            opacity: 1;
            transform: translateX(0);
        }
        5% {
            transform: translateX(-0.1rem);
        }
        100% {
            transform: translateX(1rem);
            opacity: 0;
        }
    }
    @keyframes arrow-6-fixed-anim {
        5% {
            opacity: 0;
        }
        20% {
            opacity: 0.4;
        }
        100% {
            opacity: 1;
        }
    }
</style>