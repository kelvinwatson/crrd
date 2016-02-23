/* CLIENT */
if (Meteor.isClient) {
  /* Initialize ripple effect */
  Template.android.rendered = function(){
    $.material.init();
  };
  Template.admin.rendered = function(){
    $.material.init();
  };

  Template.reuse_repair_recycle_panels.events({
    'click #reuse_panel': function(){
      Session.set('selectedAction','reuse');
      Router.go('/reuse');
    },
    'click #repair_panel': function(){
      Session.set('selectedAction','repair');
      Router.go('/repair');
    },
    'click #recycle_panel':function(){
      Session.set('selectedAction','recycle');
      Router.go('/recycle');
    }
  });

  Template.android_repair_business_bread_crumbs.helpers({
    'item': function(){
      return this.repairItem;
    },
    'business': function(){
      return this.repairBusinessName;
    },
  });

  Template.android_repair_item_bread_crumbs.helpers({
    'item': function(){
      return this.selectedItem;
    }
  });

  Template.android_reuse_business_bread_crumbs.helpers({
    'item': function(){
      return this.selectedItem;
    },
    'business': function(){
      return this.selectedBusiness;
    },
    'category': function(){
      return this.selectedCategory;
    },
  });

  Template.android_reuse_category_bread_crumbs.helpers({
    'category': function(){
      return this.selectedCategory;
    },
  });

  Template.android_reuse_item_bread_crumbs.helpers({
    'item': function(){
      return this.selectedItem;
    },
    'category': function(){
      return this.selectedCategory;
    },
  });



  /* MAP */
  Template.android_map.onCreated(function() {
    Blaze._allowJavascriptUrls();
    var self = this.data;
    GoogleMaps.ready('businessesMap', function(map) {
      if(Session.get('repairMap') && !Session.get('reuseMap')){
        if(self){
          var repairBusinesses = self.repairBusinesses;
          let bounds = new google.maps.LatLngBounds();
          for(let k=0; k<repairBusinesses.length; k++){
            (function(){
              if(repairBusinesses[k].lat && repairBusinesses[k].lng){
                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(repairBusinesses[k].lat,repairBusinesses[k].lng),
                  map: map.instance
                });
                new google.maps.event.addListener(marker, 'click', function(){
                  var infoStr = repairBusinesses[k].name+'<br>'+
                  repairBusinesses[k].street+' '+repairBusinesses[k].city+
                    ', '+repairBusinesses[k].state;
                  var infowindow = new google.maps.InfoWindow({
                    content: infoStr
                  });
                  infowindow.open(map.instance,marker);
                });
                bounds.extend(marker.position);
              }
            }())
          }
          map.instance.fitBounds(bounds);
        }
      }else if(Session.get('reuseMap')){
        if(self){
          var reuseBusinesses = self.reuseBusinesses;
          let bounds = new google.maps.LatLngBounds();
          for(let k=0; k<reuseBusinesses.length; k++){
            (function(){
              if(reuseBusinesses[k].lat && reuseBusinesses[k].lng){
                var marker = new google.maps.Marker({
                  position: new google.maps.LatLng(reuseBusinesses[k].lat,reuseBusinesses[k].lng),
                  map: map.instance
                });
                new google.maps.event.addListener(marker, 'click', function(){
                  var infoStr = reuseBusinesses[k].name+'<br>'+
                  reuseBusinesses[k].street+' '+reuseBusinesses[k].city+
                    ', '+reuseBusinesses[k].state;
                  var infowindow = new google.maps.InfoWindow({
                    content: infoStr
                  });
                  infowindow.open(map.instance,marker);
                });
                bounds.extend(marker.position);
              }
            }())
          }
          map.instance.fitBounds(bounds);
        }
      }
    });
  });

  //runs a second time
  Template.android_map.helpers({
    'mapOptions': function(){
      if (GoogleMaps.loaded()){
        return{
          center: new google.maps.LatLng(44.5667, -123.2833),
          zoom:14,
          maxZoom:16
        };
      }
    }
  });

  Template.android_map.onRendered(function(){
    var self = this.data;
    Blaze._allowJavascriptUrls();
    GoogleMaps.load();
  });

  Template.business_profile.helpers({
    'name': function(){
      return this.title;
    },
    'address': function(){
      var str = this.businessStreet? this.businessStreet:null
      var cit = this.businessCity? this.businessCity:null;
      var sta = this.businessState? this.businessState:null;
      var zip = this.businessZip? this.businessZip:null;
      if(str && cit && sta && zip){
        return str+", "+cit+", "+sta+" "+zip;
      } else if(str && cit && sta && !zip){
        return str+", "+cit+", "+sta;
      } else if(str && !cit && sta && !zip){
        return str+", "+sta;
      } else if(!str && cit && sta && zip){
        return cit+", "+sta+" "+zip;
      } else if(!str && cit && sta && !zip){
        return cit+", "+sta;
      } else if(!str && !cit && sta && zip){
        return sta+" "+zip;
      } else if(!str && !cit && sta && !cit){
        return sta;
      } else return "";
    },
    'phone': function(){
      return this.businessPhone? this.businessPhone:"";
    },
    'hours': function(){
      return this.businessHours? this.businessHours:"";
    },
    'website': function(){
      return this.businessWebsite? this.businessWebsite:"";
    },
    'info': function(){
      return this.businessInfo? this.businessInfo:"";
    }
  });


  //https://forums.meteor.com/t/how-to-return-value-on-meteor-call-in-client/1277/2
  Template.android_list_group.helpers({
    'title': function(){
      if(this.repairTitle){
        return this.repairTitle;
      } else if (this.repairItem){
        return this.repairItem;
      } else if(this.repairBusiness){
        return this.repairBusiness;
      } else if (this.reuseTitle){
        return this.reuseTitle;
      }
    },
    'items': function(){
      if(this.repairItems){
        return this.repairItems;
      } else if(this.repairBusinesses){
        return this.repairBusinesses;
      } else if (this.repairBusiness){
        return this.repairBusiness;
      } else if(this.reuseCategories){
        return this.reuseCategories;
      } else if(this.reuseItems){
        return this.reuseItems;
      } else if(this.reuseBusinesses){
        return this.reuseBusinesses;
      } else if(this.reuseBusiness){
        return this.reuseBusiness;
      }
    }
  });

  Template.android_list_group.events({
    'click .list-group-item': function(){
      var route;
      if(this.type=='repairItem'){ //user selected an item
        Session.set('selectedAction','repair');
        Session.setPersistent('selectedItem',this.name);
        route = '/'+Session.get('selectedAction')+'/repairItem/'+Session.get('selectedItem');
      } else if (this.type=='repairBusiness'){
        Session.set('selectedAction','repair');
        Session.setPersistent('selectedBusiness',this.name);
        route='/'+Session.get('selectedAction')+'/repairItem/'+Session.get('selectedItem')+'/repairBusiness/'+Session.get('selectedBusiness');
      } else if (this.type=="reuseCategory"){
        Session.set('selectedAction','reuse');
        route = '/'+Session.get('selectedAction')+'/reuseCat/'+this.name;
      } else if(this.type=="reuseItem"){
        Session.set('selectedAction','reuse');
        route = '/reuse/reuseCat/'+Session.get('reuseCategory')+'/reuseItem/'+this.name;
      } else if(this.type=="reuseBusiness"){
        route = '/reuse/reuseCat/'+Session.get('selectedCategory')+'/reuseItem/'+Session.get('selectedItem')+'/reuseBusiness/'+this.name;
      }
      Router.go(route);
    },
  });
}


