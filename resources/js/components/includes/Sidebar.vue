<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRouter } from "vue-router";
import { useGoverningBodies } from "../../sidebar";
import api, { initApi } from "../../api";
import {me} from "../../me";
import { state } from '../../reactive-state';

const router = useRouter();

const { governingBodies } = useGoverningBodies(router);
const {userMe} = me(router)
const govBodyId = ref()
const authId = ref()


const chatMessageCount = ref()
const roomIds = ref([]);
const activeSubscriptions = {}; // Хранение подписок для обоих каналов
const hasOperator = ref(null)
const originalTitle = document.title;
let notificationInterval;

onMounted(async () => {
    await getAuthUserRoles(); // Дождёмся обновления hasOperator

    if (hasOperator.value) {
        getUnAmsweredEmailMessages();
    }
})



const getAuthUserRoles = async () => {
    try {

        let response = await api.value.get('/api/auth/get-auth-user-roles');
        let result = response.data.result;

            authId.value = result.user_id;
            hasOperator.value = result.roles.includes('operatorMIP') || result.roles.includes('operatorPN');

    } catch (error) {
        console.error("Ошибка при получении данных:", error);
    }
};


const getUnAmsweredEmailMessages = async () => {
    try {

        let response = await api.value.get('/api/auth/get-messages-counts');
        let result = response.data.result;

        state.emailMessageCount = result.email_messages_count;
        chatMessageCount.value = result.chat_messages_count;
        govBodyId.value = result.governing_body_id;

        if (result.room_ids) {
            roomIds.value = result.room_ids;
        }

    } catch (error) {
        console.error("Ошибка при получении данных:", error);
    }
};


// Подписка на канал сообщений email
const subscribeToEmailMessagesChannel = (govBodyId) => {
    const channelName = `messages-count.${govBodyId}`;
    if (!activeSubscriptions[channelName]) {
        activeSubscriptions[channelName] = window.Echo.private(channelName).listen('MessagesEvent', (e) => {
            state.emailMessageCount = e.count;

            if (document.visibilityState !== 'visible') {
                playNotificationSound();
                blinkTitle(`Նոր հաղորդագրություն`);
            }

        });
    }
};


document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'visible') {
        stopBlinkTitle();
    }
});


// Функция для мигания заголовка страницы
const blinkTitle = (message) => {
    clearInterval(notificationInterval);
    let toggle = false;
    notificationInterval = setInterval(() => {
        document.title = toggle ? message : '*** Նոր հաղորդագրություն ***';
        toggle = !toggle;
    }, 1000);
};


// Функция для остановки мигания
const stopBlinkTitle = () => {
    clearInterval(notificationInterval);
    document.title = originalTitle;
};


const subscribeToChatMessagesChannel = (authId) => {
    const channelName = `chat-messages-count.${authId}`;
    if (!activeSubscriptions[channelName]) {
        activeSubscriptions[channelName] = window.Echo.private(channelName).listen('ChatMessagesEvent', (e) => {
            chatMessageCount.value = e.count; // Обновляем chatMessageCount
            if (document.visibilityState !== 'visible') {
                playNotificationSound();
                blinkTitle(`Նոր հաղորդագրություն`);
            }
        });
    }
};

// Функция для проигрывания звука
const playNotificationSound = () => {
    const audio = new Audio('/public/assets/sound/siren-alert.mp3'); // Замените на свой URL
    audio.play();
};

// Отписка от канала
const unsubscribeFromChannel = (channelName) => {
    if (activeSubscriptions[channelName]) {
        window.Echo.leave(channelName);
        delete activeSubscriptions[channelName];
    }
};


watch(
    () => authId.value, // Указываем зависимость
    (newAuthId) => {    // Действия при изменении
        subscribeToChatMessagesChannel(newAuthId);
    }
);


// Следим за изменениями govBodyId
watch(govBodyId, (newGovBodyId, oldGovBodyId) => {

    if (oldGovBodyId) {
        unsubscribeFromChannel(`messages-count.${oldGovBodyId}`); // Отписываемся от старого канала
    }
    if (newGovBodyId) {
        subscribeToEmailMessagesChannel(newGovBodyId); // Подписываемся на новый канал
    }
});



const realChat = () =>{
    const accessToken = localStorage.getItem('access_token'); // Replace with actual token

    sessionStorage.setItem('chat_url', 'chat_url');

    const url = `https://citizenw.trigger.ltd/auth?token=${accessToken}`;
    // Open the URL in a new tab
    window.location.href = url
}


</script>

