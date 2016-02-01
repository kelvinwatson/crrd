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


Router.route('/repair/repairItem/:itemName', function(){
  var self = this;
  var selectedRepair = 'Repair';
  var selectedItem = this.params.itemName;
  var breadCrumbs = 'android_repair_item_bread_crumbs';
  var googleMap = 'android_map'; //show a map of businesses for that item
  var repairTitle = 'Businesses that repair '+selectedItem;
  this.layout('android');
  this.render(breadCrumbs,{
    to: 'bread_crumbs',
    data: function(){
      return { //one or both of selectedItem / selectedBusiness will be undefined
        selectedRepair: selectedRepair,
        selectedItem: selectedItem,
      }
    }
  });
  this.render('blank_template',{
    to:'main_content'
  });
  this.render('loading_template',{
    to: 'map'
  });

  if(Session.get('repairBusinesses')){
    console.log('using CACHED data');
    console.log(Session.get('repairBusinesses'));
    self.render(googleMap,{
      to: 'map', //yield map
      data: function(){
        return { //one or both of selectedItem / selectedBusiness will be undefined
          repairTitle: repairTitle,
          selectedRepair: selectedRepair, //should be undefined
          selectedItem: selectedItem,
          repairBusinesses: Session.get('repairBusinesses')
        };
      }
    });
    self.render('android_list_group',{
      to: 'main_content', //yield main_content
      data: function() {
        return {
          repairTitle: repairTitle,
          selectedRepair: selectedRepair,
          selectedItem: selectedItem,
          repairBusinesses: Session.get('repairBusinesses')
        };
      }
    });
  }else{
    Meteor.call('getRepairBusinesses', selectedItem, function (err, data) {
      console.log('using NEW data');
      var repairBusinesses = data;
      if (!err) {
        Session.setPersistent('repairBusinesses', data);
        self.render(googleMap,{
          to: 'map', //yield map
          data: function(){
            return { //one or both of selectedItem / selectedBusiness will be undefined
              repairTitle: repairTitle,
              selectedRepair: selectedRepair, //should be undefined
              selectedItem: selectedItem,
              repairBusinesses: repairBusinesses
            };
          }
        });
        self.render('android_list_group',{
          to: 'main_content', //yield main_content
          data: function() {
            return {
              repairTitle: repairTitle,
              selectedRepair: selectedRepair,
              selectedItem: selectedItem,
              repairBusinesses: repairBusinesses
            };
          }
        });
      }
    });
  }
});


/*User selected repair panel */
Router.route('/repair', function(){
  var self = this;
  this.layout('android');
  this.render('android_repair_bread_crumbs',{
    to: 'bread_crumbs',
  });
  this.render('blank_template',{
    to: 'map', //yield map
  });
  this.render('loading_template',{
    to: 'main_content'
  });
  if(Session.get('repairItems')){
    console.log("using CACHED data");
    console.log(Session.get('repairItems'));
    self.render('android_list_group',{
      to: 'main_content', //yield main_content
      data: function() {
        return {
          repairTitle: 'Select item to be repaired',
          selectedRepair: 'Repair',
          repairItems: Session.get('repairItems')
        };
      }
    });
  } else {
    Meteor.call('getRepairItems', function (err, data) {
      console.log("using NEW data");
      var repairItems = data;
      if (!err) {
        Session.setPersistent('repairItems', data);
        self.render('android_list_group',{
          to: 'main_content', //yield main_content
          data: function() {
            return {
              repairTitle: 'Select item to be repaired',
              selectedRepair: 'Repair',
              repairItems: repairItems
            };
          }
        });
      }
    });
  }
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

Router.route('/admin', function(){
  this.layout('admin');
  this.render('admin_login_form',{
    to: 'admin_content'
  });
});
