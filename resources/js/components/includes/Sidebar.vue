<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from "vue-router";
import { useGoverningBodies } from "../../sidebar";
import api, { initApi } from "../../api";
import {me} from "../../me";

const router = useRouter();

const { governingBodies } = useGoverningBodies(router);
const {userMe} = me(router)
const emailMessageCount = ref()
const chatMessageCount = ref()

onMounted(async () => {
    getUnAmsweredEmailMessages()
})

const getUnAmsweredEmailMessages = async () => {

    let response = api.value.get ( '/api/auth/get-messages-counts')
    .then((response) => {

        let result = response.data.result

        emailMessageCount.value = result.email_messages_count
        chatMessageCount.value = result.chat_messages_count

    })
}

window.Echo.channel('messages-count').listen('MessagesEvent', (e) => {
    // console.log(e)
     e.type == 'email_message' ? emailMessageCount.value = e.count : chatMessageCount.value = e.count
});



const realChat = () =>{
    const accessToken = localStorage.getItem('access_token'); // Replace with actual token

    const url = `https://citizenw.trigger.ltd/auth?token=${accessToken}`;
    // Open the URL in a new tab
    window.location.href = url
}


</script>

<template>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('categories.'))}" :to="{name: 'categories.index'}">
                    <i class="bi bi-menu-app"></i>
                    <span>Մենյուի բաժիններ</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link   :to="{name: 'subCategories.index'}"  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('subCategories.'))}">
                    <i class="bi bi-menu-app-fill"></i>
                    <span>Մենյուի ենթաբաժիններ</span>
                </router-link>
            </li>

            <li class="nav-item">

                <router-link
                    class="nav-link"
                    :class="{'collapsed': !($route.name && $route.name.startsWith('faqcategory.'))}"
                    :to="{name: 'faqcategory.index'}"
                 >
                    <i class="bi bi-question-circle"></i>
                    <span>ՀՏՀ կատեգորիա</span>

                </router-link>

            </li>
            <li class="nav-item">
                <router-link class="nav-link"
                    :class="{'collapsed': !($route.name && $route.name.startsWith('faqCategorySubcategory.'))}"
                    :to="{name: 'faqCategorySubcategory.index'}">
                    <i class="bi bi-question-circle"></i>
                    <span>ՀՏՀ  ենթակատեգորիա</span>

                </router-link>
            </li>

            <li class="nav-item">
                <router-link :to="{name: 'governing-bodies.index'}" class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" aria-expanded="false" :class="{'collapsed': !($route.name && $route.name.startsWith('governing-bodies.'))}">
                <i class="bi bi-bank"></i><span>Պետական կառավարման մարմիններ</span><i class="bi bi-chevron-down ms-auto"></i>
                </router-link>

                <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li v-for="governingBody in governingBodies">
                        <router-link
                                :class="{'active': $route.name === 'governing-bodies.edit' && $route.params.id && $route.params.id == governingBody.id}"
                                :to="{name: 'governing-bodies.edit', params: { id: governingBody.id }}">
                            <i class="bi bi-circle"></i><span>{{governingBody.name}}</span>
                        </router-link>
                    </li>
                </ul>
            </li>


            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('notifications.'))}" :to="{name: 'notifications.index'}">
                    <i class="bi bi-bell"></i>
                    <span>Ծանուցումներ</span>
                </router-link>
            </li>

            <li v-for = "role in userMe.roles" :key="role.id" class="nav-item">
                <router-link v-if="role.name=='super_admin' || role.name=='admin'"  class="nav-link" :class="{'collapsed': !($route.name && $route.name.startsWith('users.index'))}" :to="{name: 'users.index'}">
                    <i class="bi bi-person"></i>
                    <span>Օգտատերեր </span>

                </router-link>
            </li>

            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('email-messages.'))}" :to="{name: 'email-messages.index'}">
                    <i class="ri-mail-line"></i>
                    <span>Նամակագրություն</span>
                    <span class="badge badge-number mx-4" :class="emailMessageCount < 3  ?  'bg-primary' : (emailMessageCount > 2 && emailMessageCount < 5 ? 'bg-warning' : 'bg-danger')">{{ emailMessageCount }}</span>
                </router-link>
            </li>
            <li class="nav-item">

                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('messages-categories.'))}" :to="{name: 'messages-categories.index'}">
                    <i class="ri-mail-line"></i>
                    <span>Նամակագրության կատեգորիաներ</span>
                </router-link>
            </li>
            <li>
                <div class="nav-link collapsed" @click.prevent="realChat"
                  target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-chat-left-dots"></i>
                    <span>Կենդանի զրույց</span>
                    <span class="badge  badge-number mx-4" :class="chatMessageCount < 3  ?  'bg-primary' : (chatMessageCount > 2 && chatMessageCount < 5 ? 'bg-warning' : 'bg-danger')">{{ chatMessageCount }}</span>
                </div>
            </li>

            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('reports.'))}" :to="{name: 'reports.index'}">
                    <i class="bi bi-bar-chart"></i>
                    <span>Հաշվետվություն</span>
                </router-link>
            </li>

            <li class="nav-item">
                <router-link  class="nav-link " :class="{'collapsed': !($route.name && $route.name.startsWith('log'))}" :to="{name: 'log'}">
                    <i class="bx bx-data"></i>
                    <span>Լոգավորում</span>
                </router-link>
            </li>

        </ul>
        <!-- {{ userMe.roles }} -->
    </aside>
</template>

