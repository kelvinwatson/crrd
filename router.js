/*Iron Router*/
Router.route('/', function(){ //when user navigates to /
  this.layout('android'); //use the layout called template name="android"
  this.render('android_home_bread_crumbs',{
    to: 'bread_crumbs'
  }); //render android_home_bread_crumbs template into yield breadcrubs
  this.render('reuse_repair_recycle_panels',{
    to: 'main_content'
  });
});

Router.route('/reuse', function(){
  this.layout('android');
  this.render('android_reuse_bread_crumbs',{
    to: 'bread_crumbs'
  });
  this.render('android_list_group',{
    to: 'main_content'
    //,data: function(){return Businesses.find().fetch()}
  });
});

Router.route('/admin'); //when user navigates to /admin, render template="admin"


//Use a session variable to determine which service (reuse, repair, recycle)



/* Router.map is deprecated
Router.map(function () {
  this.route('android', { //route name = 'android', template = 'android'
    path: '/',  //and can be reached by going to site.com/ or localhost:3000
  });
  this.route('admin');  // By default, path = '/admin', template = 'admin'
});*/
