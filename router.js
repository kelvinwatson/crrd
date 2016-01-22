/*Iron Router*/
Router.route('/', function(){ //when user navigates to /
  this.layout('android'); //use layout called template name="android"
  this.render('android_home_bread_crumbs',{
    to: 'bread_crumbs'
  }); //render android_home_bread_crumbs template into yield breadcrubs
  this.render('reuse_repair_recycle_panels',{
    to: 'main_content'
  });
});

Router.route('/reuse', {where:"server"},function(){
  this.layout('android'); //use layout called template name="android"
  this.render('android_reuse_bread_crumbs',{
    to: 'bread_crumbs'
  }); //render android_reuse_bread_crumbs template into yield breadcrubs
  this.render('android_list_group',{
    to: 'main_content',
    data: function() {
      return ReuseItemCategories.find().fetch();
    }
  });
});

Router.route('/repair', function(){
  //waitOn: function(){
  //  return Meteor.subscribe('repairItems');
  //};
  this.layout('android');
  this.render('android_repair_bread_crumbs',{
    to: 'bread_crumbs'
  });
  this.render('android_list_group',{
    to: 'main_content', //yield main_content
    data: function() {
      return {
        //page: this.page
        repairTitle : 'Select Item to be Repaired'
      };
    }
  });
  //this.subscriptions = function() {
  //  return Meteor.subscribe('allData',"repairItems", function(){
  //    console.log("data is ready!");
  //  });
  //}
});

Router.route('/recycle', function(){
  this.layout('android');
  this.render('android_recycle_bread_crumbs',{
    to: 'bread_crumbs'
  });
  this.render('android_list_group', {
    to: 'main_content'
  });
});

//Router.route('/admin'); //when user navigates to /admin, render template="admin"

Router.route('/admin', function(){
  this.layout('admin');
  this.render('admin_login_form',{
    to: 'admin_content'
  });
});

//Use a session variable to determine which service (reuse, repair, recycle)



/* Router.map is deprecated
Router.map(function () {
  this.route('android', { //route name = 'android', template = 'android'
    path: '/',  //and can be reached by going to site.com/ or localhost:3000
  });
  this.route('admin');  // By default, path = '/admin', template = 'admin'
});*/
