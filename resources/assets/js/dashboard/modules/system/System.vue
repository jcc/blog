<template>
  <div class="row">
    <div class="ibox">
      <div class="ibox-title">
        <h5>{{ $t('page.systems') }}</h5>
      </div>
      <div class="ibox-content">
        <div class="row">
          <div class="col-md-2">
            <div class="sidebar">
              <ul>
                <li aria-expanded="false" :class="[type == 'system' ? 'active' : '']" @click="type = 'system'">
                  <a> <i class="fas fa-puzzle-piece"></i>{{ $t('page.system') }}</a>
                </li>
                <li aria-expanded="true" :class="[type == 'php' ? 'active' : '']" @click="type = 'php'">
                  <a><i class="fas fa-code"></i> PHP</a>
                </li>
                <li aria-expanded="false" :class="[type == 'database' ? 'active' : '']" @click="type = 'database'">
                  <a><i class="fas fa-database"></i> {{ $t('page.database') }}</a>
                </li>
              </ul>
            </div>
          </div>
          <ul id="tab-content" class="col-md-10">
            <li aria-hidden="true" v-if="type == 'system'">
              <h2>{{ $t('page.system') }}</h2>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th width="150">{{ $t('page.key') }}</th>
                    <th>{{ $t('page.value') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $t('page.server') }}</td>
                    <td>{{ system.server }}</td>
                  </tr>
                  <tr>
                    <td>{{ $t('page.domain') }}</td>
                    <td>{{ system.http_host }}</td>
                  </tr>
                  <tr>
                    <td>IP</td>
                    <td>{{ system.remote_host }}</td>
                  </tr>
                  <tr>
                    <td>User Agent</td>
                    <td>{{ system.user_agent }}</td>
                  </tr>
                </tbody>
              </table>
            </li>
            <li aria-hidden="false" v-if="type == 'php'">
              <h2>PHP</h2>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th width="150">{{ $t('page.key') }}</th>
                    <th>{{ $t('page.value') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $t('page.version') }}</td>
                    <td>{{ system.php }}</td>
                  </tr>
                  <tr>
                    <td>Handler</td>
                    <td>{{ system.sapi_name }}</td>
                  </tr>
                  <tr>
                    <td>{{ $t('page.extension') }}</td>
                    <td>{{ system.extensions }}</td>
                  </tr>
                </tbody>
              </table>
            </li>
            <li aria-hidden="true" v-if="type == 'database'">
              <h2>{{ $t('page.database') }}</h2>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th width="150">{{ $t('page.key') }}</th>
                    <th>{{ $t('page.value') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $t('page.driver') }}</td>
                    <td>{{ system.db_connection }}</td>
                  </tr>
                  <tr>
                    <td>{{ $t('page.database') }}</td>
                    <td>{{ system.db_database }}</td>
                  </tr>
                  <tr>
                    <td>{{ $t('page.version') }}</td>
                    <td>{{ system.db_version }}</td>
                  </tr>
                </tbody>
              </table>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      system: {},
      type: 'system'
    }
  },
  created() {
    this.$http.get('system')
      .then((response) => {
        this.system = response.data
      })
  }
}
</script>

<style lang="scss" scoped>
h2 {
  font-size: 20px;
  line-height: 30px;
  margin-top: 0;
}

ul {
  padding-left: 0;
}

ul li {
  list-style: none;
}

.content {
  margin-top: 30px;
}

.table thead th {
  vertical-align: bottom;
}

.table th {
  border-bottom: 1px solid #e5e5e5;
  font-size: 12px;
  text-transform: uppercase;
  font-weight: normal;
  color: #aaa;
}

.table :not(:last-child)>td {
  border-bottom: 1px solid #e5e5e5;
}

.table td {
  vertical-align: top;
}

.table th,
.table td {
  padding: 16px 12px;
}

.table-hover tbody tr:hover {
  background: #fff
}

.sidebar ul li a {
  font-size: 12px;
  display: block;
  text-decoration: none;
  padding: 8px 14px;
  cursor: pointer;
  color: #666;
}

.sidebar ul li a:hover,
.active {
  background: #eee;
  color: #666;
}

.sidebar ul li a i {
  font-size: 14px;
  margin-right: 10px;
}
</style>
