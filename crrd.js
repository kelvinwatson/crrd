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
    'touchstart #reuse_panel, click #reuse_panel': function(){
      Session.set('selectedAction','reuse');
      Router.go('/reuse');
    },
    'touchstart #repair_panel, click #repair_panel': function(){
      Session.set('selectedAction','repair');
      Router.go('/repair');
    },
    'touchstart #recycle_panel, click #recycle_panel':function(){
      Session.set('selectedAction','recycle');
      Router.go('/recycle');
    }
  });

  Template.android_repair_item_bread_crumbs.helpers({
    'item': function(){
      console.log("helper="+this.selectedItem);
      return this.selectedItem;
    }
  });

  Template.android_map.helpers({
    'someLat': function(){
      return 45.528740;
    },
    'someLng': function(){
      return -122.682002;
    },
    'someArr': function(){
      var array = [ {lat:45.515769,lng:-122.681966}, {lat:45.540111,lng:-122.681888}, {lat:45.530011,lng:-122.658542}];
      return array;
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
      if(this.repairTitle){
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
        })
        return Session.get('repairBusinesses');
      }
    }
  });

  Template.android_list_group.events({
    'touchstart .list-group-item, click .list-group-item': function(){
      console.log(this); //figure out what the object is that was clicked
      console.log(Session.get('selectedAction'));
      Router.go('/'+Session.get('selectedAction')+"?item="+this.name);
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