/* SERVER */
if (Meteor.isServer) {
  Meteor.startup(function () {
  });
  Meteor.methods({
    getRepairItems: function () {
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/repair_items.php";
      let resp = HTTP.get(url);
      return resp.data;
    },
    getRepairBusinesses: function (item) {
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/repair_businesses.php?repairItem="+item;
      let resp = HTTP.get(url);
      return resp.data;
    },
    getAllRepairBusinesses: function () {
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/repair_businesses_all.php";
      let resp = HTTP.get(url);
      return resp.data;
    },
    getRepairBusiness: function (business) {
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/repair_business.php?repairBusiness="+business;
      let resp = HTTP.get(url);
      return resp.data;
    },
    getReuseCategories: function(){
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/reuse_categories.php";
      let resp = HTTP.get(url);
      return resp.data;
    },
    getReuseItems: function(category){
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/reuse_items.php?reuseCategory="+category;
      let resp = HTTP.get(url);
      return resp.data;
    },
    getAllReuseItems: function(){
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/reuse_items_all.php";
      let resp = HTTP.get(url);
      return resp.data;
    },
    getReuseBusinesses: function(item){
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/reuse_businesses.php?reuseItem="+item;
      let resp = HTTP.get(url);
      return resp.data;
    },
    getReuseBusiness: function(business){
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/reuse_business.php?reuseBusiness="+business;
      let resp = HTTP.get(url);
      return resp.data;
    },
    getAllReuseBusinesses: function(){
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/reuse_businesses_all_items.php";
      let resp = HTTP.get(url);
      return resp.data;
    }
  });
}
