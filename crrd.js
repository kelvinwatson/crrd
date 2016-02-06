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

  Template.android_repair_item_bread_crumbs.helpers({
    'item': function(){
      return this.selectedItem;
    }
  });

  /* MAP */
  //created, helper, rendered
  Template.android_map.onCreated(function() {
    Blaze._allowJavascriptUrls();
    //console.log("ON MAP CREATED, printing this:");
    GoogleMaps.ready('businessesMap', function(map) {
      //console.log("map ready!");
      var repairBusinesses = Session.get('repairBusinesses');
      if(repairBusinesses){
        let bounds = new google.maps.LatLngBounds();
        for(let k=0; k<repairBusinesses.length; k++){
          (function(){
            var marker = new google.maps.Marker({
              position: new google.maps.LatLng(repairBusinesses[k].lat,repairBusinesses[k].lng),
              map: map.instance
            });
            new google.maps.event.addListener(marker, 'click', function(){
              console.log('clicked map!');
              var infoStr = repairBusinesses[k].name+'<br>'+
              repairBusinesses[k].street+' '+repairBusinesses[k].city+
                ', '+repairBusinesses[k].state;
              var infowindow = new google.maps.InfoWindow({
                content: infoStr
              });
              infowindow.open(map.instance,marker);
            });
            bounds.extend(marker.position);
          }())
        }
        map.instance.fitBounds(bounds);
      }
    });
  });

  //runs a second time
  Template.android_map.helpers({
    'mapOptions': function(){
      //console.log("MAP HELPER mapOptions");
      if (GoogleMaps.loaded()){
        //console.log("map loaded");
        return{
          center: new google.maps.LatLng(44.5667, -123.2833),
          zoom:14,
          maxZoom:16
        };
      }
    }
  });

  Template.android_map.onRendered(function(){
    Blaze._allowJavascriptUrls();
    //console.log("ON MAP RENDERED, printing THIS="+this);
    //console.log(this);
    GoogleMaps.load();
  });


  //https://forums.meteor.com/t/how-to-return-value-on-meteor-call-in-client/1277/2
  Template.android_list_group.helpers({
    'title': function(){
      if(this.repairTitle){
        return this.repairTitle;
      } else if (this.selectedItem){
        return this.selectedItem;
      } else if (this.reuseTitle){
        return this.repairTitle;
      }
    },
    'items': function(){
      if(this.repairItems){
        return this.repairItems;
      } else if(this.repairBusinesses){
        return Session.get('repairBusinesses');
      } else if (this.selectedBusiness){
        return Session.get('selectedBusiness');
      } else if(this.reuseCategories){
        return Session.get('reuseCategories');      
      }
    }
  });

  Template.android_list_group.events({
    'click .list-group-item': function(){
      //console.log(this); //figure out what the object is that was clicked
      var route;
      if(this.type=='repairItem'){
        //console.log("event is /repairItem/actualITem");
        Session.set('selectedAction','repair');
        route = '/'+Session.get('selectedAction')+'/repairItem/'+this.name;
      } else if (this.type=='repairBusiness'){
        Session.set('selectedAction','repair');
        route='/'+Session.get('selectedAction')+'/repairBusiness/'+this.name;
      } else if (this.type=="reuseCategory"){
        Session.set('selectedAction','reuse');
        route = '/'+Session.get('selectedAction')+'/reuseCat/'+this.name;
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
    getReuseCategories: function(){
      console.log('getting cats!');
      let url="https://web.engr.oregonstate.edu/~watsokel/crrd/reuse_categories.php";
      let resp = HTTP.get(url);
      return resp.data;
    },
  });
}
