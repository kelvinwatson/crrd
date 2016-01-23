repairItems = null;

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

  Template.android_repair_item_bread_crumbs.helpers({
    'item': function(){
      return this.selectedItem;
    }
  });

  Template.android_map.onCreated(function() {
    Blaze._allowJavascriptUrls();
  });
  //onRendereed -> helers -> onCreated
  Template.android_map.onRendered(function(){
    console.log("template rendered, printing this:");
    console.log(this);
    Meteor.call('getRepairBusinesses', this.selectedItem, function (err, data) {
      if (!err) {
        Session.set('repairBusinesses', data);
      }
    });
    GoogleMaps.load();
  });


  Template.android_map.onCreated(function() {
    GoogleMaps.ready('businessesMap', function(map) {
      console.log("map ready!");
      var repairBusinesses = Session.get('repairBusinesses');
      console.log(repairBusinesses);
      if(repairBusinesses){
        let bounds = new google.maps.LatLngBounds();
        for(let k=0; k<repairBusinesses.length; k++){
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(repairBusinesses[k].lat,repairBusinesses[k].lng),
            map: map.instance
          });
          bounds.extend(marker.position);
        }
        map.instance.fitBounds(bounds);
      }
    });
  });

  Template.android_map.helpers({
    'mapOptions': function(){
      if (GoogleMaps.loaded()){
        console.log("map loaded");
        return{
          center: new google.maps.LatLng(44.5667, -123.2833),
          zoom:14,
          maxZoom:16
        };
      }
    }
  });

  //https://forums.meteor.com/t/how-to-return-value-on-meteor-call-in-client/1277/2
  //https://forums.meteor.com/t/how-to-return-value-on-meteor-call-in-client/1277/2
  Template.android_list_group.helpers({
    'title': function(){
      if(this.repairTitle){
        return this.repairTitle;
      } else if (this.selectedItem){
        return this.selectedItem;
      }
    },
    'items': function(){
      if(this.selectedRepair){
        if(!Session.get('repairItems')){
          Meteor.call('getRepairItems', function (err, data) {
            if (!err) {
              Session.set('repairItems', data);
            }
          })
        }
        return Session.get('repairItems');
      } else if(this.selectedItem){
        console.log("passing this.selectedItem="+this.selectedItem);
        Meteor.call('getRepairBusinesses', this.selectedItem, function (err, data) {
          if (!err) {
            Session.set('repairBusinesses', data);
          }
        });
        return Session.get('repairBusinesses');
      } else if (this.selectedBusiness){
          //meteor.call getBusinessProfile
      }
    }
  });

  Template.android_list_group.events({
    'touchstart .list-group-item, click .list-group-item': function(){
      console.log(this); //figure out what the object is that was clicked
      if(this.type=='repairItem' || this.type=='repairBusiness'){
        Session.set('selectedAction','repair');
      }
      console.log("Session.get('selectedAction')="+Session.get('selectedAction'));
      Router.go('/'+Session.get('selectedAction')+"?"+this.type+"="+this.name);
    },
  });
}

if (Meteor.isServer) {
  Meteor.startup(function () {

  });
  Meteor.methods({
    getRepairItems: function () {
      var url="https://web.engr.oregonstate.edu/~watsokel/crrd/get_repair_items.php";
      var resp = HTTP.get(url);
      return resp.data;
    },
    getRepairBusinesses: function (item) {
      var url="https://web.engr.oregonstate.edu/~watsokel/crrd/get_repair_businesses.php?item="+item;
      var resp = HTTP.get(url);
      return resp.data;
    },
  });

}
