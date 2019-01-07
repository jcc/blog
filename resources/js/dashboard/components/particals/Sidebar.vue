<template>
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <div class="user">
        <div class="avatar">
          <img class="img-fluid rounded-circle" :src="user.avatar">
        </div>
        <div class="nickname">
          <p>{{ user.name }}</p>
          <p>{{ user.email }}</p>
        </div>
        <div class="buttons">
          <a href="/"><i class="fas fa-home"></i></a>
          <a :href="userInfo"><i class="fas fa-user"></i></a>
          <a href="/setting"><i class="fas fa-cog"></i></a>
        </div>
      </div>
      <li v-for="menu in menus" :class="{ 'mb-3': menu.children }" v-if="menu.can">
        <div class="sidebar-group" v-if="menu.children">
          <p class="sidebar-heading text-white-50"><span>{{ $t(menu.label) }}</span></p>
          <ul class="sidebar-group-items">
            <li v-for="item in menu.children" v-if="item.can">
              <router-link :to="item.uri">
                <i :class="item.icon"></i> {{ $t(item.label) }}
              </router-link>
            </li>
          </ul>
        </div>
        <router-link :to="menu.uri" class="mb-1" v-else>
          <i :class="menu.icon"></i> {{ $t(menu.label) }}
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
  import menus from 'dashboard/config/menu'

  export default {
    data () {
      return {
        user: {}
      }
    },
    mounted() {
      this.user = window.User
    },
    computed: {
      menus () {
        menus.forEach((item) => {
          if (item.children) {
            let i = 0

            item.children.forEach((child) => {
              child.can = child.permission ? this.checkPermission(child.permission) : true

              i = child.can ? i + 1 : i
            })

            item.can = i > 0
          } else {
            item.can = item.permission ? this.checkPermission(item.permission) : true
          }
        })

        return menus
      },

      userInfo() {
        return '/user/' + this.user.name
      }
    }
  }
</script>

<style lang="scss" scoped>
.sidebar-nav {
  position: absolute;
  top: 0;
  width: 250px;
  margin: 0;
  padding: 0;
  list-style: none;

  i {
    font-size: .9rem;
  }
}

.sidebar-nav li {
  text-indent: 16px;
  line-height: 40px;

  i {
    font-size: .6rem;
  }
}

.navbar {
  margin-bottom: 0;
}

.sidebar-nav li .user {
  display: block;
  text-align: center;
  width: 100%;
  background-color: #3d4e60;
  padding-top: 20px;
  padding-bottom: 10px;
  color: #fff;
}

.user {
  text-align: center;
  padding-top: 15px;
}

.user .avatar {
  width: 80px;
  margin: 10px auto;
}

.nickname {
  color: #fff;
}

.buttons {
  height: 50px;
}
.buttons a {
  display: inline-block;
  font-size: 20px;
  width: 40px;
  height: 40px;
  line-height: 40px;
  margin-right: 5px;
  color: #fff;
  opacity: .5;
}
.buttons a:hover {
  opacity: 1;
}
.sidebar-nav li a {
  display: block;
  text-decoration: none;
  color: #fff;
  opacity: .5;
}

.sidebar-nav li a:hover {
  opacity: 1;
  text-decoration: none;
  background: #647f9d;
}

.sidebar-nav li .active {
  opacity: 1;
}

.sidebar-nav li a i {
  padding-right: 10px;
}

.sidebar-nav li a:active,
.sidebar-nav li a:focus {
  text-decoration: none;
}

.sidebar-group {
  .sidebar-heading {
    padding-left: 16px;
    text-transform: uppercase;
    letter-spacing: .13rem;
    font-size: 12px;
    font-weight: 800;
    margin: 0;
  }
  .sidebar-group-items {
    padding: 0;
  }
}

.active {
  background-color: #3d4e60;
  border-right: 4px solid #647f9d;
}
.active a {
  color: #fff !important;
}
</style>