<template>

    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav" >

            <li class="nav-item">
                <router-link
                    v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN' ||  role.name === 'contentManagerMIP' || role.name === 'contentManagerPN' )"

                  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('categories.'))}" :to="{name: 'categories.index'}">
                    <i class="bi bi-menu-app"></i>
                    <span>Մենյուի բաժին</span>
                </router-link>
            </li>
            <li class="nav-item" >
                <router-link
                     v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN' ||  role.name === 'contentManagerMIP' || role.name === 'contentManagerPN' )"

                    :to="{name: 'subCategories.index'}"  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('subCategories.'))}">
                    <i class="bi bi-menu-app-fill"></i>
                    <span>Մենյուի ենթաբաժին</span>
                </router-link>
            </li>

            <li class="nav-item">

                <router-link
                     v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN' ||  role.name === 'contentManagerMIP' || role.name === 'contentManagerPN'  )"
                    class="nav-link"
                    :class="{'collapsed': !($route.name && $route.name.startsWith('faqcategory.'))}"
                    :to="{name: 'faqcategory.index'}"
                 >
                    <i class="bi bi-question-circle"></i>
                    <span>ՀՏՀ կատեգորիա</span>

                </router-link>

            </li>
            <li class="nav-item" >
                <router-link
                      v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN' ||  role.name === 'contentManagerMIP' || role.name === 'contentManagerPN' )"
                    class="nav-link"
                    :class="{'collapsed': !($route.name && $route.name.startsWith('faqCategorySubcategory.'))}"
                    :to="{name: 'faqCategorySubcategory.index'}">
                    <i class="bi bi-question-circle"></i>
                    <span>ՀՏՀ  ենթակատեգորիա</span>

                </router-link>
            </li>

            <li class="nav-item">
                <router-link
                  v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN' ||  role.name === 'contentManagerMIP' || role.name === 'contentManagerPN'  )"
                 :to="{name: 'governing-bodies.index'}" class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" aria-expanded="false" :class="{'collapsed': !($route.name && $route.name.startsWith('governing-bodies.'))}">
                <i class="bi bi-bank"></i><span>Պետական մարմիններ</span><i class="bi bi-chevron-down ms-auto"></i>
                </router-link>

                <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li v-for="governingBody in governingBodies" >
                        <router-link
                                v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === `admin${governingBody.named}` || role.name === `contentManager${governingBody.named}` )"
                                :class="{'active': $route.name === 'governing-bodies.edit' && $route.params.id && $route.params.id == governingBody.id}"
                                :to="{name: 'governing-bodies.edit', params: { id: governingBody.id }}">
                            <i class="bi bi-circle"></i><span>{{governingBody.name}}</span>
                        </router-link>
                    </li>
                </ul>
            </li>


            <li class="nav-item">
                <router-link
                 v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN' ||  role.name === 'contentManagerMIP' || role.name === 'contentManagerPN' )"
                  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('notifications.'))}" :to="{name: 'notifications.index'}">
                    <i class="bi bi-bell"></i>
                    <span>Ծանուցումներ</span>
                </router-link>
            </li>

            <li  class="nav-item">
                <router-link
                  v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' ||  role.name === 'adminPN'  )"
                  class="nav-link" :class="{'collapsed': !($route.name && $route.name.startsWith('users.index'))}" :to="{name: 'users.index'}">
                    <i class="bi bi-person"></i>
                    <span>Օգտատերեր </span>

                </router-link>
            </li>


            <li  class="nav-item">
                <router-link
                  v-if="userMe.roles?.some(role => role.name === 'operatorMIP' ||  role.name === 'operatorPN')"
                  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('email-messages.'))}" :to="{name: 'email-messages.index'}">
                    <i class="ri-mail-line"></i>
                    <span>Նամակագրություն</span>
                    <span class="badge badge-number mx-4" :class="state.emailMessageCount < 3  ?  'bg-primary' : (state.emailMessageCount > 2 && state.emailMessageCount < 5 ? 'bg-warning' : 'bg-danger')">{{ state.emailMessageCount }}</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link
                     v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN' ||  role.name === 'contentManagerMIP' || role.name === 'contentManagerPN' )"

                    class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('messages-categories.'))}" :to="{name: 'messages-categories.index'}">
                    <i class="ri-mail-line"></i>
                    <span>Նամակագրության կատեգորիա</span>
                </router-link>
            </li>
            <li class="cursor-pointer" >

                <div
                  v-if="userMe.roles?.some(role => role.name === 'operatorMIP' ||  role.name === 'operatorPN' )"
                  class="nav-link collapsed  realChat" @click.prevent="realChat"
                  target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-chat-left-dots"></i>
                    <span >Կենդանի զրույց </span>
                    <span class="badge  badge-number mx-4" :class="chatMessageCount < 3  ?  'bg-primary' : (chatMessageCount > 2 && chatMessageCount < 5 ? 'bg-warning' : 'bg-danger')">{{ chatMessageCount }}</span>
                </div>
            </li>

            <li class="nav-item">
                <router-link
                 v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN')"
                class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('reports.'))}" :to="{name: 'reports.index'}">
                    <i class="bi bi-bar-chart"></i>
                    <span>Հաշվետվություն</span>
                </router-link>
            </li>

            <li class="nav-item">
                <router-link
                  v-if="userMe.roles?.some(role => role.name === 'super_admin' ||  role.name === 'adminMIP' || role.name === 'adminPN' )"
                 class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('log'))}" :to="{name: 'log'}">
                    <i class="bx bx-data"></i>
                    <span>Լոգավորում</span>
                </router-link>
            </li>

        </ul>
        <!-- {{ userMe.roles }} -->
    </aside>
</template>
<style>
    .realChat{
        cursor:pointer

        }
</style>

