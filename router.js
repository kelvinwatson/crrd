/*Iron Router*/
Router.route('/', function(){ //when user navigates to /
  fetchAllData();
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

function fetchAllData(){
  fetchReuseData();
  fetchRepairData();
}

function fetchReuseData(){
  fetchReuseCategories();
  fetchReuseItems();
  fetchReuseBusinesses();
}

function fetchReuseCategories(){
  Meteor.call('getReuseCategories', function (err, data) {
    var reuseCategories = data;
    if (!err) {
      Session.setPersistent('reuseCategories', data);
      //console.log(Session.get('reuseCategories'));
    }
  });
}

function fetchReuseItems(){
  if(Session.get('reuseCategories')){
    var reuseCategoriesArr = Session.get('reuseCategories');
    var reuseItemsArr = [];
    for(let i=0, lenC=reuseCategoriesArr.length; i<lenC; i++){
      Meteor.call('getReuseItems', reuseCategoriesArr[i].name, function (err, data) {
        var reuseItems = data;
        if (!err) {
          Session.setPersistent('reuseItemsInCategory'+reuseCategoriesArr[i].name, data);
          for(let j=0, lenI=reuseItems.length; j<lenI; j++){
            //console.log(reuseItems[j]);
            reuseItemsArr.push(reuseItems[j]);
            Session.setPersistent('reuseItems',reuseItemsArr);
          }
        }
      });
    }

  }
}

function fetchReuseBusinesses(){
  if(Session.get('reuseItems')){
    var reuseItemsArr=Session.get('reuseItems');
    for(var i=0, lenI=reuseItemsArr.length; i<lenI; i++){
      console.log(reuseItemsArr[i].name);
      Meteor.call('getReuseBusinesses', reuseItemsArr[i].name, function (err, data) {
        var reuseBusinessesArr = data;
        if (!err) {
          //console.log("FETCHED REUSE BUSINESSES for"+reuseItemsArr[i].name);
          Session.setPersistent('reuseBusinessesForItem'+reuseItemsArr[i].name, reuseBusinessesArr);
          for(var j=0, lenB=reuseBusinessesArr.length; j<lenB; j++){
              console.log(reuseBusinessArr[j]);
              console.log(reuseBusinessArr[j].name);
              Session.setPersistent('reuseBusiness'+reuseBusinessesArr[j].name,reuseBusinessesArr[j]);
          }
        }
      });
    }
  }
  //console.log("SESSION NOT SET!");
}

function fetchRepairData(){
  fetchRepairItems();
  fetchRepairBusinesses();
}

function fetchRepairItems(){
  Meteor.call('getRepairItems', function (err, data) {
    var repairItems = data;
    if (!err) {
      Session.setPersistent('repairItems', data);
    }
  });
}

function fetchRepairBusinesses(){
  if(Session.get('repairItems')){
    var repairItemsArr=Session.get('repairItems');
    for(let i=0,lenR=repairItemsArr.length; i<lenR; i++){
      //console.log(repairItemsArr[i]);
      Meteor.call('getRepairBusinesses',repairItemsArr[i].name,function(err,data){
        if(!err){
          Session.setPersistent('repairBusinessesFor'+repairItemsArr[i].name,data); //Session.setPersistent('repairBusinessessFor_',selectedItem);
          //console.log(Session.get('repairBusinessesFor'+repairItemsArr[i].name));
          var repairBusinessesArr = Session.get('repairBusinessesFor'+repairItemsArr[i].name);
          for(let j=0, lenB=repairBusinessesArr.length; j<lenB; j++){
            Session.setPersistent(repairBusinessesArr[j].name, repairBusinessesArr[j]);
            //console.log(Session.get(repairBusinessesArr[j].name));
          }
        }
      });
    }
  }
}

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
  var self = this;
  var selectedRepair = 'Repair';
  var repairItemName = this.params.itemName;
  var repairBusinessName = this.params.businessName;
  var breadCrumbs = 'android_repair_business_bread_crumbs';
  var title = repairBusinessName;
  this.layout('android');
  this.render(breadCrumbs,{
    to: 'bread_crumbs',
    data: function(){
      return { //one or both of selectedItem / selectedBusiness will be undefined
        selectedRepair: selectedRepair,
        repairItem: repairItemName,
        repairBusiness: repairBusinessName
      }
    }
  });
  this.render('loading_template',{
    to:'main_content'
  });
  this.render('blank_template',{
    to: 'map'
  });
  if(Session.get(repairBusinessName)){
    console.log("cached data");
    var repairBusiness = Session.get(repairBusinessName);
    self.render('business_profile',{
      to: 'main_content', //yield main_content
      data: function() {
        return {
          title: title,
          selectedRepair: selectedRepair,
          repairItem: repairItemName,
          businessName: repairBusiness.name,
          businessStreet: repairBusiness.street,
          businessCity: repairBusiness.city,
          businessState: repairBusiness.state,
          businessZip: repairBusiness.zip,
          businessPhone: repairBusiness.phone,
          businessHours: repairBusiness.hours,
          businessWebsite: repairBusiness.website,
          businessLat: repairBusiness.lat,
          businessLng: repairBusiness.lng,
          businessInfo: repairBusiness.info,
        };
      }
    });
  }else{
    console.log("NEW data");
    Meteor.call('getRepairBusiness', selectedBusiness, function (err, data) {
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
              businessName: repairBusiness.name,
              businessStreet: repairBusiness.street,
              businessCity: repairBusiness.city,
              businessState: repairBusiness.state,
              businessZip: repairBusiness.zip,
              businessPhone: repairBusiness.phone,
              businessHours: repairBusiness.hours,
              businessWebsite: repairBusiness.website,
              businessLat: repairBusiness.lat,
              businessLng: repairBusiness.lng,
              businessInfo: repairBusiness.info,
            };
          }
        });
      }
    });
  }
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
  if(Session.get('repairBusinessesFor'+selectedItem)){
    Session.setPersistent('reuseMap',false);
    Session.setPersistent('repairMap',true);
    console.log("already fetched these businesses! woot!");
    console.log(Session.get('repairBusinessesFor'+selectedItem));
    var repairBusinesses = Session.get('repairBusinessesFor'+selectedItem)
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
  } else{
    console.log("fetching for the first time! boo");
    Meteor.call('getRepairBusinesses', selectedItem, function (err, data) {
      var repairBusinesses = data;
      if (!err) {
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
  }
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


Router.route('/reuse/reuseCat/:category/reuseItem/:itemName/reuseBusiness/:businessName', function(){
  console.log("OK???");
  var self = this;
  var selectedReuse = 'Reuse';
  var selectedCategory = this.params.category;
  var selectedItem = this.params.itemName;
  var selectedBusiness = this.params.businessName;
  var breadCrumbs = 'android_reuse_business_bread_crumbs';
  var title = selectedBusiness;
  this.layout('android');
  this.render(breadCrumbs,{
    to: 'bread_crumbs',
    data: function(){
      return { //one or both of selectedItem / selectedBusiness will be undefined
        selectedReuse: selectedReuse,
        selectedItem: selectedItem,
        selectedCategory: selectedCategory,
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
  if (Session.get('reuseBusiness'+selectedBusiness)) {
    var reuseBusiness = Session.get('reuseBusiness'+selectedBusiness);
    console.log("reuseBusinessCached");
    console.log(reuseBusiness.name);
    console.log(reuseBusiness.phone);
    this.render('business_profile',{
      to: 'main_content', //yield main_content
      data: function() {
        return {
          title: title,
          selectedReuse: selectedReuse,
          selectedItem: selectedItem,
          selectedCategory: selectedCategory,
          selectedBusiness: selectedBusiness,
          businessName: reuseBusiness.name,
          businessStreet: reuseBusiness.street,
          businessCity: reuseBusiness.city,
          businessState: reuseBusiness.state,
          businessZip: reuseBusiness.zip,
          businessPhone: reuseBusiness.phone,
          businessHours: reuseBusiness.hours,
          businessWebsite: reuseBusiness.website,
          businessLat: reuseBusiness.lat,
          businessLng: reuseBusiness.lng,
          businessInfo: reuseBusiness.info,
        };
      }
    });
  }else{
    Meteor.call('getReuseBusiness', selectedBusiness, function (err, data) {
      var reuseBusiness = data;
      console.log("getReuseBusiness");
      console.log(data);
      if (!err) {
        Session.setPersistent('selectedBusiness', data);
        Session.setPersistent('selectedItem', selectedItem);
        Session.setPersistent('selectedCategory', selectedCategory);
        self.render('business_profile',{
          to: 'main_content', //yield main_content
          data: function() {
            return {
              title: title,
              selectedReuse: selectedReuse,
              selectedItem: selectedItem,
              selectedCategory: selectedCategory,
              selectedBusiness: selectedBusiness,
              businessName: reuseBusiness.name,
              businessStreet: reuseBusiness.street,
              businessCity: reuseBusiness.city,
              businessState: reuseBusiness.state,
              businessZip: reuseBusiness.zip,
              businessPhone: reuseBusiness.phone,
              businessHours: reuseBusiness.hours,
              businessWebsite: reuseBusiness.website,
              businessLat: reuseBusiness.lat,
              businessLng: reuseBusiness.lng,
              businessInfo: reuseBusiness.info,
            };
          }
        });
      }
    });
  }
});


Router.route('/reuse/reuseCat/:category/reuseItem/:itemName', function(){
  var self = this;
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
  if(Session.get('reuseBusinessesForItem'+selectedItem)){
    Session.setPersistent('reuseMap',true);
    Session.setPersistent('repairMap',false);
    var reuseBusinesses = Session.get('reuseBusinessesForItem'+selectedItem);
    this.render(googleMap,{
      to: 'map', //yield map
      data: function(){
        return {
          reuseTitle: reuseTitle,
          selectedReuse: selectedReuse,
          selectedRepair: null,
          selectedItem: selectedItem,
          reuseBusinesses: reuseBusinesses
        };
      }
    });
    this.render('android_list_group',{
      to: 'main_content', //yield main_content
      data: function() {
        return {
          reuseTitle: reuseTitle,
          selectedReuse: selectedReuse,
          selectedRepair: null,
          selectedItem: selectedItem,
          reuseBusinesses: reuseBusinesses
        };
      }
    });
  }else{
    Meteor.call('getReuseBusinesses', selectedItem, function (err, data) {
      var reuseBusinesses = data;
      if (!err) {
        console.log("GOT REUSE BUSINESSES for"+selectedItem);
        console.log(reuseBusinesses);
        Session.setPersistent('reuseBusinesses', data);
        Session.setPersistent('selectedCategory', selectedCategory);
        Session.setPersistent('selectedItem', selectedItem);
        Session.setPersistent('reuseMap',true);
        Session.setPersistent('repairMap',false);
        self.render(googleMap,{
          to: 'map', //yield map
          data: function(){
            return {
              reuseTitle: reuseTitle,
              selectedReuse: selectedReuse,
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
              selectedReuse: selectedReuse,
              selectedRepair: null,
              selectedItem: selectedItem,
              reuseBusinesses: reuseBusinesses
            };
          }
        });
      }
    });
  }
});

Router.route('/reuse/reuseCat/:category', function(){
  var self = this;
  var selectedCategory = this.params.category;
  Session.setPersistent('reuseCategory',selectedCategory);
  this.layout('android');
  this.render('android_reuse_category_bread_crumbs',{
    to: 'bread_crumbs',
    data: function(){
      return {
        selectedCategory: selectedCategory,
      }
    }
  });
  this.render('blank_template',{
    to: 'map'
  });
  this.render('loading_template',{
    to: 'main_content'
  });
  if(Session.get('reuseItemsInCategory'+selectedCategory)){
    var reuseItems = Session.get('reuseItemsInCategory'+selectedCategory);
    //console.log("CACHED: reuseItems"+reuseItems);
    this.render('android_list_group',{
      to: 'main_content', //yield main_content
      data: function() {
        return {
          reuseTitle: 'Select reuse item',
          selectedReuse: 'Reuse',
          reuseItems: reuseItems
        };
      }
    });
  }else{
    console.log("NEW: reuseItems");
    Meteor.call('getReuseItems', selectedCategory, function (err, data) {
      var reuseItems = data;
      if (!err) {
        Session.setPersistent('reuseItemsInCategory'+selectedCategory, data);
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
  }
});



Router.route('/reuse', function(){
  var self = this;
  this.layout('android');
  this.render('android_reuse_bread_crumbs',{
    to: 'bread_crumbs',
  });
  this.render('blank_template',{
    to: 'map'
  });
  this.render('loading_template',{
    to: 'main_content'
  });
  if(Session.get('reuseCategories')){
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
