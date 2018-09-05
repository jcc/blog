<template>
  <nav class="navbar navbar bg-white shadow">
    <div class="navbar-brand">
      <a class="navbar-toggler text-left" @click="toggle">
        <i class="fas fa-bars text-secondary"></i>
      </a>
    </div>
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
