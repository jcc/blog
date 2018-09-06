export default [{
  label: 'sidebar.dashboard',
  icon: 'fas fa-tachometer-alt',
  uri: { name: 'dashboard.home' }
}, {
  label: 'sidebar.modules.content',
  children: [{
    label: 'sidebar.article',
    icon: 'fas fa-book',
    uri: { name: 'dashboard.article' }
  }, {
    label: 'sidebar.discussion',
    icon: 'fas fa-question-circle',
    uri: { name: 'dashboard.discussion' }
  }, {
    label: 'sidebar.comment',
    icon: 'fas fa-comments',
    uri: { name: 'dashboard.comment' }
  }, {
    label: 'sidebar.tag',
    icon: 'fas fa-tags',
    uri: { name: 'dashboard.tag' }
  }, {
    label: 'sidebar.category',
    icon: 'fas fa-list-alt',
    uri: { name: 'dashboard.category' }
  }, {
    label: 'sidebar.link',
    icon: 'fas fa-globe',
    uri: { name: 'dashboard.link' }
  }]
}, {
  label: 'sidebar.modules.base',
  children: [{
    label: 'sidebar.user',
    icon: 'fas fa-users',
    uri: { name: 'dashboard.user' }
  }, {
    label: 'sidebar.file',
    icon: 'fas fa-folder',
    uri: { name: 'dashboard.file' }
  }],
}, {
  label: 'sidebar.modules.system',
  children: [{
    label: 'sidebar.visitor',
    icon: 'fas fa-eye',
    uri: { name: 'dashboard.visitor' }
  }, {
    label: 'sidebar.role',
    icon: 'fas fa-exclamation-triangle',
    uri: { name: 'dashboard.role' }
  }, {
    label: 'sidebar.system',
    icon: 'fas fa-cogs',
    uri: { name: 'dashboard.system' }
  }]
}]
