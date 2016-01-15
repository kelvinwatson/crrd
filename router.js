Router.map(function () {
  this.route('android', { //route named android and uses template called android
    path: '/',  //and can be reached by going to site.com/ or localhost:3000
  });
  this.route('admin');  // By default, path = '/admin', template = 'admin'
});
