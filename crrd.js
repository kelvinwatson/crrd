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

//https://forums.meteor.com/t/how-to-return-value-on-meteor-call-in-client/1277/2
//https://forums.meteor.com/t/how-to-return-value-on-meteor-call-in-client/1277/2
  Template.android_list_group.helpers({
    'title': function(){
      return Session.get('selectedAction')+" your item";
    },
    'items': function(){
      Meteor.call('getRepairItems', function (err, data) {
        if (!err) {
          console.log("data="+data);
          Session.set('repairItems', data);
        }
      })
      console.log(Session.get('repairItems'));
      return Session.get('repairItems');
    }
  });

  Template.android_list_group.events({
    'touchstart .list-group-item, click .list-group-item': function(){
      console.log(this); //figure out what the object is that was clicked
      Router.go('/'+Session.get('selectedAction')+"?itemCat="+this.name);
    },
  });
  /*Session.setDefault('counter', 0);

  Template.hello.helpers({
    counter: function () {
      return Session.get('counter');
    }
  });

  Template.hello.events({
    'click button': function () {
      // increment the counter when button is clicked
      Session.set('counter', Session.get('counter') + 1);
    }
  });*/
}

if (Meteor.isServer) {
  Meteor.startup(function () {
    // code to run on server at startup
    // var url="https://web.engr.oregonstate.edu/~watsokel/crrd/get_repair_items.php";
    // var resp = HTTP.get(url);
    // Session.set('repairItems',resp.data);
    // console.log("retrieved repair items and printing...");
    // console.dir(Session.get('repairItems'));
  });
  Meteor.methods({
    getRepairItems: function () {
      var url="https://web.engr.oregonstate.edu/~watsokel/crrd/get_repair_items.php";
      var resp = HTTP.get(url);
      console.log("resp.data="+resp.data);
      return resp.data;
    }
  });

}
