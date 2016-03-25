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
                <img v-bind:src="post.fi_300x180">
                <div class="post-content">
                    <h2>{{ post.title.rendered }}</h2>
                    <small v-for="category in post.cats">
                        {{ category.name }}
                    </small>
                </div>
            </article>
        </div>
    </div>

</template>

<?php get_footer(); ?>