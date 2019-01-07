import Vue from 'vue'

export default [{
  label: 'sidebar.dashboard',
  icon: 'fas fa-tachometer-alt',
  uri: { name: 'dashboard.home' }
}, {
  label: 'sidebar.modules.content',
  children: [{
    label: 'sidebar.article',
    permission: 'LIST_ARTICLE',
    icon: 'fas fa-book',
    uri: { name: 'dashboard.article' }
  }, {
    label: 'sidebar.discussion',
    permission: 'LIST_DISCUSSION',
    icon: 'fas fa-question-circle',
    uri: { name: 'dashboard.discussion' }
  }, {
    label: 'sidebar.comment',
    permission: 'LIST_COMMENT',
    icon: 'fas fa-comments',
    uri: { name: 'dashboard.comment' }
  }, {
    label: 'sidebar.tag',
    permission: 'LIST_TAG',
    icon: 'fas fa-tags',
    uri: { name: 'dashboard.tag' }
  }, {
    label: 'sidebar.category',
    permission: 'LIST_CATEGORY',
    icon: 'fas fa-list-alt',
    uri: { name: 'dashboard.category' }
  }, {
    label: 'sidebar.link',
    permission: 'LIST_LINK',
    icon: 'fas fa-globe',
    uri: { name: 'dashboard.link' }
  }]
}, {
  label: 'sidebar.modules.base',
  children: [{
    label: 'sidebar.user',
    permission: 'LIST_USER',
    icon: 'fas fa-users',
    uri: { name: 'dashboard.user' }
  }, {
    label: 'sidebar.file',
    permission: 'LIST_FILE',
    icon: 'fas fa-folder',
    uri: { name: 'dashboard.file' }
  }],
}, {
  label: 'sidebar.modules.system',
  children: [{
    label: 'sidebar.visitor',
    permission: 'LIST_VISITOR',
    icon: 'fas fa-eye',
    uri: { name: 'dashboard.visitor' }
  }, {
    label: 'sidebar.role',
    permission: 'LIST_ROLE',
    icon: 'fas fa-exclamation-triangle',
    uri: { name: 'dashboard.role' }
  }, {
    label: 'sidebar.system',
    permission: 'LIST_SYSTEM_INFO',
    icon: 'fas fa-cogs',
    uri: { name: 'dashboard.system' }
  }]
}]
