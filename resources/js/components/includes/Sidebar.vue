<template>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <router-link class="nav-link"  to="/categories" exact-active-class="active11">
                    <i class="bi bi-menu-app"></i>
                    <span>Մենյուի բաժիններ</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link   :to="{name: 'subCategories.index'}" :class="{ 'collapsed': !$route.name === 'subCategories.index' }" class="nav-link">
                    <i class="bi bi-menu-app-fill"></i>
                    <span>Մենյուի ենթաբաժիններ</span>
                </router-link>
            </li>

            <li class="nav-item">

                <router-link
                class="nav-link"
                :class="{ active: $route.path === '/faq-categories' }"
                 to="/faq-categories"
                 >
                    <i class="bi bi-question-circle"></i>
                    <span>ՀՏՀ կատեգորիա</span>

                </router-link>

            </li>
            <li class="nav-item">
                <router-link class="nav-link"
                :class="{ active: $route.path === '/faq-category-subcategory' }"
                to="/faq-category-subcategory">
                    <i class="bi bi-question-circle"></i>
                    <span>ՀՏՀ  ենթակատեգորիա</span>

                </router-link>
            </li>
        </ul>
    </aside>
</template>
