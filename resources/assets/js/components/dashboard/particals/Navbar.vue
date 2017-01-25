<template>
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-toggle collapsed pull-left" @click="toggle">
                    <i class="ion-navicon-round"></i>
                </a>
            </div>

            <div id="repbar" class="navbar-collapse collapse">

                <ul class="nav navbar-nav">
                    <li style="font-size: 20px;" @click="toggle">
                        <a id="left-hamburger" href="#">
                            <i class="ion-navicon-round"></i>
                        </a>
                    </li>
                </ul>

            </div>
            <!--/.nav-collapse -->
        </div>
    <!--/.container-fluid -->
    </nav>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        methods: mapActions([
            'toggle'
        ])
    }
</script>

<style lang="scss" scoped>
#repbar {
  margin-left: -15px;
}

.navbar-nav {
  li {
    a {
      padding-top: 0px;
      padding-bottom: 0px;
      line-height: 60px;
    }
  }
}

.navbar-toggle {
    margin: 0;
    font-size: 20px;
    text-decoration: none;
    padding: 13px 10px;
    border: 0;
    color: #777;
    cursor: pointer;
}
.navbar-inverse .navbar-toggle:hover {
    border: 0;
    border-radius: 0;
    background-color: #fff !important;
    text-decoration: none;
    color: #888;
}
</style>
