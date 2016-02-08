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

Router.route('/recycle', function(){ //when user navigates to /
  this.layout('android'); //use layout called template name="android"
  this.render('android_recycle_bread_crumbs',{
    to: 'bread_crumbs'
  }); //render android_home_bread_crumbs template into yield breadcrubs
  this.render('recycle_links',{
    to: 'main_content'
  });
});



Router.route('/repair/repairItem/:itemName/repairBusiness/:businessName', function(){
  console.log("NEW ROUTE");
  var self = this;
  var selectedRepair = 'Repair';
  var selectedItem = this.params.itemName;
  var selectedBusiness = this.params.businessName;
  var breadCrumbs = 'android_repair_business_bread_crumbs';
  var title = selectedBusiness;
  this.layout('android');
  this.render(breadCrumbs,{
    to: 'bread_crumbs',
    data: function(){
      return { //one or both of selectedItem / selectedBusiness will be undefined
        selectedRepair: selectedRepair,
        selectedItem: selectedItem,
        selectedBusiness: selectedBusiness
      }
    }
  });
  this.render('loading_template',{
    to:'main_content'
  });
  this.render('blank_template',{
    to: 'map'
  });
  Meteor.call('getRepairBusiness', selectedBusiness, function (err, data) {
    console.log('getting business');
    var repairBusiness = data;
    if (!err) {
      Session.setPersistent(selectedBusiness, data);
      self.render('business_profile',{
        to: 'main_content', //yield main_content
        data: function() {
          return {
            title: title,
            selectedRepair: selectedRepair,
            selectedItem: selectedItem,
            repairBusiness: repairBusiness
          };
        }
      });
    }
  });
});




Router.route('/repair/repairItem/:itemName', function(){
  var self = this;
  var selectedRepair = 'Repair';
  var selectedItem = this.params.itemName;
  var breadCrumbs = 'android_repair_item_bread_crumbs';
  var googleMap = 'android_map'; //show a map of businesses for that item
  var repairTitle = 'Businesses that Repair '+selectedItem;
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
});

/*User selected repair panel, load items */
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

Router.route('/reuse', function(){
  console.log("REUSE! ROUTER");
  var self = this;
  this.layout('android');
  this.render('android_reuse_bread_crumbs',{
    to: 'bread_crumbs',
  });
  this.render('loading_template',{
    to: 'main_content'
  });
  if(Session.get('reuseCategories')){
    console.log("using CACHED cats");
    console.log(Session.get('reuseCategories'));
    self.render('android_list_group',{
      to: 'main_content', //yield main_content
      data: function() {
        return {
          reuseTitle: 'Select reuse item category',
          selectedReuse: 'Reuse',
          reuseCategories: Session.get('reuseCategories')
        };
      }
    });
  } else {
    Meteor.call('getReuseCategories', function (err, data) {
      console.log("using NEW cats");
      var reuseCategories = data;
      if (!err) {
        Session.setPersistent('reuseCategories', data);
        self.render('android_list_group',{
          to: 'main_content', //yield main_content
          data: function() {
            return {
              reuseTitle: 'Select reuse item category',
              selectedReuse: 'Reuse',
              reuseCategories: reuseCategories
            };
          }
        });
      }
    });
  }
});
