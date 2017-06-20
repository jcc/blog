<template>
    <div id="wrapper" :class="{ toggled: isToggle }">
        <sidebar></sidebar>
        <div id="page-content-wrapper">
            <navbar></navbar>
            <div class="container-fluid">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
import Sidebar from 'components/dashboard/particals/Sidebar.vue';
import Navbar from 'components/dashboard/particals/Navbar.vue';
import FooterBar from 'components/dashboard/particals/FooterBar.vue';

export default {
    components: {
        Sidebar,
        Navbar,
        FooterBar
    },
    computed: {
        isToggle () {
            return this.$store.state.sidebar.opened
        }
    }
}
</script>

<style lang="scss">
$sidebarSize: 250px;
$sidebarColor: #828e9a;
$sidebarBar: darken($sidebarColor, 3%); /* divider */
$sidebarRoll: darken($sidebarColor, 8%);

body {
    overflow-x: hidden;
}

/* Toggle Styles */

#wrapper {
    padding-left: 0;
    transition: all 0.5s ease;
    #wrapper.toggled {
        padding-left: 250px;
    }
}

#sidebar-wrapper {
    z-index: 1000;
    position: fixed;
    left: 250px;
    width: 0;
    height: 100%;
    margin-left: -250px;
    overflow-y: auto;
    background: #4d5e70;
    transition: all 0.5s ease;
}

#wrapper.toggled #sidebar-wrapper {
    width: 250px;
}

#page-content-wrapper {
    width: 100%;
    position: absolute;

    .container-fluid {
        .row {
            margin: 15px;
        }
    }
}

#wrapper.toggled #page-content-wrapper {
    position: absolute;
    margin-right: -250px;
}

@media(max-width: 768px) {
    #page-content-wrapper {
        padding-left: 0;
        transition: all 0.5s ease;
    }
    #wrapper.toggled #page-content-wrapper {
        transition: all 0.5s ease;
        padding-left: 250px;
        margin-right: -250px;
    }
}

@media(min-width:768px) {
    #wrapper {
        padding-left: 250px;
    }

    #wrapper.toggled {
        padding-left: 0;
    }

    #sidebar-wrapper {
        width: 250px;
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 0;
    }

    #page-content-wrapper {
        position: relative;
    }

    #wrapper.toggled #page-content-wrapper {
        position: relative;
        margin-right: 0;
    }
}

.hr {
    margin-left: 1px;
    margin-right: 1px;
    border: 1px solid $sidebarBar;
}

.profile {
    margin: 15px auto;
    text-align: center;
    img {
        height: 125px;
        border: 3px solid lightgrey;
        border-radius: 200px;
    }
    h1 {
        margin-top: 10px;
        color: white;
        font-size: 1.3em;
    }
}
</style>
