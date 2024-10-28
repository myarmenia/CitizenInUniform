<template>
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <router-link class="nav-link"  to="/categories">
                    <i class="bi bi-menu-app"></i>
                    <span>Մենյուի բաժիններ</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link"  :to="{name: 'subCategories.index'}">
                    <i class="bi bi-menu-app-fill"></i>
                    <span>Մենյուի ենթաբաժիններ</span>
                </router-link>
            </li>

        <li class="nav-item">
            <router-link class="nav-link"  to="/faq-categories">
                <i class="bi bi-grid"></i>
                <span>ՀՏՀ կատեգորիա</span>

            </router-link>
        </li>
        </ul>
    </aside>
</template>
