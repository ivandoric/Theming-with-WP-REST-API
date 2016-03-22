<?php get_header(); ?>

    <div class="white-wrap">
        <div id="app">

            <router-view></router-view>

        </div>
    </div>


<template id="post-list-template">
    <div class="container">
        <div class="post-list">
            <article v-for="post in posts" class="post">
                <div class="post-content">
                    <h2>{{ post.title.rendered }}</h2>
                </div>
            </article>
        </div>
    </div>

</template>

<?php get_footer(); ?>