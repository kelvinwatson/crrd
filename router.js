/*Iron Router*/
Router.route('/', function(){ //when user navigates to /
  this.layout('android'); //use layout called template name="android"
  this.render('android_home_bread_crumbs',{
    to: 'bread_crumbs'
  }); //render android_home_bread_crumbs template into yield breadcrubs
  this.render('blank_template',{
    to: 'map'
  });
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
    console.log('repairBusiness=');
    console.log(repairBusiness);
    if (!err) {
      Session.setPersistent(selectedBusiness, data);
      self.render('business_profile',{
        to: 'main_content', //yield main_content
        data: function() {
          return {
            title: title,
            selectedRepair: selectedRepair,
            selectedItem: selectedItem,
            businessName: repairBusiness.name,
            businessStreet: repairBusiness.street,
            businessCity: repairBusiness.city,
            businessState: repairBusiness.state,
            businessZip: repairBusiness.zip,
            businessLat: repairBusiness.lat,
            businessLng: repairBusiness.lng,
            businessInfo: repairBusiness.info,
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
      Session.setPersistent('reuseMap',false);
      Session.setPersistent('repairMap',true);
      self.render(googleMap,{
        to: 'map', //yield map
        data: function(){
          return { //one or both of selectedItem / selectedBusiness will be undefined
            repairTitle: repairTitle,
            selectedRepair: selectedRepair,
            selectedReuse: null,
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
            selectedReuse: null,
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


Router.route('/reuse/reuseCat/:category/reuseItem/:itemName', function(){
  var self = this;
  console.log("/reuse/reuseCat/:category/reuseItem/:itemName ROUTE");
  var selectedReuse = 'Reuse';
  var selectedCategory = this.params.category;
  var selectedItem = this.params.itemName;
  var breadCrumbs = 'android_reuse_item_bread_crumbs';
  var googleMap = 'android_map'; //show a map of businesses for that item
  var reuseTitle = 'Businesses that Accept '+selectedItem+' for Reuse/Resale';
  this.layout('android');
  this.render(breadCrumbs,{
    to: 'bread_crumbs',
    data: function(){
      return { //one or both of selectedItem / selectedBusiness will be undefined
        selectedReuse: selectedReuse,
        selectedCategory: selectedCategory,
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
  Meteor.call('getReuseBusinesses', selectedItem, function (err, data) {
    console.log('using NEW REUSE BUSINESSES data');
    var reuseBusinesses = data;
    if (!err) {
      Session.setPersistent('reuseBusinesses', data);
      Session.setPersistent('reuseMap',true);
      Session.setPersistent('repairMap',false);
      self.render(googleMap,{
        to: 'map', //yield map
        data: function(){
          return { //one or both of selectedItem / selectedBusiness will be undefined
            reuseTitle: reuseTitle,
            selectedReuse: selectedReuse, //should be undefined
            selectedRepair: null,
            selectedItem: selectedItem,
            reuseBusinesses: reuseBusinesses
          };
        }
      });
      self.render('android_list_group',{
        to: 'main_content', //yield main_content
        data: function() {
          return {
            reuseTitle: reuseTitle,
            selectedReuse: selectedReuse, //should be undefined
            selectedRepair: null,
            selectedItem: selectedItem,
            reuseBusinesses: reuseBusinesses
          };
        }
      });
    }
  });
});

Router.route('/reuse/reuseCat/:category', function(){
  console.log("REUSE CAT ROUTER");
  var self = this;
  var category = this.params.category;
  this.layout('android');
  this.render('android_reuse_category_bread_crumbs',{
    to: 'bread_crumbs',
  });
  this.render('loading_template',{
    to: 'main_content'
  });
  Meteor.call('getReuseItems', category, function (err, data) {
    console.log("GOT reuse items");
    console.log(data);
    var reuseItems = data;
    if (!err) {
      Session.setPersistent('reuseItems', data);
      Session.setPersistent('reuseCategory',category);
      self.render('android_list_group',{
        to: 'main_content', //yield main_content
        data: function() {
          return {
            reuseTitle: 'Select reuse item',
            selectedReuse: 'Reuse',
            reuseItems: reuseItems
          };
        }
      });
    }
  });
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
